<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class ContactReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Contact $contact,
    ) {}

    public function via(): array
    {
        return ['slack'];
    }

    public function toSlack(): SlackMessage
    {
        return (new SlackMessage())
            ->from(config('app.name'))
            ->to('#contact')
            ->info()
            ->content("{$this->contact->name} has been in touch using '{$this->contact->email}'");
    }
}
