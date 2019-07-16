<?php

use App\Http\Controllers\NewsletterController;

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () {
    Route::post('subscribe', [NewsletterController::class, 'store'])->name('subscribe');
});
