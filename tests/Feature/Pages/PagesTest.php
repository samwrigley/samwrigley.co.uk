<?php

namespace Tests\Feature\Pages;

use Tests\TestCase;

class PagesTest extends TestCase
{
    /** @test */
    public function can_visit_homepage_view(): void
    {
        $this->get(route('home'))->assertOk();
    }

    /** @test */
    public function can_visit_contact_view(): void
    {
        $this->get(route('contact'))->assertOk();
    }

    /** @test */
    public function can_visit_about_view(): void
    {
        $this->get(route('about'))->assertOk();
    }

    /** @test */
    public function can_visit_services_view(): void
    {
        $this->get(route('services'))->assertOk();
    }
}
