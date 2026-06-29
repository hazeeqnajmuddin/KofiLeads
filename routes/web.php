<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;


Route::get('/', function () {
    return view('landing');
});

// Simple route to access the admin portal
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');