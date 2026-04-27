<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\TrafficFlowController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route untuk Aplikasi Mobile / Pengunjung (Read Only)
Route::get('/public/slots', [SlotController::class, 'getPublicSlots']);

// Route untuk Sistem AI Python (Update Data)
Route::put('/ai/slot-update', [SlotController::class, 'updateStatusAI']);
Route::post('/ai/traffic-count', [TrafficFlowController::class, 'incrementTraffic']);

// Route untuk Dashboard Admin (Read Data)
Route::get('/traffic/stats', [TrafficFlowController::class, 'getStats']);