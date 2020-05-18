<?php

namespace App\Listeners;

use App\Events\NewsletterSubscriptionEmailUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class UpdateNewsletterSubscriptionEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsletterSubscriptionEmailUpdated  $event
     * @return void
     */
    public function handle(NewsletterSubscriptionEmailUpdated $event)
    {
        $data = $event->webhookCall->payload['data'];

        $event->subscription->email = $data['new_email'];
        $event->subscription->save();

        Log::info('Newsletter : Updated email', [
            'old_email' => $data['old_email'],
            'new_email' => $data['new_email'],
            'subscription' => $event->subscription,
        ]);
    }
}
