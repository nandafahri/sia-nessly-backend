<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilai', function (Blueprint $table) {

            // Tambah jenis nilai
            $table->enum('jenis_nilai', ['harian', 'uts', 'uas'])
                  ->after('mapel_id')
                  ->default('harian');

            // OPTIONAL (jika nilai berdasarkan kelas)
            $table->foreignId('kelas_id')
                  ->nullable()
                  ->after('mapel_id')
                  ->constrained('kelas')
                  ->onDelete('cascade');

            // Hapus unique lama
            $table->dropUnique(['siswa_id', 'mapel_id', 'semester', 'tahun_ajaran']);

            // Unique baru (bedakan jenis nilai)
            $table->unique([
                'siswa_id',
                'mapel_id',
                'kelas_id',
                'semester',
                'tahun_ajaran',
                'jenis_nilai'
            ], 'nilai_unique_full');
        });
    }

    public function down(): void
    {
        Schema::table('nilai', function (Blueprint $table) {

            $table->dropUnique('nilai_unique_full');

            $table->unique([
                'siswa_id',
                'mapel_id',
                'semester',
                'tahun_ajaran'
            ]);

            $table->dropForeign(['kelas_id']);
            $table->dropColumn(['jenis_nilai', 'kelas_id']);
        });
    }
};
