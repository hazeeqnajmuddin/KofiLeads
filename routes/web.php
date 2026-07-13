<?php

use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MergedDocumentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\LeadSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

// Public lead intake (landing page form). No auth — this is the public submission.
Route::post('/leads', [LeadSubmissionController::class, 'store'])->name('leads.store');

// Admin panel. NOTE: no auth middleware yet — Phase 3 (auth) is deferred.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminDashboardController::class, 'showLogin'])->name('login');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');

    // Site settings — "Tetapan Laman" (Phase 5)
    Route::get('/landing', [SettingController::class, 'edit'])->name('landing');
    Route::post('/landing', [SettingController::class, 'update'])->name('landing.update');

    // Lead management (Phase 4)
    Route::get('/permohonan', [LeadController::class, 'index'])->name('permohonan');
    Route::patch('/permohonan/{lead}', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
    Route::delete('/permohonan/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('dokumen.download');
    // Merged PDF of a lead's documents — inline view (Phase 9, Slice 1)
    Route::get('/permohonan/{lead}/pdf', [MergedDocumentController::class, 'show'])->name('leads.pdf');
});
