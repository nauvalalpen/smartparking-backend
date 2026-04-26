<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KameraController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Utama untuk Admin
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route untuk CRUD Kamera CCTV
Route::resource('kamera', KameraController::class)->middleware(['auth', 'verified']);

// Route untuk Halaman Konfigurasi RoI
Route::get('/kamera/{id_kamera}/roi', [SlotController::class, 'createRoi'])->name('kamera.roi');
Route::post('/kamera/{id_kamera}/roi',[SlotController::class, 'storeRoi'])->name('kamera.roi.store');

// Route untuk Kelola Data Pengguna (Petugas)
Route::resource('pengguna', UserController::class)->middleware(['auth', 'verified']);

// Route Laporan dan Export
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

require __DIR__.'/auth.php';
