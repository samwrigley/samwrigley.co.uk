<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('contact', [ContactController::class, 'show'])->middleware('doNotCacheResponse')->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
