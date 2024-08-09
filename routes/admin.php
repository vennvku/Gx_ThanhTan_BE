<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AdminRegistrationController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryTranslationController;
use App\Http\Controllers\Admin\ArticleController;

Route::post('login', [LoginController::class, 'login'])->name('api.admin.login');

Route::group(['middleware' => 'auth:admin', 'as' => 'api.admin.'], static function (): void {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('register', [AdminRegistrationController::class, 'store'])->name('api.admin.register');

    Route::resource('languages', LanguageController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('category-translations', CategoryTranslationController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('articles', ArticleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::post('categories/move-up-category', [CategoryController::class, 'moveUpCategory'])
        ->name('categories.move-up-category');
    Route::post('categories/move-bottom-category', [CategoryController::class, 'moveBottomCategory'])
        ->name('categories.move-bottom-category');

    Route::get('get-categories-fixed', [CategoryController::class, 'getCategoriesFixed'])
        ->name('get-categories-fixed');

    Route::post('articles/update-article-management/{id}', [ArticleController::class, 'updateArticleManagement'])
        ->name('articles.update-article-management');

    Route::post('articles/update-articles-action', [ArticleController::class, 'updateArticlesAction'])
        ->name('articles.update-articles-action');

});