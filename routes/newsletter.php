<?php

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], static function (): void {
    Route::post('subscribe', 'NewsletterController')->name('subscribe');
});
