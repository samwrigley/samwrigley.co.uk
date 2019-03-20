<?php

use App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

// Blog
Route::group(['prefix' => 'blog', 'as' => 'blog.'], function () {
    // Articles
    Route::group(['prefix' => 'articles', 'as' => 'articles.'], function () {
        Route::get('/', [ArticleController::class, 'index'])->name('index');
        Route::get('{article}', [ArticleController::class, 'show'])->name('show');
    });

    // Categories
    Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
        Route::get('/', [ArticleCategoryController::class, 'index'])->name('index');
        Route::get('{category}', [ArticleCategoryController::class, 'show'])->name('show');
    });
});
