<?php

use App\Http\Controllers\ContactController;

Route::get('contact', [ContactController::class, 'show'])->name('contact');
Route::post('contact', [ContactController::class, 'store'])->name('contact.store');
