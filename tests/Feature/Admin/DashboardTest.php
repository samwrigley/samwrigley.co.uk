<?php

namespace Tests\Feature\Admin;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_visit_admin_dashboard_when_authenticated(): void
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertViewIs('admin.dashboard')
            ->assertOk();
    }

    /** @test */
    public function cannot_visit_admin_dashboard_when_not_authenticated(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect();
    }
}
