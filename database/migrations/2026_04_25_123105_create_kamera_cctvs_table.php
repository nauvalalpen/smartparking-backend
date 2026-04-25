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
        Schema::create('kamera_cctvs', function (Blueprint $table) {
            $table->id('id_kamera');
            // Foreign Key ke tabel areas
            $table->foreignId('id_area')->constrained('areas', 'id_area')->onDelete('cascade');
            $table->string('nama_kamera');
            $table->text('rtsp_url');
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamera_cctvs');
    }
};
