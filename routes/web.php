<?php

use Illuminate\View\View;

Route::get('/', static function (): View {
    return view('pages.landing');
})->name('home');

Route::get('about', static function (): View {
    return view('pages.about');
})->name('about');

Route::get('contact', static function (): View {
    return view('pages.contact');
})->name('contact');

Route::feeds();
