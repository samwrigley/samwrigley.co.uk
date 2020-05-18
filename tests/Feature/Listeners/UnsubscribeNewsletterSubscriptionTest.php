<?php

namespace Tests\Feature\Listeners;

use App\Enums\MailChimpUnsubscribeWebhookAction;
use App\Enums\MailChimpWebhookType;
use App\Events\NewsletterUnsubscribed as NewsletterUnsubscribedEvent;
use App\Listeners\UnsubscribeNewsletterSubscription;
use App\NewsletterSubscription;
use App\Notifications\NewsletterUnsubscribed as NewsletterUnsubscribedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Spatie\WebhookClient\Models\WebhookCall;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class UnsubscribeNewsletterSubscriptionTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Notification::fake();
        Log::swap(new LogFake);
    }

    /** @test */
    public function it_marks_subscription_as_unsubscribed_when_passed_unsubscribe_action_webhook_call(): void
    {
        $email = $this->faker->email;

        $subscription = factory(NewsletterSubscription::class)
            ->states('unsubscribed')
            ->create(['email' => $email]);

        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UNSUBSCRIBE,
                'data' => [
                    'action' => MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE,
                    'email' => $email,
                ],
            ],
        ]);

        Log::assertNothingLogged();
        $this->assertNull($subscription->unsubscribed_at);

        $listener = new UnsubscribeNewsletterSubscription;
        $listener->handle(new NewsletterUnsubscribedEvent($subscription, $webhookCall));

        $this->assertNotNull($subscription->unsubscribed_at);
        Log::assertLoggedMessage('info', 'Newsletter : Unsubscribed');
    }

    /** @test */
    public function it_sends_newsletter_unsubscribed_notification_when_passed_unsubscribe_action_webhook_call(): void
    {
        $email = $this->faker->email;

        $subscription = factory(NewsletterSubscription::class)
            ->states('unsubscribed')
            ->create(['email' => $email]);

        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UNSUBSCRIBE,
                'data' => [
                    'action' => MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE,
                    'email' => $email,
                ],
            ],
        ]);

        Notification::assertNothingSent();

        $listener = new UnsubscribeNewsletterSubscription;
        $listener->handle(new NewsletterUnsubscribedEvent($subscription, $webhookCall));

        Notification::assertSentTo(
            new AnonymousNotifiable,
            NewsletterUnsubscribedNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['slack'] === Config::get('notifications.slack.newsletter');
            }
        );
    }

    /** @test */
    public function it_does_not_mark_subscription_as_unsubscribed_again_when_already_unsubscribed(): void
    {
        $email = $this->faker->email;
        $unsubscribedAt = now()->second(0)->millisecond(0);

        $subscription = factory(NewsletterSubscription::class)->create([
            'email' => $email,
            'unsubscribed_at' => $unsubscribedAt,
        ]);

        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UNSUBSCRIBE,
                'data' => [
                    'action' => MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE,
                    'email' => $email,
                ],
            ],
        ]);

        Log::assertNothingLogged();
        $this->assertEquals($unsubscribedAt, $subscription->unsubscribed_at);

        $listener = new UnsubscribeNewsletterSubscription;
        $listener->handle(new NewsletterUnsubscribedEvent($subscription, $webhookCall));

        $subscription->refresh();

        $this->assertEquals($unsubscribedAt, $subscription->unsubscribed_at);
        Log::assertLoggedMessage('info', 'Newsletter : Already unsubscribed');
    }

    /** @test */
    public function it_deletes_subscription_when_passed_delete_action_webhook_call(): void
    {
        $email = $this->faker->email;

        $subscription = factory(NewsletterSubscription::class)
            ->states('subscribed')
            ->create(['email' => $email]);

        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UNSUBSCRIBE,
                'data' => [
                    'action' => MailChimpUnsubscribeWebhookAction::DELETE,
                    'email' => $email,
                ],
            ],
        ]);

        Log::assertNothingLogged();
        $this->assertDatabaseHas('newsletter_subscriptions', ['email' => $email]);

        $listener = new UnsubscribeNewsletterSubscription;
        $listener->handle(new NewsletterUnsubscribedEvent($subscription, $webhookCall));


        $this->assertDeleted('newsletter_subscriptions', ['email' => $email]);
        Log::assertLoggedMessage('info', 'Newsletter : Deleted subscription');
    }
}
