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

    // 3.5 Menampilkan Form Edit Kamera
    public function edit($id)
    {
        $kamera = KameraCctv::findOrFail($id);
        $areas = Area::all();
        return view('kamera.edit', compact('kamera', 'areas'));
    }

    // 3.75 Menyimpan Perubahan Data (Proses Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_area' => 'required|integer',
            'nama_kamera' => 'required|string|max:255',
            'rtsp_url' => 'required|url',
            'status' => 'required|in:aktif,tidak_aktif'
        ]);

        $kamera = KameraCctv::findOrFail($id);
        $kamera->update($request->all());

        return redirect()->route('kamera.index')->with('success', 'Kamera CCTV berhasil diperbarui!');
    }

    // 4. Menghapus Data (Proses Delete)
    public function destroy($id)
    {
        $kamera = KameraCctv::findOrFail($id);
        $kamera->delete();

        return redirect()->route('kamera.index')->with('success', 'Kamera CCTV berhasil dihapus!');
    }
}