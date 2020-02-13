<?php

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function (): void {
    Route::post('subscribe', 'NewsletterController')->name('subscribe');
});
