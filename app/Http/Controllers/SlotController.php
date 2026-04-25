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
        $slots = Slot::all();
        $total = $slots->count();
        $terisi = $slots->where('status', 'terisi')->count();
        
        return response()->json([
            'status' => 'success',
            'summary' =>[
                'total_slot' => $total,
                'sisa_slot' => $total - $terisi,
            ],
            'data' => $slots
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
   
    public function createRoi($kamera_id)
    {
        $kamera = \App\Models\KameraCctv::findOrFail($kamera_id);
        
        // Ambil daftar slot yang sudah pernah digambar di kamera ini
        $slots = \App\Models\Slot::where('id_kamera', $kamera_id)->get();
        
        return view('roi.create', compact('kamera', 'slots'));
    }

    // WEB: Menyimpan data Poligon ke Database
    public function storeRoi(Request $request)
    {
        $request->validate([
            'id_kamera' => 'required|integer',
            'nama_slot' => 'required|string|max:50',
            'koordinat_roi' => 'required|string' // Format JSON
        ]);

        \App\Models\Slot::create([
            'id_kamera' => $request->id_kamera,
            'nama_slot' => $request->nama_slot,
            'koordinat_roi' => $request->koordinat_roi,
            'status' => 'kosong'
        ]);

        return back()->with('success', 'Slot Parkir (RoI) berhasil digambar dan disimpan!');
    }
}
