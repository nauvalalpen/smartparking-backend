<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KameraCctv;
use App\Models\Slot;
use App\Models\TrafficFlow;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Kartu Statistik (Widget)
        $total_kamera = KameraCctv::where('status', 'aktif')->count();
        $total_slot = Slot::count();
        $slot_terisi = Slot::where('status', 'terisi')->count();
        $sisa_slot = $total_slot - $slot_terisi;

        // 2. Data untuk Grafik (Chart.js) - Mengambil data 7 hari terakhir
        $tujuh_hari_lalu = Carbon::now()->subDays(6)->toDateString();
        
        $traffic_data = TrafficFlow::where('tanggal', '>=', $tujuh_hari_lalu)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Menyiapkan array kosong untuk dikirim ke Javascript (Chart.js)
        $labels =[];
        $data_masuk = [];
        $data_keluar = [];

        foreach ($traffic_data as $traffic) {
            $labels[] = Carbon::parse($traffic->tanggal)->format('d M'); // Format: 25 Apr
            $data_masuk[] = $traffic->kendaraan_masuk;
            $data_keluar[] = $traffic->kendaraan_keluar;
        }

        // Mengirim semua data ke halaman View 'dashboard'
        return view('dashboard', compact(
            'total_kamera', 'total_slot', 'sisa_slot', 
            'labels', 'data_masuk', 'data_keluar'
        ));
    }
}