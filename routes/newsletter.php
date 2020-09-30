<?php

use App\Http\Controllers\NewsletterSubscriptionController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], static function (): void {
    Route::post('subscribe', NewsletterSubscriptionController::class)->name('subscribe');
});
