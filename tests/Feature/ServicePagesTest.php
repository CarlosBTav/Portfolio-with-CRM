<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicePagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_pages_are_publicly_accessible(): void
    {
        $this->get(route('public.services'))
            ->assertOk()
            ->assertSee('Soluciones digitales a medida para tu negocio', false);

        $this->get(route('public.services.web'))
            ->assertOk()
            ->assertSee('Desarrollo web', false);

        $this->get(route('public.services.app'))
            ->assertOk()
            ->assertSee('Desarrollo de apps', false);
    }

    public function test_home_services_section_contains_new_service_links(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('public.services.web'), false);
        $response->assertSee(route('public.services.app'), false);
        $response->assertSee(route('home', ['service' => 'custom-solutions']) . '#contact', false);
    }

    public function test_web_development_page_only_lists_web_category_projects(): void
    {
        Project::create([
            'title' => 'Sitio web corporativo',
            'description' => 'Proyecto web público.',
            'visibility' => 'public',
            'categories' => ['Web'],
        ]);

        Project::create([
            'title' => 'App móvil',
            'description' => 'Proyecto móvil público.',
            'visibility' => 'public',
            'categories' => ['Mobile'],
        ]);

        $response = $this->get(route('public.services.web'));

        $response->assertOk();
        $response->assertSee('Sitio web corporativo', false);
        $response->assertDontSee('App móvil', false);
    }

    public function test_app_development_page_uses_singular_heading_when_only_one_mobile_project(): void
    {
        Project::create([
            'title' => 'Única app pública',
            'description' => 'Solo un proyecto móvil.',
            'visibility' => 'public',
            'categories' => ['Mobile'],
        ]);

        $this->get(route('public.services.app'))
            ->assertOk()
            ->assertSee('Proyecto destacado', false)
            ->assertDontSee('Proyectos destacados', false)
            ->assertSee('Única app pública', false);
    }
}
