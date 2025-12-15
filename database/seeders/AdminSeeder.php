<?php
// database/seeders/AdminSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Import model Admin yang sudah kita buat
use Illuminate\Support\Facades\Hash; // Import facade Hash

class AdminSeeder extends Seeder
{
    /**
     * Jalankan seed database.
     */
    public function run(): void
    {
        // Membuat Akun Admin Pertama
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com', // Ganti dengan email yang Anda inginkan
            'password' => Hash::make('password'), // Ganti 'password' dengan kata sandi yang kuat
            'email_verified_at' => now(),
        ]);

        // Opsional: Tampilkan pesan di terminal
        $this->command->info('Akun Admin berhasil ditambahkan.');
    }
}