<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Config::set('honeypot.enabled', false);
    }

    /** @test */
    public function can_subscribe_to_newsletter_with_valid_email(): void
    {
        $this->followingRedirects()
            ->postSubscribeRoute(['email' => $this->faker->email])
            ->assertSessionHasNoErrors()
            ->assertOk();
    }

    /** @test */
    public function session_has_correct_data_after_successful_subscription(): void
    {
        $this->postSubscribeRoute(['email' => $this->faker->email])
            ->assertSessionHas('newsletter', __('newsletter.success'))
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function email_is_required(): void
    {
        $this->postSubscribeRoute()
            ->assertRedirect()
            ->assertSessionHasErrorsIn('newsletter', 'email');
    }

    /** @test */
    public function valid_email_is_required(): void
    {
        $data = ['email' => $this->faker->sentence];

        $this->postSubscribeRoute($data)
            ->assertRedirect()
            ->assertSessionHasErrorsIn('newsletter', 'email')
            ->assertSessionHasInput($data);
    }

    protected function postSubscribeRoute(array $data = []): TestResponse
    {
        return $this->post(route('newsletter.subscribe'), $data);
    }
}
