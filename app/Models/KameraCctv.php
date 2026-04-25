<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class KameraCctv extends Model
{
    protected $table = 'kamera_cctvs';
    protected $primaryKey = 'id_kamera';
    protected $fillable =['id_area', 'nama_kamera', 'rtsp_url', 'status'];

    public function slots() {
        return $this->hasMany(Slot::class, 'id_kamera', 'id_kamera');
    }

    public function area() {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }
}
