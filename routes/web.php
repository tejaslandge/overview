<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\LogController;

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

    // Extra Features
    Route::post('/videos/{video}/toggle-status', [VideoController::class, 'toggleStatus'])
        ->name('videos.toggle-status');

    Route::post('/videos/{video}/track-view', [VideoController::class, 'trackView'])
        ->name('videos.track-view');

    // Logout (ADMIN ONLY)
    Route::post('/logout', [AdminLoginController::class, 'logout'])
        ->name('logout');

    // System Logs
    Route::get('/logs', [LogController::class, 'index'])
        ->name('admin.logs');
    
    Route::delete('/logs', [LogController::class, 'destroy'])
        ->name('admin.logs.destroy');
});
