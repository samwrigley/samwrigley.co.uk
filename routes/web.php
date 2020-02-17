<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', static function (): RedirectResponse {
    return Redirect::route('blog.articles.index');
})->name('home');

Route::get('about', static function (): View {
    return view('pages.about');
})->name('about');

Route::get('contact', static function (): View {
    return view('pages.contact');
})->name('contact');

Route::feeds();
