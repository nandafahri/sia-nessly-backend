<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('qr_id');
            $table->unsignedBigInteger('jadwal_id')->nullable(); // ambil dari QR, opsional
            $table->timestamp('waktu_absen');
            $table->string('status')->default('Hadir');
            $table->string('keterangan')->default('-');
            $table->timestamps();

            // Foreign keys
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('qr_id')->references('id')->on('qrs')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
