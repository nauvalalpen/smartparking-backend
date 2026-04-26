<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrafficFlow;
use App\Exports\TrafficExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // Menampilkan halaman Laporan dengan Filter Tanggal
    public function index(Request $request)
    {
        // Default: Tampilkan data bulan ini
        $start_date = $request->start_date ?? Carbon::now()->startOfMonth()->toDateString();
        $end_date = $request->end_date ?? Carbon::now()->toDateString();

        $traffics = TrafficFlow::with(['kamera.area'])
            ->whereBetween('tanggal', [$start_date, $end_date])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan.index', compact('traffics', 'start_date', 'end_date'));
    }

    // Fungsi Export PDF
    public function exportPdf(Request $request)
    {
        $traffics = TrafficFlow::with(['kamera.area'])
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('laporan.cetak', compact('traffics'));
        return $pdf->download('Laporan_Arus_Kendaraan_'.$request->start_date.'_sd_'.$request->end_date.'.pdf');
    }

    // Fungsi Export Excel
    public function exportExcel(Request $request)
    {
        $traffics = TrafficFlow::with(['kamera.area'])
            ->whereBetween('tanggal', [$request->start_date, $request->end_date])
            ->orderBy('tanggal', 'desc')
            ->get();

        return Excel::download(new TrafficExport($traffics), 'Laporan_Arus_Kendaraan_'.$request->start_date.'_sd_'.$request->end_date.'.xlsx');
    }
}