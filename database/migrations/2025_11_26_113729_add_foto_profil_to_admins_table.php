<?php

// database/migrations/xxxx_add_foto_profil_to_admins_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            // Tambahkan kolom string untuk menyimpan nama file foto
            $table->string('foto_profil')->nullable()->after('email'); 
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('foto_profil');
        });
    }
};