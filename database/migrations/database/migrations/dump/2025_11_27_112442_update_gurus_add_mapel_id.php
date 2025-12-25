<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            // Hapus kolom mapel lama
            if (Schema::hasColumn('gurus', 'mapel')) {
                $table->dropColumn('mapel');
            }

            // Tambahkan foreign key mapel_id
            $table->unsignedBigInteger('mapel_id')->nullable()->after('nama');
            $table->foreign('mapel_id')->references('id')->on('mapel')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            // Kembalikan struktur semula
            $table->string('mapel')->nullable();
            $table->dropForeign(['mapel_id']);
            $table->dropColumn('mapel_id');
        });
    }
};
