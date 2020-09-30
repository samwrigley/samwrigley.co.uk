<?php

namespace Tests\Feature\Listeners;

use App\Enums\MailChimpWebhookType;
use App\Events\NewsletterSubscriptionEmailUpdated;
use App\Listeners\UpdateNewsletterSubscriptionEmail;
use App\Models\NewsletterSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\Models\WebhookCall;
use Tests\TestCase;
use TiMacDonald\Log\LogFake;

class UpdateNewsletterSubscriptionEmailTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        Log::swap(new LogFake);
    }

    /** @test */
    public function it_updates_newsletter_subscription_email(): void
    {
        $oldEmail = $this->faker->email;
        $newEmail = $this->faker->email;

        $subscription = NewsletterSubscription::factory()
            ->subscribed()
            ->create(['email' => $oldEmail]);

        $webhookCall = WebhookCall::create([
            'name' => Config::get('webhook-client.names.newsletter'),
            'payload' => [
                'type' => MailChimpWebhookType::UPDATE_MAIL,
                'data' => [
                    'old_email' => $oldEmail,
                    'new_email' => $newEmail,
                ],
            ],
        ]);

        Log::assertNothingLogged();
        $this->assertDatabaseHas('newsletter_subscriptions', ['email' => $oldEmail]);

        $listener = new UpdateNewsletterSubscriptionEmail;
        $listener->handle(new NewsletterSubscriptionEmailUpdated($subscription, $webhookCall));

        $this->assertDatabaseHas('newsletter_subscriptions', ['email' => $newEmail]);
        $this->assertDatabaseMissing('newsletter_subscriptions', ['email' => $oldEmail]);

        Log::assertLoggedMessage('info', 'Newsletter : Updated email');
    }
}
