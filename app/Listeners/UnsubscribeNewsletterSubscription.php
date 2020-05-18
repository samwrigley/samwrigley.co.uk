<?php

namespace App\Listeners;

use App\Enums\MailChimpUnsubscribeWebhookAction;
use App\Events\NewsletterUnsubscribed as NewsletterUnsubscribedEvent;
use App\NewsletterSubscription;
use App\Notifications\NewsletterUnsubscribed as NewsletterUnsubscribedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class UnsubscribeNewsletterSubscription implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsletterUnsubscribed  $event
     * @return void
     */
    public function handle(NewsletterUnsubscribedEvent $event)
    {
        $action = $event->webhookCall->payload['data']['action'];

        if ($action === MailChimpUnsubscribeWebhookAction::UNSUBSCRIBE) {
            $this->unsubscribe($event->subscription);
        } elseif ($action === MailChimpUnsubscribeWebhookAction::DELETE) {
            $this->delete($event->subscription);
        }
    }

    protected function unsubscribe(NewsletterSubscription $subscription): void
    {
        $subscription->refresh();

        if (! is_null($subscription->unsubscribed_at)) {
            Log::info('Newsletter : Already unsubscribed', ['subscription' => $subscription]);

            return;
        }

        $subscription->unsubscribed_at = now();
        $subscription->save();

        Log::info('Newsletter : Unsubscribed', ['subscription' => $subscription]);

        Notification::route('slack', Config::get('notifications.slack.newsletter'))
            ->notify(new NewsletterUnsubscribedNotification($subscription));
    }

    protected function delete(NewsletterSubscription $subscription): void
    {
        $subscription->delete();

        Log::info('Newsletter : Deleted subscription', ['subscription' => $subscription]);
    }
}
