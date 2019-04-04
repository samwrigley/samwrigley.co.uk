<?php

namespace Tests\Feature\About;

use Tests\TestCase;

class AboutTest extends TestCase
{
    /** @test */
    public function can_visit_about_view(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSeeText('About');
    }
}
