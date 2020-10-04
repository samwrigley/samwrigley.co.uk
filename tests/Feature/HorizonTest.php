<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HorizonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_access_dashboard_when_authenticated(): void
    {
        $user = User::factory()->create(['email' => Config::get('contact.email')]);

        $this->actingAs($user)
            ->get(route('horizon.index'))
            ->assertOk();
    }

    /** @test */
    public function cannot_access_dashboard_when_not_authenticated(): void
    {
        $this->get(route('horizon.index'))->assertForbidden();
    }
}
