<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_visit_login_view(): void
    {
        $this->assertGuest();

        $this->get(route('login'))
            ->assertViewIs('auth.login')
            ->assertOk();

        $this->assertGuest();
    }

    /** @test */
    public function redirected_to_admin_dashboard_after_successful_login(): void
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        $this->assertGuest();

        $this->followingRedirects()
            ->post(route('login'), $data)
            ->assertOk()
            ->assertViewIs('admin.dashboard');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function cannot_login_with_invalid_email(): void
    {
        $data = [
            'email' => 'invalid-email',
            'password' => 'secret',
        ];

        $this->assertGuest();

        $this->from(route('login'))
            ->post(route('login'), $data)
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email')
            ->assertSessionHasInput('email', $data['email'])
            ->assertSessionMissing('password');

        $this->assertGuest();
    }

    /** @test */
    public function cannot_login_with_incorrect_password(): void
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
            'password' => 'invalid-password',
        ];

        $this->assertGuest();

        $this->from(route('login'))
            ->post(route('login'), $data)
            ->assertRedirect(route('login'))
            ->assertSessionHasInput('email', $data['email'])
            ->assertSessionMissing('password');

        $this->assertGuest();
    }

    /** @test */
    public function can_logout(): void
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        $this->assertGuest();

        $this->followingRedirects()
            ->post(route('login'), $data)
            ->assertOk()
            ->assertViewIs('admin.dashboard');

        $this->assertAuthenticatedAs($user);

        $this->followingRedirects()
            ->post(route('logout'))
            ->assertOk()
            ->assertViewIs('articles.index');

        $this->assertGuest();
    }
}
