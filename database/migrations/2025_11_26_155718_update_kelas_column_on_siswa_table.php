<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {

            // Hapus kolom kelas lama
            if (Schema::hasColumn('siswa', 'kelas')) {
                $table->dropColumn('kelas');
            }

            // Tambah kolom kelas_id
            $table->unsignedBigInteger('kelas_id')->after('nisn');

            // Tambahkan foreign key
            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {

            // Kembalikan kolom kelas
            $table->string('kelas', 50);

            // Hapus foreign key & kolom kelas_id
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });
    }
};
