<?php

use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MergedDocumentController;
use App\Http\Controllers\Admin\ReferenceCodeController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
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

// Public link to a lead's merged PDF — carried into the WhatsApp message. Uses an
// unguessable token in the PATH (no query string, so WhatsApp can't split it on "&").
Route::get('/dokumen/gabungan/{token}', [MergedDocumentController::class, 'token'])->name('merged.token');

// Admin login — open to guests only (redirect authenticated users away in bootstrap/app.php).
Route::get('/admin/login', [AdminDashboardController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [LoginController::class, 'logout'])->middleware('auth')->name('admin.logout');

// Password reset ("Lupa kata laluan") — guest flow via Laravel's password broker.
// The POST that emails the link is IP-throttled on top of the broker's per-user throttle.
Route::get('/admin/forgot-password', [PasswordResetController::class, 'showLinkRequest'])->name('admin.password.request');
Route::post('/admin/forgot-password', [PasswordResetController::class, 'sendLink'])
    ->middleware('throttle:5,1')
    ->name('admin.password.email');
Route::get('/admin/reset-password/{token}', [PasswordResetController::class, 'showReset'])->name('admin.password.reset');
Route::post('/admin/reset-password', [PasswordResetController::class, 'update'])
    ->middleware('throttle:5,1')
    ->name('admin.password.update');

// Admin panel — requires authentication.
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');

    // Site settings — Tetapan Laman (Phase 5).
    Route::get('/landing', [SettingController::class, 'edit'])->name('landing');
    Route::post('/landing', [SettingController::class, 'update'])->name('landing.update');

    // Reference-code manager — "Kod Rujukan" (Phase 10, Slice B)
    Route::post('/kod-rujukan', [ReferenceCodeController::class, 'store'])->name('kod-rujukan.store');
    Route::patch('/kod-rujukan/{referenceCode}/aktif', [ReferenceCodeController::class, 'activate'])->name('kod-rujukan.activate');
    Route::delete('/kod-rujukan/{referenceCode}', [ReferenceCodeController::class, 'destroy'])->name('kod-rujukan.destroy');

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
