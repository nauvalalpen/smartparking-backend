<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\TrafficFlowController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/v1/auth/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();
    
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['status' => 'error', 'message' => 'Kredensial salah'], 401);
    }

    return response()->json([
        'status' => 'success',
        'data' =>[
            'nama_lengkap' => $user->nama_lengkap,
            'email' => $user->email,
            'role' => $user->role,
        ]
    ]);
});


// Route untuk Aplikasi Mobile / Pengunjung (Read Only)
Route::get('/public/slots', [SlotController::class, 'getPublicSlots']);

// Route untuk Sistem AI Python (Update Data)
Route::put('/ai/slot-update', [SlotController::class, 'updateStatusAI']);
Route::post('/ai/traffic-count', [TrafficFlowController::class, 'incrementTraffic']);

// Route untuk Dashboard Admin (Read Data)
Route::get('/traffic/stats', [TrafficFlowController::class, 'getStats']);