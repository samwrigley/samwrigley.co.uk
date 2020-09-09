<?php

namespace App\Notifications;

use App\NewsletterSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewsletterUnsubscribed extends Notification implements ShouldQueue
{
    use Queueable;

    protected NewsletterSubscription $subscription;

    public function __construct(NewsletterSubscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function via(): array
    {
        return ['slack'];
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage())
            ->from(config('app.name'))
            ->to('#newsletter')
            ->info()
            ->content("{$this->subscription->email} has unsubscribed");
    }
}
