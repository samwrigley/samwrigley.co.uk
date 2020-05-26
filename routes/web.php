<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/blog')->name('home');
Route::view('about', 'pages.about')->name('about');
Route::view('contact', 'pages.contact')->name('contact');
Route::view('tailwind', 'pages.tailwind')->name('tailwind');

Route::feeds();
