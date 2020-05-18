<?php

return [
    'names' => [
        'newsletter' => 'mailchimp',
    ],
    'configs' => [
        [
            'name' => 'mailchimp',
            'signing_secret' => env('WEBHOOK_CLIENT_SECRET'),
            'signature_validator' => \App\Http\Webhooks\SignatureValidators\MailChimpSignatureValidator::class,
            'webhook_profile' => \App\Http\Webhooks\Profiles\MailChimpWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => \App\Jobs\ProcessMailChimpWebhookJob::class,
        ],
    ],
];
