<?php

use App\Http\Controllers\Admin\Auth\AdminRegistrationController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CategoryTranslationController;

Route::post('login', [LoginController::class, 'login'])->name('api.admin.login');

Route::group(['middleware' => 'auth:admin', 'as' => 'api.admin.'], static function (): void {
    
    Route::post('register', [AdminRegistrationController::class, 'store'])->name('api.admin.register');

    Route::resource('languages', LanguageController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('categories', CategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('category-translations', CategoryTranslationController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    

});