<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_pages_include_core_seo_metadata_and_structured_data(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('<link rel="canonical" href="'.route('home').'">', false);
        $response->assertSee('<meta property="og:title"', false);
        $response->assertSee('<meta name="twitter:card" content="summary_large_image">', false);
        $response->assertSee('"@type":"Person"', false);
        $response->assertSee('"@type":"WebSite"', false);
        $response->assertSee('"@type":"ProfessionalService"', false);
    }

    public function test_faq_page_includes_faq_structured_data(): void
    {
        $this->get(route('public.services.faq'))
            ->assertOk()
            ->assertSee('"@type":"FAQPage"', false)
            ->assertSee('"@type":"Question"', false);
    }

    public function test_direct_link_content_requests_no_indexing(): void
    {
        $this->get(route('public.cv'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive" />', false);

        $this->get(route('public.quote'))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive">', false);

        $this->get(route('public.documentation', ['slug' => 'musical-luthier']))
            ->assertOk()
            ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive">', false);
    }

    public function test_sitemap_only_contains_indexable_strategic_pages(): void
    {
        $response = $this->get(route('seo.sitemap'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee(route('home'), false);
        $response->assertSee(route('public.projects'), false);
        $response->assertSee(route('public.services.web'), false);
        $response->assertDontSee(route('public.cv'), false);
        $response->assertDontSee('/presupuesto', false);
        $response->assertDontSee('/documentacion', false);
        $response->assertDontSee('/dashboard', false);
    }

    public function test_robots_file_points_to_sitemap_and_discourages_admin_routes(): void
    {
        $this->get(route('seo.robots'))
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Sitemap: '.route('seo.sitemap'), false)
            ->assertSee('Disallow: /dashboard', false)
            ->assertDontSee('Disallow: /presupuesto', false)
            ->assertDontSee('Disallow: /documentacion', false)
            ->assertDontSee('Disallow: /cv', false);
    }
}
