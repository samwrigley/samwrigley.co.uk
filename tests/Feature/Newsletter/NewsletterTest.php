<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function can_subscribe_to_newsletter_with_valid_email(): void
    {
        $this->followingRedirects()
            ->getSubscribeRoute(['email' => $this->faker->email])
            ->assertSessionHasNoErrors()
            ->assertOk();
    }

    /** @test */
    public function email_is_required(): void
    {
        $this->getSubscribeRoute()
            ->assertRedirect()
            ->assertSessionHasErrors('email');
    }

    /** @test */
    public function valid_email_is_required(): void
    {
        $this->getSubscribeRoute(['email' => $this->faker->sentence])
            ->assertRedirect()
            ->assertSessionHasErrors('email');
    }

    private function getSubscribeRoute(array $parameters = []): TestResponse
    {
        return $this->post(
            route('newsletter.subscribe', $parameters)
        );
    }
}
