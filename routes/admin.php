<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.', 'middleware' => 'auth'], static function (): void {
    Route::get('admin', DashboardController::class)->name('dashboard');

    Route::group(['prefix' => 'admin'], static function (): void {
        Route::group(['prefix' => 'articles', 'as' => 'articles.'], static function (): void {
            Route::get('/', [ArticleController::class, 'index'])->name('index');
            Route::get('create', [ArticleController::class, 'create'])->name('create');
            Route::post('/', [ArticleController::class, 'store'])->name('store');
            Route::get('{article}/edit', [ArticleController::class, 'edit'])->name('edit');
            Route::put('{article}', [ArticleController::class, 'update'])->name('update');
            Route::delete('{article}', [ArticleController::class, 'destroy'])->name('destroy');
        });
    });
});
