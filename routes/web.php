<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Ekstrakurikuler\LandingController;

//Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing'); 

//Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dasboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ekstrakurikuler
    Route::view('/ekstrakurikuler/index','ekstrakurikuler.index')->name('ekstrakurikuler.index');
    Route::view('/ekstrakurikuler/create', 'ekstrakurikuler.create')->name('ekstrakurikuler.create');
    Route::view('/ekstrakurikuler/edit', 'ekstrakurikuler.edit')->name('ekstrakurikuler.edit');
    Route::view('/ekstrakurikuler/delete', 'ekstrakurikuler.delete')->name('ekstrakurikuler.delete');
});

