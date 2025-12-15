<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->enum('tingkat', ['10', '11', '12']);
            $table->string('jurusan')->nullable();
            $table->string('nama_kelas');

            // Relasi wali kelas -> guru
            $table->unsignedBigInteger('wali_kelas_id')->nullable();
            $table->foreign('wali_kelas_id')
                  ->references('id')
                  ->on('gurus')
                  ->onDelete('set null'); // jika guru dihapus, wali kelas menjadi null

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
