<?php

Route::get('/', function () {
    return view('pages.landing');
})->name('home');

Route::get('services', function () {
    return view('pages.services');
})->name('services');

Route::get('about', function () {
    return view('pages.about');
})->name('about');

Route::get('contact', function () {
    return view('pages.contact');
})->name('contact');
