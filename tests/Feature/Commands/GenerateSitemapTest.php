<?php

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenerateSitemapTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_run_command_successfully(): void
    {
        $this->artisan('sitemap:generate')->assertExitCode(0);
    }
}
