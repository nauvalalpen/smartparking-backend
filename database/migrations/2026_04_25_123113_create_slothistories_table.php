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
        Schema::create('slothistories', function (Blueprint $table) {
            $table->id('id_riwayat');
            // Foreign Key ke tabel slots
            $table->foreignId('id_slot')->constrained('slots', 'id_slot')->onDelete('cascade');
            $table->dateTime('waktu_terisi');
            $table->dateTime('waktu_kosong')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slothistories');
    }
};
