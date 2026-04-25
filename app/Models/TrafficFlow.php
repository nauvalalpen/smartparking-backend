<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TrafficFlow extends Model
{
    protected $table = 'trafficflows';
    protected $primaryKey = 'id_traffic';
    protected $fillable =['id_kamera', 'tanggal', 'kendaraan_masuk', 'kendaraan_keluar'];
}