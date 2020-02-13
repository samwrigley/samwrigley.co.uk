<?php

use Illuminate\View\View;

Route::get('/', static function (): View {
    return view('pages.landing');
})->name('home');

Route::get('services', static function (): View {
    return view('pages.services');
})->name('services');

Route::get('about', static function (): View {
    return view('pages.about');
})->name('about');

Route::get('contact', function () {
    return view('pages.contact');
})->name('contact');

Route::feeds();
