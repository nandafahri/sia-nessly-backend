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
    Schema::table('mapels', function (Blueprint $table) {
        $table->unsignedBigInteger('guru_id')->nullable()->after('nama');
        $table->foreign('guru_id')->references('id')->on('guru')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('mapels', function (Blueprint $table) {
        $table->dropForeign(['guru_id']);
        $table->dropColumn('guru_id');
    });
}

};
