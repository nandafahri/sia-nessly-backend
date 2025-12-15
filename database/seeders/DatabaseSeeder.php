<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed database aplikasi.
     */
    public function run(): void
    {
        $this->call([
            // Panggil AdminSeeder di sini
            AdminSeeder::class, 
            // Tambahkan seeder lain di masa depan jika diperlukan (misalnya: UserSeeder::class)
        ]);
    }
}