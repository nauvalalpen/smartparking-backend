<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KameraController;

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

// Route untuk Fitur Gambar RoI
Route::get('/roi/config/{kamera_id}', [\App\Http\Controllers\SlotController::class, 'createRoi'])->name('roi.config');
Route::post('/roi/store',[\App\Http\Controllers\SlotController::class, 'storeRoi'])->name('roi.store');

require __DIR__.'/auth.php';
