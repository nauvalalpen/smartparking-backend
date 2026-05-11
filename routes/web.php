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

// --- ROUTE KAMERA CCTV & PENGGUNA (Otomatis mencakup edit & hapus) ---
Route::resource('kamera', KameraController::class)->middleware(['auth', 'verified']);
Route::resource('pengguna', UserController::class)->middleware(['auth', 'verified']);

// --- ROUTE KONFIGURASI ROI (TERPISAH) ---
Route::get('/konfigurasi-roi', [SlotController::class, 'indexRoi'])->name('roi.index');
Route::post('/konfigurasi-roi/store', [SlotController::class, 'storeRoi'])->name('roi.store');
Route::get('/konfigurasi-roi/{id}/edit', [SlotController::class, 'editRoi'])->name('roi.edit');
Route::put('/konfigurasi-roi/{id}', [SlotController::class, 'updateRoi'])->name('roi.update');
Route::delete('/konfigurasi-roi/{id}', [SlotController::class, 'destroyRoi'])->name('roi.destroy');

// Route untuk Halaman Konfigurasi RoI
Route::get('/kamera/{id_kamera}/roi', [SlotController::class, 'createRoi'])->name('kamera.roi');
Route::post('/kamera/{id_kamera}/roi',[SlotController::class, 'storeRoi'])->name('kamera.roi.store');


// Route Laporan dan Export
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
Route::get('/laporan/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

require __DIR__.'/auth.php';
