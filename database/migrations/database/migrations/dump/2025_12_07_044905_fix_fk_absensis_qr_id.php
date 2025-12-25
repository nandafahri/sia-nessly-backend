<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['qr_id']);

            // Tambahkan foreign key baru tanpa cascade
            $table->foreign('qr_id')
                ->references('id')
                ->on('qrs')
                ->nullOnDelete(); // ⬅️ solusi aman
        });
    }

    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['qr_id']);

            $table->foreign('qr_id')
                ->references('id')
                ->on('qrs')
                ->onDelete('cascade'); // balik asalnya jika rollback
        });
    }

};
