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
        $areas = Area::all(); // Mengambil data area untuk dropdown modal
        return view('kamera.index', compact('kameras', 'areas'));
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
        $slots = \App\Models\Slot::where('id_kamera', $id)->get();
        return view('kamera.edit', compact('kamera', 'areas', 'slots'));
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
    // Menyimpan koordinat Garis Traffic Flow
    public function storeGaris(Request $request, $id_kamera)
    {
        $request->validate([
            'koordinat_garis' => 'required|json'
        ]);

        $kamera = \App\Models\KameraCctv::findOrFail($id_kamera);
        $kamera->koordinat_garis = $request->koordinat_garis;
        $kamera->save();

        return redirect()->back()->with('success', 'Garis Traffic Flow berhasil disimpan!');
    }

// Fungsi untuk menyalakan skrip Python AI
    public function startAi($id_kamera)
    {
        $kamera = \App\Models\KameraCctv::findOrFail($id_kamera);

        // =========================================================
        // ⚠️ PENTING: GANTI PATH INI SESUAI LOKASI FOLDER AI ANDA!
        // Gunakan garis miring terbalik ganda (\\) untuk Windows.
        // Berdasarkan log error Anda sebelumnya, path-nya adalah:
        // =========================================================
        $ai_folder = "D:\\Kuliah SMT6 - TRPL 3D\\Capstone Project\\Aplikasi\\smartparking_ai";

        // Menyusun Command (Perintah) untuk Windows CMD
        // 1. Membuka CMD baru dengan judul window "SmartParking AI"
        // 2. Berpindah (cd) ke folder AI
        // 3. Menggunakan python.exe dari dalam folder venv
        // 4. Menjalankan main.py dengan argumen ID Kamera
        
        $command = 'start "SmartParking AI - Kamera ' . $id_kamera . '" cmd /k "cd /d "' . $ai_folder . '" && venv\Scripts\python.exe main.py ' . $id_kamera . '"';

        // Mengeksekusi perintah di background tanpa membuat Laravel loading/menunggu lama
        pclose(popen($command, "r"));

        // Mengembalikan pesan sukses ke Web
        return redirect()->back()->with('success', 'Sistem AI untuk Kamera ' . $kamera->nama_kamera . ' berhasil dijalankan! Silakan cek jendela Terminal baru yang terbuka.');
    }

    // 4. Menghapus Data (Proses Delete)
    public function destroy($id)
    {
        $kamera = KameraCctv::findOrFail($id);
        $kamera->delete();

        return redirect()->route('kamera.index')->with('success', 'Kamera CCTV berhasil dihapus!');
    }
}