<?php

namespace Tests\Feature\Jobs;

use App\Enums\MailChimpUnsubscribeWebhookAction;
use App\Enums\MailChimpWebhookType;
use App\Events\NewsletterSubscriptionEmailUpdated;
use App\Events\NewsletterUnsubscribed;
use App\Jobs\MailChimpProcessWebhookJob;
use App\NewsletterSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class MailChimpProcessWebhookJobTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
        Log::swap(new LogFake);
    }

    /** @test */
    public function it_logs_when_no_subscription_exists(): void
    {
        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UNSUBSCRIBE,
                'data' => [
                    'action' => MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE,
                    'email' => $this->faker->email,
                ],
            ],
        ]);

        $job = new MailChimpProcessWebhookJob($webhookCall);

        Log::assertNothingLogged();

        $job->handle();

        Log::assertLoggedMessage('info', 'Newsletter : Processing webhook');
        Log::assertLoggedMessage('info', 'Newsletter : No subscription exists');
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

        $job = new MailChimpProcessWebhookJob($webhookCall);

        $job->handle();

        Event::assertDispatched(
            NewsletterUnsubscribed::class,
            function (NewsletterUnsubscribed $event) use ($subscription, $webhookCall): bool {
                return $event->subscription->id === $subscription->id
                    && $event->webhookCall->id === $webhookCall->id;
            }
        );
    }

    /** @test */
    public function it_updates_subscription_email_when_passed_update_email_webhook_call(): void
    {
        $oldEmail = $this->faker->email;

        $subscription = factory(NewsletterSubscription::class)
            ->states('subscribed')
            ->create(['email' => $oldEmail]);

        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UPDATE_MAIL,
                'data' => [
                    'old_email' => $oldEmail,
                    'new_email' => $this->faker->email,
                ],
            ],
        ]);

        $job = new MailChimpProcessWebhookJob($webhookCall);

        $job->handle();

        Event::assertDispatched(
            NewsletterSubscriptionEmailUpdated::class,
            function (NewsletterSubscriptionEmailUpdated $event) use ($subscription, $webhookCall): bool {
                return $event->subscription->id === $subscription->id
                    && $event->webhookCall->id === $webhookCall->id;
            }
        );
    }
}
