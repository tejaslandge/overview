<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Public Routes (No Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [VideoController::class, 'overview'])
    ->name('videos.index');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [AdminLoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AdminLoginController::class, 'login'])
    ->name('login.submit');

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->group(function () {

    // Admin dashboard
    Route::get('/overview', [VideoController::class, 'index'])
        ->name('admin.dashboard');

    // Upload
    Route::get('/upload', [VideoController::class, 'create'])
        ->name('videos.create');

    Route::post('/upload', [VideoController::class, 'store'])
        ->name('videos.store');

    // Edit / Update
    Route::get('/videos/{video}/edit', [VideoController::class, 'edit'])
        ->name('videos.edit');

    Route::put('/videos/{video}', [VideoController::class, 'update'])
        ->name('videos.update');

    // Delete
    Route::delete('/videos/{video}', [VideoController::class, 'destroy'])
        ->name('videos.destroy');

    // Logout (ADMIN ONLY)
    Route::post('/logout', [AdminLoginController::class, 'logout'])
        ->name('logout');
});
