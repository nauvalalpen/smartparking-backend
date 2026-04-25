<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrafficFlow;
use Carbon\Carbon;

class TrafficFlowController extends Controller
{
    // API POST: Untuk AI (Python) saat mendeteksi mobil lewat garis
    public function incrementTraffic(Request $request)
    {
        $request->validate([
            'id_kamera' => 'required|integer',
            'jenis' => 'required|in:masuk,keluar' // arah kendaraan
        ]);

        $today = Carbon::now()->toDateString();

        // Cari data hari ini, jika belum ada (hari baru), buat record baru
        $traffic = TrafficFlow::firstOrCreate(['id_kamera' => $request->id_kamera, 'tanggal' => $today],['kendaraan_masuk' => 0, 'kendaraan_keluar' => 0]
        );

        if ($request->jenis == 'masuk') {
            $traffic->increment('kendaraan_masuk');
        } else {
            $traffic->increment('kendaraan_keluar');
        }

        return response()->json(['message' => 'Traffic Flow Counter +1 Success!'], 200);
    }
}