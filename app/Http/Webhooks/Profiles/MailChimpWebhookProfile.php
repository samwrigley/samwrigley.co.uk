<?php

namespace App\Http\Webhooks\Profiles;

use App\Enums\MailChimpWebhookType;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class MailChimpWebhookProfile implements WebhookProfile
{
    public function shouldProcess(Request $request): bool
    {
        return $request->type === MailChimpWebhookType::UNSUBSCRIBE;
    }
}
