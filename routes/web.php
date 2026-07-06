<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;

Route::get('/', function () {
    return view('landing');
});

// Admin auth (public)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminDashboardController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminDashboardController::class, 'login'])->name('login.submit');
});

// Admin panel (protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::post('/logout',     [AdminDashboardController::class, 'logout'])->name('logout');
    Route::get('/dashboard',   [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/permohonan',  [AdminDashboardController::class, 'permohonan'])->name('permohonan');
    Route::get('/laporan',     [AdminDashboardController::class, 'laporan'])->name('laporan');
    Route::get('/landing',     [AdminDashboardController::class, 'landing'])->name('landing');
});
