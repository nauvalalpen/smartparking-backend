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
        Schema::create('trafficflows', function (Blueprint $table) {
            $table->id('id_traffic');
            // Foreign Key ke tabel kamera_cctvs
            $table->foreignId('id_kamera')->constrained('kamera_cctvs', 'id_kamera')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('kendaraan_masuk')->default(0);
            $table->integer('kendaraan_keluar')->default(0);
            $table->timestamps(); // Menyediakan created_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trafficflows');
    }
};
