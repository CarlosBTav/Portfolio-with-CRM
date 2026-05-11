<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Technology;
use App\Models\QuoteVersion;

class PortfolioController extends Controller
{
    public function index()
    {
        // Portada: Pedimos al Modelo 3 proyectos para el "destacados"
            /* Usamos 'with' (Eager Loading) para traer las tecnologías de golpe
               y ahorrar consultas a la base de datos (mejor rendimiento).    */
        $projects = Project::with(['technologies', 'links'])
                    ->where('visibility', 'public')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get();

        // Traemos todas las tecnologías para la sección de skills
        $technologies = Technology::all();

        // Devolvemos la vista (el HTML) pasándole los datos
        return view('public.home', compact('projects', 'technologies'));
    }

    // Método para la página de "Ver todos los proyectos"
    public function showAll()
    {
        // Aquí traemos todos, pero paginados de 9 en 9 para que cargue rápido
        $projects = Project::with(['technologies', 'links'])
                    ->where('visibility', 'public')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->paginate(9); 

        return view('public.projects', compact('projects'));
    }

    //Método para la página de historia
    public function about()
    {
        return view('public.about');
    }

    public function services()
    {
        return view('public.services.index');
    }

    public function webDevelopment()
    {
        $featuredProjects = Project::with(['technologies', 'links'])
            ->where('visibility', 'public')
            ->whereJsonContains('categories', 'Web')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->take(3)
            ->get();

        $whatsappPhone = preg_replace('/\D+/', '', (string) config('services.callmebot_whatsapp.phone'));

        return view('public.services.web-development', compact('featuredProjects', 'whatsappPhone'));
    }

    public function appDevelopment()
    {
        return view('public.services.app-development');
    }

    public function servicesFaq()
    {
        return view('public.services.faq');
    }

    public function cv()
    {
        return view('public.cv');
    }

    public function cvDownload()
    {
        return response()
            ->view('public.cv', ['downloadMode' => true], 200)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="carlos-burgos-tavora-cv.html"');
    }

    public function quote(string $slug = 'general')
    {
        $quoteVersion = QuoteVersion::with('client')->where('slug', $slug)->first();

        if ($quoteVersion) {
            return view('public.quote', [
                'quote' => [
                    'title' => $quoteVersion->title,
                    'client_name' => $quoteVersion->client->commercial_name,
                    'updated_at' => optional($quoteVersion->quote_date)->toDateString() ?? $quoteVersion->updated_at->toDateString(),
                    'currency' => $quoteVersion->currency,
                    'notes' => $quoteVersion->notes ?? [],
                    'items' => $quoteVersion->items ?? [],
                ],
                'slug' => $slug,
            ]);
        }

        $quoteVersions = config('quotes.versions', []);
        $quote = $quoteVersions[$slug] ?? null;

        if (! $quote) {
            abort(404);
        }

        return view('public.quote', compact('quote', 'slug'));
    }

    public function documentation(string $slug = 'general')
    {
        $documentationVersions = config('documentation.versions', []);
        $documentation = $documentationVersions[$slug] ?? null;

        if (! $documentation) {
            abort(404);
        }

        return view('public.documentation', compact('documentation', 'slug'));
    }
}