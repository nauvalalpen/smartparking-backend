<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KameraCctv;
use App\Models\Area;

class KameraController extends Controller
{
    // 1. Menampilkan Tabel Data
    public function index()
    {
        // Mengambil semua data kamera beserta nama areanya
        $kameras = KameraCctv::with('area')->get();
        return view('kamera.index', compact('kameras'));
    }

    // 2. Menampilkan Form Tambah Kamera
    public function create()
    {
        $areas = Area::all(); // Mengambil data area untuk dropdown
        return view('kamera.create', compact('areas'));
    }

    // 3. Menyimpan Data ke Database (Proses Insert)
    public function store(Request $request)
    {
        $request->validate([
            'id_area' => 'required|integer',
            'nama_kamera' => 'required|string|max:255',
            'rtsp_url' => 'required|url',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        KameraCctv::create($request->all());

        return redirect()->route('kamera.index')->with('success', 'Kamera CCTV berhasil ditambahkan!');
    }

    // 4. Menghapus Data (Proses Delete)
    public function destroy($id)
    {
        $kamera = KameraCctv::findOrFail($id);
        $kamera->delete();

        return redirect()->route('kamera.index')->with('success', 'Kamera CCTV berhasil dihapus!');
    }
}