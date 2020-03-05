<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

Route::get('/', static fn (): RedirectResponse
    => Redirect::route('blog.articles.index'))->name('home');

Route::get('about', static fn (): View
    => view('pages.about'))->name('about');

Route::get('contact', static fn (): View
    => view('pages.contact'))->name('contact');

Route::feeds();
