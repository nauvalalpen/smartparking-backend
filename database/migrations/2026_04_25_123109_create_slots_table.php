<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id('id_slot');
            // Foreign Key ke tabel kamera_cctvs
            $table->foreignId('id_kamera')->constrained('kamera_cctvs', 'id_kamera')->onDelete('cascade');
            $table->string('nama_slot', 50);
            $table->text('koordinat_roi');
            $table->enum('status',['kosong', 'terisi'])->default('kosong');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
