<?php

use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], static function (): void {
    Route::post('subscribe', [NewsletterController::class, 'store'])->name('subscribe');
    Route::post('unsubscribe', [NewsletterController::class, 'destroy'])->name('unsubscribe');
});
