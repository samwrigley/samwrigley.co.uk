<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], static function (): void {
    Route::post('subscribe', 'NewsletterSubscriptionController')->name('subscribe');
});

Route::webhooks('webhooks/newsletter', 'mailchimp');
