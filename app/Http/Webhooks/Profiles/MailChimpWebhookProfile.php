<?php

namespace App\Http\Webhooks\Profiles;

use App\Enums\MailChimpWebhookType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\WebhookProfile\WebhookProfile;

class MailChimpWebhookProfile implements WebhookProfile
{
    public function shouldProcess(Request $request): bool
    {
        switch ($request->type) {
            case MailChimpWebhookType::UNSUBSCRIBE:
            case MailChimpWebhookType::UPDATE_MAIL:
                Log::info('Newsletter : Webhook : Valid type', ['request' => $request]);

                return true;
            default:
                Log::info('Newsletter : Webhook : Invalid type', ['request' => $request]);

                return false;
        }
    }
}
