<?php

namespace App\Notifications;

use App\Models\NewsletterSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewsletterUnsubscribed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected NewsletterSubscription $subscription
    ) {}

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
