<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LemburBaruController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GajiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// === GUEST ROUTES (Belum login) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.auth');
});

// === AUTH ROUTES (Admin & Manager: bisa melihat data) ===
Route::middleware(['auth', 'role:admin,manager'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Laporan Lembur
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/pdf', [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('laporan.export.excel');

    // Data Karyawan (lihat)
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::get('/karyawan/{karyawan}', [KaryawanController::class, 'show'])->name('karyawan.show');

    // Data Lembur (lihat)
    Route::get('/lembur', [LemburBaruController::class, 'index'])->name('lembur.index');
    Route::get('/lembur/{lembur}', [LemburBaruController::class, 'show'])->name('lembur.show');

    // Data Gaji (lihat)
    Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');

    // Export PDF/Excel Gaji dengan filter bulan & nama/NIP
    Route::get('/gaji/export/pdf', [GajiController::class, 'exportPdf'])->name('gaji.exportPdf');
    Route::get('/gaji/export/excel', [GajiController::class, 'exportExcel'])->name('gaji.exportExcel');

    // API untuk ambil total lembur (dipakai di form gaji)
    Route::get('/gaji/total-lembur', [GajiController::class, 'getTotalLembur'])->name('gaji.total_lembur');
});

// === MANAGER ONLY ROUTES (akses penuh untuk kelola data) ===
Route::middleware(['auth', 'role:manager'])->group(function () {
    // Karyawan (kelola + export)
    Route::resource('karyawan', KaryawanController::class)->except(['index', 'show']);
    Route::get('/karyawan/export', [KaryawanController::class, 'export'])->name('karyawan.export');

    // Lembur (kelola)
    Route::resource('lembur', LemburBaruController::class)->except(['index', 'show']);

    // Gaji (tambah/edit/hapus)
    Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');
    Route::put('/gaji/{gaji}', [GajiController::class, 'update'])->name('gaji.update');
    Route::delete('/gaji/{gaji}', [GajiController::class, 'destroy'])->name('gaji.destroy');
});
