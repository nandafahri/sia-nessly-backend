<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Hapus foreign key lama, jika ada
            $table->dropForeign(['wali_kelas_id']);
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // kembalikan FK jika rollback
            $table->foreign('wali_kelas_id')
                  ->references('id')
                  ->on('gurus')
                  ->nullOnDelete();
        });
    }
};
