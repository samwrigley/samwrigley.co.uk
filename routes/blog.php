<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleSeriesController;
use Illuminate\Support\Facades\Route;

Route::name('blog.')
    ->prefix('blog')
    ->middleware(['cacheResponse', 'cache.headers:public;max_age=604800;etag'])
    ->group(static function (): void {
        Route::group(['prefix' => 'categories', 'as' => 'categories.'], static function (): void {
            Route::get('/', [ArticleCategoryController::class, 'index'])->name('index');
            Route::get('{category}', [ArticleCategoryController::class, 'show'])->name('show');
        });

        Route::group(['prefix' => 'series', 'as' => 'series.'], static function (): void {
            Route::get('/', [ArticleSeriesController::class, 'index'])->name('index');
            Route::get('{series}', [ArticleSeriesController::class, 'show'])->name('show');
        });

        Route::group(['as' => 'articles.'], static function (): void {
            Route::get('/', [ArticleController::class, 'index'])->name('index');
            Route::get('{article}', [ArticleController::class, 'show'])
                ->withoutMiddleware(['cacheResponse', 'cache.headers'])
                ->name('show');
        });
    });
