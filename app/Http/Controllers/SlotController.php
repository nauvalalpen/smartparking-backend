<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slot;
use App\Models\SlotHistory;
use Carbon\Carbon;


class SlotController extends Controller
{
    // API GET: Untuk Aplikasi Mobile (Melihat Sisa Parkir)
    public function getPublicSlots()
    {
        $slots = Slot::with('camera')->get();
        $total = $slots->count();
        $terisi = $slots->where('status', 'terisi')->count();
        $kameras = \App\Models\KameraCctv::all();
        return response()->json([
            'status' => 'success',
            'summary' =>[
                'total_slot' => $total,
                'sisa_slot' => $total - $terisi,
            ],
            'data' => $slots,
            'kameras' => $kameras
        ]);
    }

    // API PUT: Untuk AI (Python) saat ada mobil masuk/keluar
    public function updateStatusAI(Request $request)
    {
        $request->validate([
            'id_slot' => 'required|integer',
            'status_baru' => 'required|in:kosong,terisi'
        ]);

        $slot = Slot::findOrFail($request->id_slot);

        // Hanya proses jika status BERUBAH (Sesuai Activity Diagram kita)
        if ($slot->status != $request->status_baru) {
            $slot->status = $request->status_baru;
            $slot->save();

            // Logika Pencatatan Riwayat (History)
            if ($request->status_baru == 'terisi') {
                SlotHistory::create([
                    'id_slot' => $slot->id_slot,
                    'waktu_terisi' => Carbon::now()
                ]);
            } else {
                // Jika kosong, cari riwayat terakhir yang belum ada waktu_kosong-nya
                $history = SlotHistory::where('id_slot', $slot->id_slot)
                                      ->whereNull('waktu_kosong')
                                      ->latest('waktu_terisi')
                                      ->first();
                if ($history) {
                    $history->update(['waktu_kosong' => Carbon::now()]);
                }
            }
            return response()->json(['message' => 'Status Slot & Riwayat Updated!'], 200);
        }

        return response()->json(['message' => 'Status tidak berubah, diabaikan.'], 200);
    }
   
// Menampilkan Halaman Konfigurasi RoI dengan Dropdown
    public function indexRoi(Request $request)
    {
        // Ambil semua kamera yang aktif untuk dropdown
        $kameras = \App\Models\KameraCctv::where('status', 'aktif')->get();
        
        // Tentukan kamera mana yang sedang dipilih (Default: kamera pertama)
        $selectedKameraId = $request->kamera_id ?? ($kameras->first()->id_kamera ?? null);
        $selectedKamera = \App\Models\KameraCctv::find($selectedKameraId);
        
        // Ambil slot hanya untuk kamera yang dipilih
        $slots = $selectedKameraId ? \App\Models\Slot::where('id_kamera', $selectedKameraId)->get() : collect();

        return view('roi.index', compact('kameras', 'selectedKamera', 'slots'));
    }

    // Menyimpan koordinat JSON
    public function storeRoi(Request $request)
    {
        $request->validate([
            'id_kamera' => 'required|integer',
            'nama_slot' => 'required|string|max:50',
            'koordinat_roi' => 'required|json'
        ]);

        \App\Models\Slot::create([
            'id_kamera' => $request->id_kamera,
            'nama_slot' => $request->nama_slot,
            'koordinat_roi' => $request->koordinat_roi,
            'status' => 'kosong'
        ]);

        // Redirect kembali ke halaman RoI dengan kamera yang sama
        return redirect()->route('roi.index', ['kamera_id' => $request->id_kamera])
                         ->with('success', 'Slot Parkir berhasil disimpan!');
    }

    // Menampilkan halaman Canvas untuk menggambar RoI
    public function createRoi($id_kamera)
    {
        $kamera = \App\Models\KameraCctv::findOrFail($id_kamera);
        // Mengambil slot yang sudah ada di kamera ini
        $slots = \App\Models\Slot::where('id_kamera', $id_kamera)->get(); 

        return view('kamera.roi', compact('kamera', 'slots'));
    }

    // Menampilkan form edit slot RoI
    public function editRoi($id)
    {
        $slot = \App\Models\Slot::findOrFail($id);
        $kameras = \App\Models\KameraCctv::where('status', 'aktif')->get();

        return view('roi.edit', compact('slot', 'kameras'));
    }

    // Menyimpan perubahan slot RoI
    public function updateRoi(Request $request, $id)
    {
        $request->validate([
            'nama_slot' => 'required|string|max:50',
            'koordinat_roi' => 'required|json'
        ]);

        $slot = \App\Models\Slot::findOrFail($id);
        $slot->update([
            'nama_slot' => $request->nama_slot,
            'koordinat_roi' => $request->koordinat_roi
        ]);

        return redirect()->route('roi.index', ['kamera_id' => $slot->id_kamera])
                         ->with('success', 'Slot Parkir berhasil diperbarui!');
    }

    // Menghapus slot RoI
    public function destroyRoi($id)
    {
        $slot = \App\Models\Slot::findOrFail($id);
        $id_kamera = $slot->id_kamera;
        $slot->delete();

        return redirect()->route('roi.index', ['kamera_id' => $id_kamera])
                         ->with('success', 'Slot Parkir berhasil dihapus!');
    }
}


