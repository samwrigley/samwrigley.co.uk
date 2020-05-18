<?php

namespace App\Jobs;

use App\Enums\MailChimpUnsubscribeWebhookAction;
use App\Enums\MailChimpWebhookType;
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

        $type = $this->webhookCall->payload['type'];
        $data = $this->webhookCall->payload['data'];
        $email = $data['email'] ?? $data['old_email'];
        $subscription = NewsletterSubscription::whereEmail($email)->first();

        if (! $subscription) {
            Log::info('Newsletter : No subscription exists', ['email' => $email]);

            return;
        }

        if ($type === MailChimpWebhookType::UNSUBSCRIBE) {
            $this->handleUnsubscribe($subscription);
        } elseif ($type === MailChimpWebhookType::UPDATE_MAIL) {
            $this->handleUpdateEmail($subscription);
        }
    }

    protected function handleUnsubscribe(NewsletterSubscription $subscription): void
    {
        $action = $this->webhookCall->payload['data']['action'];

        if ($action === MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE) {
            $this->unsubscribeSubscription($subscription);
        } elseif ($action === MailChimpUnsubscribeWebhookAction::DELETE) {
            $this->deleteSubscription($subscription);
        }
    }

    protected function handleUpdateEmail(NewsletterSubscription $subscription): void
    {
        $data = $this->webhookCall->payload['data'];

        $subscription->email = $data['new_email'];
        $subscription->save();

        Log::info('Newsletter : Updated email', [
            'old_email' => $data['old_email'],
            'new_email' => $data['new_email'],
            'subscription' => $subscription,
        ]);
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
