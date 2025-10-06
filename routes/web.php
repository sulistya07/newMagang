<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;

//Landing Page
Route::get('/', function () {
    return view('landing', ['title' => 'Ekstrakurikuler Siswa Smkn 7 Batam']);
})->name('landing');

//Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dasboard (protected)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ekstrakurikuler
    Route::view('/ekstrakurikuler','ekastrakurikuler.index')->name('ekstrakurikuler.index');
    Route::view('/ekstrakurikuler/create', 'ekastrakurikuler.create')->name('ekstrakurikuler.create');
    Route::view('/ekstrakurikuler/edit', 'ekstrakurikuler.edit')->name('ekstrakurikuler.edit');
    Route::view('/ekstrakurikuler/delete', 'ekastrakurikuler.delete')->name('ekstrakurikuler.delete');
});

