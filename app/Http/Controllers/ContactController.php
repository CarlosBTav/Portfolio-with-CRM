<?php

namespace App\Http\Controllers;

use App\Jobs\SendNewContactAlert;
use App\Models\Client;
use App\Models\Contact;
use App\Models\ContactMethod;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    // Guardar un nuevo contacto asociado a un cliente
    public function store(Request $request, Client $client)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20', // <--- Nuevo campo
            'notes' => 'nullable|string',         // <--- Nuevo campo
        ]);

        // 1. Crear el Contacto (Ahora con notas)
        $contact = $client->contacts()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'notes' => $request->notes,
        ]);

        // 2. Guardar Email (si hay)
        if ($request->filled('email')) {
            $contact->contactMethods()->create([
                'type' => 'email',
                'value' => $request->email,
                'details' => 'Principal'
            ]);
        }

        // 3. Guardar Teléfono (si hay) - Nuevo
        if ($request->filled('phone')) {
            $contact->contactMethods()->create([
                'type' => 'phone',
                'value' => $request->phone,
                'details' => 'Móvil'
            ]);
        }

        return back()->with('success', 'Contacto añadido correctamente.');
    }

    // Actualizar un contacto existente
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $contact->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'position' => $request->position,
            'notes' => $request->notes,
        ]);

        // Upsert email
        $emailMethod = $contact->contactMethods()->where('type', 'email')->first();
        if ($request->filled('email')) {
            if ($emailMethod) {
                $emailMethod->update([
                    'value' => $request->email,
                    'details' => 'Principal',
                ]);
            } else {
                $contact->contactMethods()->create([
                    'type' => 'email',
                    'value' => $request->email,
                    'details' => 'Principal',
                ]);
            }
        } elseif ($emailMethod) {
            $emailMethod->delete();
        }

        // Upsert phone
        $phoneMethod = $contact->contactMethods()->where('type', 'phone')->first();
        if ($request->filled('phone')) {
            if ($phoneMethod) {
                $phoneMethod->update([
                    'value' => $request->phone,
                    'details' => 'Móvil',
                ]);
            } else {
                $contact->contactMethods()->create([
                    'type' => 'phone',
                    'value' => $request->phone,
                    'details' => 'Móvil',
                ]);
            }
        } elseif ($phoneMethod) {
            $phoneMethod->delete();
        }

        return back()->with('success', 'Contacto actualizado correctamente.');
    }


    // Borrar un contacto
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contacto eliminado.');
    }

    public function storePublicMessage(Request $request): JsonResponse|RedirectResponse
    {
        $formContext = (string) $request->input('form_context', '');

        if ($formContext === 'funnel_whatsapp') {
            return $this->storeFunnelAsyncChannel($request, 'whatsapp');
        }

        if ($formContext === 'funnel_email') {
            return $this->storeFunnelAsyncChannel($request, 'email');
        }

        $isBookingRequest = $formContext === 'booking';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => $isBookingRequest
                ? 'required_if:booking_channel,Videollamada|nullable|email|max:255'
                : 'required|email|max:255',
            'phone' => $isBookingRequest
                ? 'required_if:booking_channel,Llamada telefónica,WhatsApp|nullable|string|max:40'
                : 'nullable|string|max:40',
            'content' => 'required|string|min:10',
            'inquiry_type' => 'required|in:web,mobile,business,careers',
            'booking_channel' => $isBookingRequest
                ? 'required|in:Videollamada,Llamada telefónica,WhatsApp'
                : 'nullable|string',
            'web_products' => [
                Rule::requiredIf(fn () => $request->input('inquiry_type') === 'web' && ! $isBookingRequest),
                'nullable',
                'array',
            ],
            'web_products.*' => 'string|in:basic_web,crm,erp,cms_backoffice,other',
        ], [
            'content.min' => 'El mensaje debe tener al menos 10 caracteres para poder ayudarte mejor.',
            'email.required_if' => 'Indica tu email para poder enviarte el enlace de videollamada.',
            'phone.required_if' => 'Indica tu teléfono para poder contactarte por ese canal.',
            'inquiry_type.required' => 'Indica qué tipo de proyecto o contacto te interesa.',
            'web_products.required_if' => 'Selecciona al menos un producto para tu web.',
        ]);

        if ($isBookingRequest && $request->input('inquiry_type') === 'web' && empty($validated['web_products'])) {
            $validated['web_products'] = ['other'];
        }

        $inquiryLabels = [
            'web' => 'Página web',
            'mobile' => 'App móvil',
            'business' => 'Consultoría / empresa',
            'careers' => 'Talento y colaboración',
        ];
        $inquiryLabel = $inquiryLabels[$validated['inquiry_type']] ?? $validated['inquiry_type'];

        $content = $validated['content'];
        if ($isBookingRequest) {
            $phoneLine = ! empty($validated['phone']) ? "\nTeléfono: ".$validated['phone'] : '';
            $emailLine = ! empty($validated['email']) ? "\nEmail: ".$validated['email'] : '';
            $content = "Solicitud de llamada de 15 min\nCanal preferido: ".$validated['booking_channel'].$phoneLine.$emailLine."\n\n".$validated['content'];
        } elseif ($validated['inquiry_type'] === 'web') {
            $webProductLabels = [
                'basic_web' => 'Web básica (landing page, hosting, dominio y hasta 6 páginas)',
                'crm' => 'CRM',
                'erp' => 'ERP',
                'cms_backoffice' => 'Backoffice para CMS',
                'other' => 'Otro producto o integración',
            ];
            $selectedProducts = collect($validated['web_products'] ?? [])
                ->map(fn ($product) => $webProductLabels[$product] ?? $product)
                ->implode(', ');

            $content = "Productos seleccionados: {$selectedProducts}\n\nDetalles:\n".$validated['content'];
        } elseif ($validated['inquiry_type'] === 'business') {
            $content = "Nombre empresarial: {$validated['name']}\n\nMotivo de contacto:\n".$validated['content'];
        } elseif ($validated['inquiry_type'] === 'mobile') {
            $content = "Tipo de proyecto: App móvil\n\nDescripción:\n".$validated['content'];
        } elseif ($validated['inquiry_type'] === 'careers') {
            $content = "Propuesta profesional / talento:\n\n".$validated['content'];
        }

        $message = Message::create([
            'sender_name' => $validated['name'],
            'sender_email' => $validated['email'] ?? 'sin-email@booking.local',
            'subject' => ($isBookingRequest ? 'Solicitud de llamada' : 'Nuevo mensaje web ('.$inquiryLabel.')').' — '.$validated['name'],
            'content' => $content,
            'is_read' => false,
        ]);

        return $this->respondAfterPublicMessage($request, $message);
    }

    /**
     * @param  'whatsapp'|'email'  $channel
     */
    private function storeFunnelAsyncChannel(Request $request, string $channel): JsonResponse|RedirectResponse
    {
        $rules = [
            'name' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'inquiry_type' => 'required|in:web,mobile,business,careers',
        ];
        if ($channel === 'whatsapp') {
            $rules['phone'] = 'required|string|max:40';
            $rules['email'] = 'nullable|email|max:255';
        } else {
            $rules['email'] = 'required|email|max:255';
            $rules['phone'] = 'nullable|string|max:40';
        }

        $validated = $request->validate($rules, [
            'content.min' => 'El mensaje debe tener al menos 10 caracteres para poder ayudarte mejor.',
        ]);

        $inquiryLabels = [
            'web' => 'Página web',
            'mobile' => 'App móvil',
            'business' => 'Consultoría / empresa',
            'careers' => 'Talento y colaboración',
        ];
        $inquiryLabel = $inquiryLabels[$validated['inquiry_type']] ?? $validated['inquiry_type'];

        if ($channel === 'whatsapp') {
            $lines = [
                'Prefiere seguir por WhatsApp.',
                'Teléfono: '.$validated['phone'],
            ];
            if (! empty($validated['email'])) {
                $lines[] = 'Email (opcional): '.$validated['email'];
            }
            $lines[] = '';
            $lines[] = 'Detalle:';
            $lines[] = $validated['content'];
            $content = implode("\n", $lines);
            $subject = 'WhatsApp ('.$inquiryLabel.') — '.$validated['name'];
            $senderEmail = $validated['email'] ?? 'sin-email@whatsapp.local';
        } else {
            $lines = [
                'Prefiere seguir por correo electrónico.',
                'Email: '.$validated['email'],
            ];
            if (! empty($validated['phone'])) {
                $lines[] = 'Teléfono (opcional): '.$validated['phone'];
            }
            $lines[] = '';
            $lines[] = 'Detalle:';
            $lines[] = $validated['content'];
            $content = implode("\n", $lines);
            $subject = 'Correo ('.$inquiryLabel.') — '.$validated['name'];
            $senderEmail = $validated['email'];
        }

        $message = Message::create([
            'sender_name' => $validated['name'],
            'sender_email' => $senderEmail,
            'subject' => $subject,
            'content' => $content,
            'is_read' => false,
        ]);

        return $this->respondAfterPublicMessage($request, $message);
    }

    private function respondAfterPublicMessage(Request $request, Message $message): JsonResponse|RedirectResponse
    {
        $channels = config('services.contact_alerts.channels', []);
        if (is_array($channels) && ! empty($channels)) {
            SendNewContactAlert::dispatch($message);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => '¡Tu mensaje está en camino! Te contestaré lo antes posible.',
            ]);
        }

        $flash = ['status' => '¡Tu mensaje está en camino! Te contestaré lo antes posible.'];

        if ($request->input('form_context') === 'services') {
            return redirect()->route('public.services')->withFragment('servicios-contacto')->with($flash);
        }

        return redirect('/#contact')->with($flash);
    }
}