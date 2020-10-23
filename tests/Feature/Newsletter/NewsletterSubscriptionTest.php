<?php

namespace Tests\Feature\Article;

use App\Notifications\NewsletterSubscribed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Spatie\Newsletter\Newsletter;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class NewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Log::swap(new LogFake);
        Config::set('honeypot.enabled', false);
    }

    /** @test */
    public function it_redirects_back_with_message_when_email_already_subscribed(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(true);
        });

        Log::assertNothingLogged();

        $this->from(route('blog.articles.index'))
            ->postSubscribeRoute(['email' => $email])
            ->assertSessionHas('newsletter', __('newsletter.already_subscribed'))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('blog.articles.index'));

        Log::assertLogged('info');
    }

    /** @test */
    public function it_returns_json_with_message_when_email_already_subscribed(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(true);
        });

        $this->postJson(route('newsletter.subscribe'), ['email' => $email])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['message' => __('newsletter.already_subscribed')]);
    }

    /** @test */
    public function it_redirects_back_with_message_when_subscription_fails(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($email)->once()->andReturn(false);
            $mock->shouldReceive()->getLastError()->once()->andReturn('Error');
        });

        Log::assertNothingLogged();

        $this->from(route('blog.articles.index'))
            ->postSubscribeRoute(['email' => $email])
            ->assertSessionHas('newsletter', __('newsletter.subscribe_failure'))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('blog.articles.index'));

        Log::assertLogged('error');
    }

    /** @test */
    public function it_returns_json_with_message_when_subscription_fails(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($email)->once()->andReturn(false);
            $mock->shouldReceive()->getLastError()->once()->andReturn('Error');
        });

        $this->postJson(route('newsletter.subscribe'), ['email' => $email])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['message' => __('newsletter.subscribe_failure')]);
    }

    /** @test */
    public function can_subscribe_to_newsletter_with_valid_email(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($email)->once()->andReturn(true);
        });

        Log::assertNothingLogged();

        $this->from(route('blog.articles.index'))
            ->postSubscribeRoute(['email' => $email])
            ->assertSessionHas('newsletter', __('newsletter.subscribe_success'))
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('blog.articles.index'));

        Log::assertLogged('info');
    }

    /** @test */
    public function it_returns_json_with_message_when_subscription_is_successful(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($email)->once()->andReturn(true);
        });

        $this->postJson(route('newsletter.subscribe'), ['email' => $email])
            ->assertOk()
            ->assertJson(['message' => __('newsletter.subscribe_success')]);
    }

    /** @test */
    public function it_sends_newsletter_subscribed_notification_on_successful_subscription(): void
    {
        $email = $this->faker->email;

        $this->mock(Newsletter::class, function ($mock) use ($email) {
            $mock->shouldReceive()->isSubscribed($email)->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($email)->once()->andReturn(true);
        });

        Notification::assertNothingSent();

        $this->postSubscribeRoute(['email' => $email]);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            NewsletterSubscribed::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Config::get('notifications.slack.newsletter');
            }
        );
    }

    /** @test */
    public function data_is_persisted_in_database(): void
    {
        $data = ['email' => $this->faker->email];

        $this->mock(Newsletter::class, function ($mock) use ($data) {
            $mock->shouldReceive()->isSubscribed($data['email'])->once()->andReturn(false);
            $mock->shouldReceive()->subscribe($data['email'])->once()->andReturn(true);
        });

        $this->postSubscribeRoute($data);

        $this->assertDatabaseHas('newsletter_subscriptions', $data);
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
