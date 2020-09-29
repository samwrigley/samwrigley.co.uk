<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'confirm' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::redirect('/', '/blog')->middleware('cacheResponse')->name('home');
Route::view('about', 'pages.about')->middleware('cacheResponse')->name('about');
Route::view('contact', 'pages.contact')->name('contact');

Route::feeds();
