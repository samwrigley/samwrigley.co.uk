<?php

namespace App\Jobs;

use App\Enums\MailChimpWebhookType;
use App\Events\NewsletterSubscriptionEmailUpdated;
use App\Events\NewsletterUnsubscribed;
use App\NewsletterSubscription;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class MailChimpProcessWebhookJob extends SpatieProcessWebhookJob
{
    public function handle(): void
    {
        $payload = $this->webhookCall->payload;
        $email = $payload['data']['email'] ?? $payload['data']['old_email'];

        Log::info('Newsletter : Processing webhook', ['payload' => $payload]);

        if (! $subscription = NewsletterSubscription::whereEmail($email)->first()) {
            Log::info('Newsletter : No subscription exists', ['email' => $email]);

            return;
        }

        if ($payload['type'] === MailChimpWebhookType::UNSUBSCRIBE) {
            event(new NewsletterUnsubscribed($subscription, $this->webhookCall));

            return;
        }

        if ($payload['type'] === MailChimpWebhookType::UPDATE_MAIL) {
            event(new NewsletterSubscriptionEmailUpdated($subscription, $this->webhookCall));

            return;
        }
    }
}
