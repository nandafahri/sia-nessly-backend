<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->unsignedBigInteger('mapel_id')->after('siswa_id');

            $table->foreign('mapel_id')
                ->references('id')
                ->on('mapels')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['mapel_id']);
            $table->dropColumn('mapel_id');
        });
    }

};
