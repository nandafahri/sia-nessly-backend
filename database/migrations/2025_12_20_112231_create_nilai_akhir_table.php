<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nilai_akhir', function (Blueprint $table) {
            $table->id();

            // Relasi utama
            $table->foreignId('siswa_id')
                  ->constrained('siswa')
                  ->cascadeOnDelete();

            $table->foreignId('mapel_id')
                  ->constrained('mapel')
                  ->cascadeOnDelete();

            // Konteks nilai
            $table->enum('semester', ['Ganjil', 'Genap']);
            $table->string('tahun_ajaran', 15);

            // Nilai per komponen
            $table->decimal('nilai_harian', 5, 2);
            $table->decimal('nilai_uts', 5, 2);
            $table->decimal('nilai_uas', 5, 2);

            // Nilai akhir
            $table->decimal('nilai_akhir', 5, 2);
            $table->string('nilai_huruf', 2);

            // Anti duplikasi
            $table->unique([
                'siswa_id',
                'mapel_id',
                'semester',
                'tahun_ajaran'
            ], 'nilai_akhir_unique');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_akhir');
    }
};
