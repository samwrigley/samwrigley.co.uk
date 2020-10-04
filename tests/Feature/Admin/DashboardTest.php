<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_visit_admin_dashboard_when_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function cannot_visit_admin_dashboard_when_not_authenticated(): void
    {
        $this->followingRedirects()
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }
}
