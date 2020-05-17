<?php

namespace App\Http\Webhooks\SignatureValidators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class MailChimpSignatureValidator implements SignatureValidator
{
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $secret = $request->query('secret');

        if (! $secret) {
            Log::info('Newsletter : Webhook : Invalid call : Empty secret', ['request' => $request]);

            return false;
        }

        if ($secret !== $config->signingSecret) {
            Log::info('Newsletter : Webhook : Invalid call : Invalid secret', ['request' => $request]);

            return false;
        }

        Log::info('Newsletter : Webhook : Valid call : Valid secret', ['request' => $request]);

        return true;
    }
}
