<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';
    protected $primaryKey = 'id_area';
    protected $fillable =['id_pengguna', 'nama_area', 'deskripsi', 'kapasitas_total'];

    // Relasi ke Kamera CCTV
    public function kameras() {
        return $this->hasMany(KameraCctv::class, 'id_area', 'id_area');
    }
}
