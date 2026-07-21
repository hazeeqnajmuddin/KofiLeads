<?php

use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MergedDocumentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LeadSubmissionController;
use Illuminate\Support\Facades\Route;

// Public landing page.
Route::get('/', function () {
    return view('landing');
});

// Public lead intake — rate-limited to 5 submissions per minute per IP (Phase 7 hardening).
Route::post('/leads', [LeadSubmissionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('leads.store');
Route::get('/terima-kasih', [LeadSubmissionController::class, 'thankYou'])->name('leads.thankyou');

// Signed, expiring link to a lead's merged PDF (Phase 9, Slice 2).
Route::get('/dokumen/gabungan/{lead}', [MergedDocumentController::class, 'signed'])->name('merged.signed');

// Admin login — open to guests only (redirect authenticated users away in bootstrap/app.php).
Route::get('/admin/login', [AdminDashboardController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->middleware('auth')->name('admin.logout');

// Admin panel — requires authentication.
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');

    // Site settings — Tetapan Laman (Phase 5).
    Route::get('/landing', [SettingController::class, 'edit'])->name('landing');
    Route::post('/landing', [SettingController::class, 'update'])->name('landing.update');

    // Lead management (Phase 4).
    Route::get('/permohonan', [LeadController::class, 'index'])->name('permohonan');
    Route::patch('/permohonan/{lead}', [LeadController::class, 'updateStatus'])->name('leads.updateStatus');
    Route::delete('/permohonan/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
    Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('dokumen.download');

    // Merged PDF of a lead's documents — inline view (Phase 9, Slice 1).
    Route::get('/permohonan/{lead}/pdf', [MergedDocumentController::class, 'show'])->name('leads.pdf');

    // Account management.
    Route::get('/akaun', [AccountController::class, 'edit'])->name('akaun');
    Route::post('/akaun', [AccountController::class, 'update'])->name('akaun.update');
});
