<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\NewsletterController;

Route::get('/', function () {
    return view('pages.landing');
});

Route::get('about', function () {
    return view('pages.about');
})->name('about');

// Blog
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
    // Categories
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', [ArticleCategoryController::class, 'index'])->name('index');
        Route::get('{category}', [ArticleCategoryController::class, 'show'])->name('show');
    });

    // Articles
    Route::group(['as' => 'articles.'], function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('{article}', [ArticleController::class, 'show'])->name('show');
    });
});

// Newsletter
Route::group(['prefix' => 'newsletter', 'as' => 'newsletter.'], function () {
    Route::post('subscribe', [NewsletterController::class, 'store'])->name('subscribe');
});
