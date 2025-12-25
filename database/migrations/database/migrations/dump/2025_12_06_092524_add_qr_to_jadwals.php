<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQrToJadwals extends Migration
{
    public function up()
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->string('qr_token')->nullable()->after('id');
            $table->dateTime('qr_expired_at')->nullable()->after('qr_token');
            $table->string('qr_url')->nullable()->after('qr_expired_at'); // optional store full url
        });
    }

    public function down()
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropColumn(['qr_token','qr_expired_at','qr_url']);
        });
    }
}
