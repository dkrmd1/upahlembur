<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LemburBaruController;
use App\Http\Controllers\ReportController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

# === GUEST ROUTES (Belum login) ===
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.auth');
});

# === AUTH ROUTES (Sudah login & role admin) ===
Route::middleware(['auth', 'role:admin'])->group(function () {

    // 🏠 Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 🔓 Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // 👤 Karyawan
    Route::resource('/karyawan', KaryawanController::class)->names('karyawan');
    

    // ⏱️ Lembur (gunakan controller baru)
    Route::resource('lembur', LemburBaruController::class);

    // 📊 Laporan
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    
    // Export laporan PDF dan Excel
    Route::get('/laporan/export/pdf', [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');
    Route::get('/laporan/export/excel', [ReportController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export/pdf', [ReportController::class, 'exportPdf'])->name('laporan.export.pdf');
    
    // Export data karyawan PDF dan Excel
    Route::get('/karyawan/export', [KaryawanController::class, 'export'])->name('karyawan.export');
});
