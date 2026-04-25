<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SlotHistory extends Model
{
    protected $table = 'slothistories';
    protected $primaryKey = 'id_riwayat';
    public $timestamps = false; // Karena kita pakai waktu_terisi & waktu_kosong manual
    protected $fillable = ['id_slot', 'waktu_terisi', 'waktu_kosong'];
}