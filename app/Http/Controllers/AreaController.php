<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\KameraCctv;
use App\Models\Slot;
use Illuminate\Support\Facades\DB;

class AreaController extends Controller
{
    // 1. Menampilkan Tabel Data Area dengan Jumlah Slot
    public function index()
    {
        // Mengambil semua area dengan perhitungan slot per area
        $areas = Area::with('kameras')
            ->get()
            ->map(function ($area) {
                // Hitung total slot untuk area ini dari semua kameranya
                $totalSlots = Slot::whereIn(
                    'id_kamera',
                    $area->kameras()->pluck('id_kamera')->toArray()
                )->count();
                
                // Hitung slot yang terisi
                $filledSlots = Slot::whereIn(
                    'id_kamera',
                    $area->kameras()->pluck('id_kamera')->toArray()
                )->where('status', 'terisi')->count();
                
                $area->total_slots = $totalSlots;
                $area->filled_slots = $filledSlots;
                $area->available_slots = $totalSlots - $filledSlots;
                
                return $area;
            });

        return view('area.index', compact('areas'));
    }

    // 2. Menampilkan Form Tambah Area
    public function create()
    {
        return view('area.create');
    }

    // 3. Menyimpan Data Area ke Database
    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kapasitas_total' => 'required|integer|min:1'
        ]);

        Area::create([
            'id_pengguna' => auth()->id(),
            'nama_area' => $request->nama_area,
            'deskripsi' => $request->deskripsi,
            'kapasitas_total' => $request->kapasitas_total
        ]);

        return redirect()->route('area.index')->with('success', 'Area Parkiran berhasil ditambahkan!');
    }

    // 4. Menampilkan Form Edit Area
    public function edit($id)
    {
        $area = Area::findOrFail($id);
        return view('area.edit', compact('area'));
    }

    // 5. Menyimpan Perubahan Area
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_area' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kapasitas_total' => 'required|integer|min:1'
        ]);

        $area = Area::findOrFail($id);
        $area->update([
            'nama_area' => $request->nama_area,
            'deskripsi' => $request->deskripsi,
            'kapasitas_total' => $request->kapasitas_total
        ]);

        return redirect()->route('area.index')->with('success', 'Area Parkiran berhasil diperbarui!');
    }

    // 6. Menghapus Area
    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        
        // Cek apakah ada kamera di area ini
        if ($area->kameras()->count() > 0) {
            return redirect()->route('area.index')
                ->with('error', 'Tidak dapat menghapus area karena masih ada kamera yang terkait!');
        }

        $area->delete();
        return redirect()->route('area.index')->with('success', 'Area Parkiran berhasil dihapus!');
    }
}
