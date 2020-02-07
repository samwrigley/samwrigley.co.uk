<?php

Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () {
    Route::post('subscribe', 'NewsletterController')->name('subscribe');
});
