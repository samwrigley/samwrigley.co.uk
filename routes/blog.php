<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;

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
