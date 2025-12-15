<?php

return [

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    // TAMBAHKAN GUARD ADMIN DI SINI
    'admin' => [ 
        'driver' => 'session',
        'provider' => 'admins', // Merujuk ke provider 'admins' di bawah
    ],
        'api' => [
                    'driver' => 'sanctum',
                    'provider' => 'siswa', // <--- MASALAH!
                ],

        'siswa' => [ // Nama guard yang digunakan di route: auth:siswa
            'driver' => 'sanctum',
            'provider' => 'siswa',
        ],
],

// ... (sekitar baris 60)
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    // TAMBAHKAN PROVIDER ADMIN DI SINI
    'admins' => [ 
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class, // Menggunakan model Admin
    ],
            'siswa' => [
            'driver' => 'eloquent',
            'model' => App\Models\Siswa::class,
        ],
],

// ... (sekitar baris 80)
'passwords' => [
    'users' => [
        'provider' => 'users',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
    // TAMBAHKAN PENGATURAN PASSWORD RESET ADMIN JIKA PERLU
    'admins' => [
        'provider' => 'admins',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
            'siswa' => [
            'provider' => 'siswa',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
