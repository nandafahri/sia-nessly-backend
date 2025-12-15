<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/2025_11_27_133549_create_nilai_table.php

public function up(): void
{
    Schema::create('nilai', function (Blueprint $table) {
        $table->id();

        // Relasi ke Siswa (Hanya definisikan sekali)
        $table->foreignId('siswa_id')->constrained('siswa')->onDelete('cascade');
        
        // Relasi ke Mata Pelajaran (Hanya definisikan sekali)
        $table->foreignId('mapel_id')->constrained('mapel')->onDelete('cascade'); // PASTIKAN HANYA ADA BARIS INI
        
        // Data Nilai
        $table->integer('nilai_angka')->comment('Nilai dalam bentuk angka (0-100)');
        $table->string('nilai_huruf', 5)->comment('Nilai dalam bentuk huruf (A, B, C, D)');
        $table->enum('semester', ['Ganjil', 'Genap']);
        $table->string('tahun_ajaran', 10); 
        $table->text('keterangan')->nullable();

        $table->timestamps();

        // Constraint UNIK: 
        $table->unique(['siswa_id', 'mapel_id', 'semester', 'tahun_ajaran']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};