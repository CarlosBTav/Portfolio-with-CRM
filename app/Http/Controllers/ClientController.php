<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\QuoteVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /*
     * Listado de clientes.
     */
    public function index(Request $request)
    {
        // 1. Base de la consulta con el conteo de proyectos
        // y carga de proyectos para el desplegable en la tabla.
        $query = Client::withCount('projects')
            ->with(['projects' => function ($projectQuery) {
                $projectQuery->select('projects.id', 'projects.title', 'projects.visibility', 'projects.sort_order');
            }]);

        // 2. FILTRO: Si hay un tipo en la URL (?type=company), filtramos
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 3. ORDENACIÓN MEJORADA
        $sort = $request->input('sort');
        $direction = $request->input('direction', 'asc'); // Por defecto A-Z

        if ($sort === 'projects_count') {
            $query->orderBy('projects_count', $direction);
        } elseif ($sort === 'commercial_name') {
            // Ordenar alfabéticamente
            $query->orderBy('commercial_name', $direction);
        } else {
            // Orden por defecto (si no hay nada en la URL): los más nuevos primero
            $query->latest();
        }

        // 4. Paginación (Mantenemos los filtros en los enlaces de página 1, 2, 3...)
        $clients = $query->paginate(10)->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Muestra el formulario de CREACIÓN.
     */
    public function create(Request $request)
    {
        // PATRÓN MODELO VACÍO:
        // Pasamos un objeto vacío para que la vista 'form' pueda usar $client->commercial_name sin error
        $client = new Client();
        $documentationVersionOptions = $this->documentationVersionOptions();
        $linkProject = null;

        if ($request->filled('project')) {
            $linkProject = Project::query()->findOrFail($request->integer('project'));
        }

        return view('admin.clients.form', compact('client', 'documentationVersionOptions', 'linkProject'));
    }

    /**
     * Guarda el nuevo cliente en BBDD.
     */
    public function store(Request $request)
    {
        $request->merge([
            'documentation_slug' => filled($request->input('documentation_slug')) ? $request->input('documentation_slug') : null,
        ]);

        $validated = $request->validate([
            'commercial_name' => 'required|string|max:255',
            'type' => 'required|in:company,individual',
            'tax_id' => 'nullable|string|max:20', // CIF/NIF
            'notes' => 'nullable|string',
            'documentation_slug' => ['nullable', 'string', 'max:120', Rule::in(array_keys(config('documentation.versions', [])))],
            'project_id' => 'nullable|integer|exists:projects,id',
        ]);

        $client = Client::create(collect($validated)->except('project_id')->all());

        if ($request->filled('project_id')) {
            $project = Project::query()->findOrFail($request->integer('project_id'));
            $project->update(['is_internal' => false]);
            $project->clients()->syncWithoutDetaching([$client->id]);

            return redirect()
                ->route('projects.edit', $project)
                ->with('success', 'Cliente registrado y vinculado al proyecto.');
        }

        return redirect()->route('clients.index')->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Muestra el formulario de EDICIÓN.
     */
    public function edit(Client $client)
    {
        $client->load('quoteVersions');
        $documentationLinks = collect(config('documentation.versions', []))
            ->map(function (array $documentation, string $slug) {
                return [
                    'slug' => $slug,
                    'title' => $documentation['title'] ?? $slug,
                    'client_name' => $documentation['client_name'] ?? null,
                    'commercial_name_aliases' => $documentation['commercial_name_aliases'] ?? [],
                    'updated_at' => $documentation['updated_at'] ?? null,
                ];
            })
            ->filter(function (array $documentation) use ($client) {
                $clientName = Str::lower(trim($client->commercial_name));
                $documentationClientName = Str::lower(trim((string) ($documentation['client_name'] ?? '')));
                $nameMatches = $documentationClientName !== '' && $documentationClientName === $clientName;

                $aliases = collect($documentation['commercial_name_aliases'] ?? [])
                    ->merge([$documentation['client_name'] ?? ''])
                    ->filter()
                    ->map(fn ($alias) => Str::lower(trim((string) $alias)))
                    ->filter()
                    ->unique();
                $aliasMatches = $aliases->contains(fn (string $alias) => $alias === $clientName);

                $clientSlug = Str::slug($client->commercial_name);
                $docSlug = $documentation['slug'];
                $slugMatches = $docSlug === $clientSlug
                    || Str::endsWith($clientSlug, '-'.$docSlug);

                $explicitSlug = (string) ($client->documentation_slug ?? '');
                $explicitMatch = $explicitSlug !== '' && $explicitSlug === $docSlug;

                return $nameMatches || $aliasMatches || $slugMatches || $explicitMatch;
            })
            ->values();

        $documentationVersionOptions = $this->documentationVersionOptions();

        // Pasamos el cliente existente a la misma vista 'form'
        return view('admin.clients.form', compact('client', 'documentationLinks', 'documentationVersionOptions'));
    }

    /**
     * Actualiza el cliente en BBDD.
     */
    public function update(Request $request, Client $client)
    {
        $request->merge([
            'documentation_slug' => filled($request->input('documentation_slug')) ? $request->input('documentation_slug') : null,
        ]);

        $validated = $request->validate([
            'commercial_name' => 'required|string|max:255',
            'type' => 'required|in:company,individual',
            'tax_id' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
            'documentation_slug' => ['nullable', 'string', 'max:120', Rule::in(array_keys(config('documentation.versions', [])))],
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina el cliente.
     */
    public function destroy(Client $client)
    {
        // Al borrar el cliente, se borrarán las relaciones en la tabla pivote
        // gracias al 'onDelete cascade' de la migración, pero NO los proyectos.
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado.');
    }

    public function storeQuote(Request $request, Client $client)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'currency' => 'required|string|size:3',
            'quote_date' => 'nullable|date',
            'slug' => ['nullable', 'string', 'max:120', 'regex:/^[A-Za-z0-9\-_]+$/', Rule::unique('quote_versions', 'slug')],
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:2000',
            'items.*.price' => 'required|numeric|min:0',
            'notes_text' => 'nullable|string',
        ]);

        $items = collect($validated['items'])
            ->map(function (array $item) {
                return [
                    'name' => trim((string) $item['name']),
                    'description' => trim((string) ($item['description'] ?? '')),
                    'price' => (float) $item['price'],
                ];
            })
            ->values()
            ->all();

        $notes = collect(explode("\n", (string) ($validated['notes_text'] ?? '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $baseSlug = $validated['slug'] ?: Str::slug($client->commercial_name.'-'.Str::limit($validated['title'], 40, ''), '-');
        $slug = $this->generateUniqueSlug($baseSlug);

        QuoteVersion::create([
            'client_id' => $client->id,
            'slug' => $slug,
            'title' => $validated['title'],
            'currency' => strtoupper($validated['currency']),
            'quote_date' => $validated['quote_date'] ?? now()->toDateString(),
            'items' => $items,
            'notes' => $notes,
        ]);

        return redirect()->route('clients.edit', $client)->with('success', 'Presupuesto generado y asociado al cliente.');
    }

    public function destroyQuote(Client $client, QuoteVersion $quoteVersion)
    {
        if ($quoteVersion->client_id !== $client->id) {
            abort(404);
        }

        $quoteVersion->delete();

        return redirect()->route('clients.edit', $client)->with('success', 'Presupuesto eliminado.');
    }

    private function generateUniqueSlug(string $baseSlug): string
    {
        $slug = Str::lower(trim($baseSlug, '-'));
        if ($slug === '') {
            $slug = 'presupuesto';
        }

        $candidate = $slug;
        $counter = 2;
        while (QuoteVersion::where('slug', $candidate)->exists()) {
            $candidate = $slug.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }

    /**
     * @return array<string, string> slug publico => etiqueta en el desplegable del formulario
     */
    private function documentationVersionOptions(): array
    {
        return collect(config('documentation.versions', []))
            ->mapWithKeys(function (array $documentation, string $slug) {
                return [$slug => (string) ($documentation['title'] ?? $slug)];
            })
            ->all();
    }
}