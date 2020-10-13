<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'confirm' => false,
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::middleware(['cacheResponse', 'csp', 'cache.headers:public;max_age=604800;etag'])
    ->group(function () {
        Route::redirect('/', '/blog')->name('home');
        Route::view('about', 'pages.about')->name('about');
    });

Route::feeds();
