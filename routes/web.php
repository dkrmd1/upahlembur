<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\LemburBaruController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| GUEST ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.auth');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (ADMIN & MANAGER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,manager'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Akun Setting (bisa untuk admin & manager)
    Route::prefix('akun')->name('akun.')->group(function () {
        Route::get('/setting', [AkunController::class, 'setting'])->name('setting');
        Route::post('/setting', [AkunController::class, 'update'])->name('update');
    });

    // Laporan Lembur
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export/pdf', [ReportController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [ReportController::class, 'exportExcel'])->name('export.excel');
    });

    // Karyawan
    Route::prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/', [KaryawanController::class, 'index'])->name('index');
        Route::post('/', [KaryawanController::class, 'store'])->name('store');
        Route::put('/{karyawan}', [KaryawanController::class, 'update'])->name('update');
        Route::delete('/{karyawan}', [KaryawanController::class, 'destroy'])->name('destroy');
        Route::get('/export', [KaryawanController::class, 'export'])->name('export');
    });

    // Lembur (lihat)
    Route::get('/lembur', [LemburBaruController::class, 'index'])->name('lembur.index');
    Route::get('/lembur/{lembur}', [LemburBaruController::class, 'show'])->name('lembur.show');

    // Gaji (lihat + export)
    Route::prefix('gaji')->name('gaji.')->group(function () {
        Route::get('/', [GajiController::class, 'index'])->name('index');
        Route::get('/export/pdf', [GajiController::class, 'exportPdf'])->name('exportPdf');
        Route::get('/export/excel', [GajiController::class, 'exportExcel'])->name('exportExcel');
        Route::get('/total-lembur', [GajiController::class, 'getTotalLembur'])->name('total_lembur');
    });
});

/*
|--------------------------------------------------------------------------
| MANAGER ROUTES ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:manager'])->group(function () {

    // Lembur (CRUD)
    Route::post('/lembur', [LemburBaruController::class, 'store'])->name('lembur.store');
    Route::get('/lembur/{lembur}/edit', [LemburBaruController::class, 'edit'])->name('lembur.edit');
    Route::put('/lembur/{lembur}', [LemburBaruController::class, 'update'])->name('lembur.update');
    Route::delete('/lembur/{lembur}', [LemburBaruController::class, 'destroy'])->name('lembur.destroy');

    // Gaji (CRUD)
    Route::post('/gaji', [GajiController::class, 'store'])->name('gaji.store');
    Route::put('/gaji/{gaji}', [GajiController::class, 'update'])->name('gaji.update');
    Route::delete('/gaji/{gaji}', [GajiController::class, 'destroy'])->name('gaji.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);

    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
});
