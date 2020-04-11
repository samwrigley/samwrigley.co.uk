<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

Route::get('/', static function (): RedirectResponse {
    return Redirect::route('blog.articles.index');
})->name('home');

Route::view('about', 'pages.about')->name('about');
Route::view('contact', 'pages.contact')->name('contact');

Route::feeds();
