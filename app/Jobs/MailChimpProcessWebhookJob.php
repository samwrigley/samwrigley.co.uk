<?php

namespace App\Jobs;

use App\Enums\MailChimpUnsubscribeWebhookAction;
use App\NewsletterSubscription;
use App\Notifications\NewsletterUnsubscribed;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class MailChimpProcessWebhookJob extends SpatieProcessWebhookJob
{
    public function handle(): void
    {
        Log::info('Newsletter : Processing webhook', ['payload' => $this->webhookCall->payload]);

        $data = $this->webhookCall->payload['data'];
        $subscription = NewsletterSubscription::whereEmail($data['email'])->first();

        if (! $subscription) {
            Log::info('Newsletter : No subscription exists', ['email' => $data['email']]);
        }

        switch ($data['action']) {
            case MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE:
                $this->unsubscribeSubscription($subscription);
                break;
            case MailChimpUnsubscribeWebhookAction::DELETE:
                $this->deleteSubscription($subscription);
                break;
        }
    }

    protected function unsubscribeSubscription(NewsletterSubscription $subscription): void
    {
        if (! is_null($subscription->unsubscribed_at)) {
            Log::info('Newsletter : Already unsubscribed', ['subscription' => $subscription]);

            return;
        }

        $subscription->unsubscribed_at = now();
        $subscription->save();

        Log::info('Newsletter : Unsubscribed', ['subscription' => $subscription]);

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterUnsubscribed($subscription));
    }

    protected function deleteSubscription(NewsletterSubscription $subscription): void
    {
        $subscription->delete();

        Log::info('Newsletter : Deleted subscription', ['subscription' => $subscription]);
    }
}
