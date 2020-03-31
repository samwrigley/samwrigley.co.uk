<?php

namespace Tests\Feature\Pages;

use App\Schemas\SiteSchema;
use Tests\TestCase;

class PagesTest extends TestCase
{
    /** @test */
    public function homepage_redirects_to_blog(): void
    {
        $this->get(route('home'))
            ->assertRedirect(route('blog.articles.index'));
    }

    /** @test */
    public function can_visit_about_view(): void
    {
        $this->get(route('about'))
            ->assertViewIs('pages.about')
            ->assertOk();
    }

    /** @test */
    public function about_view_has_site_schema_script(): void
    {
        $siteSchema = (new SiteSchema())->generate();

        $this->get(route('about'))
            ->assertSee($siteSchema->toScript());
    }
}
