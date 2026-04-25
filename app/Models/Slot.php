<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $table = 'slots';
    protected $primaryKey = 'id_slot';
    protected $fillable =['id_kamera', 'nama_slot', 'koordinat_roi', 'status'];

    public function histories() {
        return $this->hasMany(SlotHistory::class, 'id_slot', 'id_slot');
    }
}
