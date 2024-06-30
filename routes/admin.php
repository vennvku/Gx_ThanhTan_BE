<?php

use App\Http\Controllers\Admin\Auth\AdminRegistrationController;
use App\Http\Controllers\Admin\Auth\LoginController;

Route::post('register', [AdminRegistrationController::class, 'store'])->name('api.admin.register');
Route::post('login', [LoginController::class, 'login'])->name('api.admin.login');