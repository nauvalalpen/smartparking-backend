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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan 2 kolom baru setelah kolom 'role'
            $table->string('area_penugasan')->nullable()->after('role');
            $table->string('shift_kerja')->nullable()->after('area_penugasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kolom jika kita melakukan rollback
            $table->dropColumn(['area_penugasan', 'shift_kerja']);
        });
    }
};
