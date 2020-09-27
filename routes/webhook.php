<?php

use App\Http\Controllers\Webhooks\NewsletterWebhookTestController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/newsletter', Config::get('webhook-client.names.newsletter'));

Route::get('webhooks/newsletter', NewsletterWebhookTestController::class)
    ->name('newsletter-webhook-test');
