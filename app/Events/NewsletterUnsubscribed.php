<?php

namespace App\Events;

use App\NewsletterSubscription;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class NewsletterUnsubscribed
{
    use Dispatchable, SerializesModels;

    public NewsletterSubscription $subscription;

    public WebhookCall $webhookCall;

    public function __construct(NewsletterSubscription $subscription, WebhookCall $webhookCall)
    {
        $this->subscription = $subscription;
        $this->webhookCall = $webhookCall;
    }
}
