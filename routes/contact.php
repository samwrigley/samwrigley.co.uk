<?php

Route::get('contact', function () {
    return view('pages.contact');
})->name('contact');

Route::post('contact', 'ContactController')->name('contact.store');
