<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi (membuat tabel).
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id(); // Kunci utama (Primary Key)
            $table->string('nama', 150);
            $table->string('nisn', 20)->unique()->nullable(); // Nomor Induk Siswa Nasional, harus unik
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('kelas', 50); // Misalnya: X-IPA 1, XI-IPS 3, dll.
            $table->text('alamat')->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            
            // Kolom waktu standar (created_at dan updated_at)
            $table->timestamps(); 
        });
    }

    /**
     * Batalkan migrasi (menghapus tabel).
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};