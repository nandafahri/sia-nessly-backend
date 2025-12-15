<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id(); // digunakan sebagai wali_kelas_id di tabel kelas
            $table->string('nip')->unique();
            $table->string('nama');
            $table->string('mapel')->nullable();
            $table->string('telepon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
