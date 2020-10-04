<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'confirm' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::middleware(['cacheResponse', 'csp'])->group(function () {
    Route::redirect('/', '/blog')->name('home');
    Route::view('about', 'pages.about')->name('about');
});

Route::feeds();
