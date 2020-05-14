<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class NewsletterSubscribed extends Notification implements ShouldQueue
{
    use Queueable;

    private string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function via(): array
    {
        return ['slack'];
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage)
            ->from(config('app.name'))
            ->to('#newsletter')
            ->info()
            ->content("{$this->email} has subscribed");
    }
}
