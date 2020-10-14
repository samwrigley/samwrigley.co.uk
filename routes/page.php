<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/blog')->name('home');
Route::view('about', 'pages.about')->name('about');
