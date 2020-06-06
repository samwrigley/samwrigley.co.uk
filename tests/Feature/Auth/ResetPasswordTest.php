<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    /** @test */
    public function can_visit_reset_password_view(): void
    {
        $this->get(route('password.request'))
            ->assertViewIs('auth.passwords.email')
            ->assertOk();
    }

    /** @test */
    public function sends_email_with_a_password_reset_link(): void
    {
        Notification::assertNothingSent();

        $user = factory(User::class)->create();

        $this->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), ['email' => $user->email])
            ->assertViewIs('auth.passwords.email');

        $reset = DB::table('password_resets')->first();

        $this->assertNotNull($reset);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($reset) {
            return Hash::check($notification->token, $reset->token) === true;
        });
    }

    /** @test */
    public function is_redirected_back_after_entering_invalid_email(): void
    {
        $this->followingRedirects()
            ->from(route('password.request'))
            ->post(route('password.email'), ['email' => 'invalid-email'])
            ->assertViewIs('auth.passwords.email')
            ->assertSessionHasErrors('email')
            ->assertSessionHasInput('email', 'invalid-email');

        Notification::assertNothingSent();
    }

    /** @test */
    public function can_visit_reset_password_confirmation_view(): void
    {
        $user = factory(User::class)->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        $reset = DB::table('password_resets')->first();

        $this->get(route('password.reset', ['token' => $reset->token]))
            ->assertViewIs('auth.passwords.reset')
            ->assertOk();
    }

    /** @test */
    public function can_reset_password(): void
    {
        $user = factory(User::class)->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        $reset = DB::table('password_resets')->first();

        $this->followingRedirects()
            ->from(route('password.reset', ['token' => $reset->token]))
            ->post(route('password.update'), [
                'token' => $reset->token,
                'email' => $user->email,
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertViewIs('admin.dashboard')
            ->assertOk();
    }
}
