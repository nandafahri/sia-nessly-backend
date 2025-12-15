<?php

use Illuminate\Support\Facades\Route;
// Import semua Controller Admin yang Anda miliki
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\PesanHarianController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini tempat Anda dapat mendaftarkan rute web untuk aplikasi Anda.
|
*/

// PERUBAHAN UTAMA: Mengarahkan rute root '/' langsung ke halaman login admin.
Route::get('/', function () {
    return redirect()->route('admin.login.form');
});


// --- RUTE UNTUK ADMINISTRATOR (Prefix: /admin, Name: admin.) ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/qr/panel', [AbsensiController::class, 'panel'])->name('panel');
    Route::post('/generate', [AbsensiController::class, 'generateQr'])->name('generateManual');
    // 1. Rute Otentikasi (Tidak memerlukan login)
    Route::controller(AdminAuthController::class)->group(function () {
        // Mencegah admin yang sudah login mengakses halaman ini
        Route::get('/login', 'showLoginForm')->name('login.form')->middleware('guest:admin');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
    });

    // 2. Rute Terproteksi (Hanya admin yang sudah login)
    Route::middleware('auth:admin')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Admin
        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('/profile', 'showProfile')->name('profile.show');
            Route::put('/profile/update', 'updateProfile')->name('profile.update');
            Route::put('/profile/password', 'updatePassword')->name('profile.password');
        });

        


        // =======================================================
        // MANAJEMEN SUMBER DAYA (Resources)
        // =======================================================
        
        // Manajemen Siswa (Menggunakan Controller SiswaController)
        Route::resource('siswa', SiswaController::class);
        // Manajemen Absensi (Menggunakan Controller AbsensiController)
        Route::resource('absensi', AbsensiController::class);
        
        // Manajemen Nilai (Menggunakan Controller NilaiController)
        Route::resource('nilai', NilaiController::class);

        // Manajemen Jadwal (Menggunakan Controller JadwalController)
        Route::resource('jadwal', JadwalController::class);

        // Manajemen Mata Pelajaran (Mapel) (Menggunakan Controller MapelController)
        // Diberi nama eksplisit agar lebih jelas di rute blade: admin.mapel.index, dll.
        Route::resource('mapel', MapelController::class)->names('mapel');
        Route::resource('kelas', KelasController::class)->names('kelas');
        Route::resource('guru', GuruController::class)->names('guru');
        Route::resource('notifikasi', NotifikasiController::class);
        // Jika Anda memiliki Controller untuk manajemen User umum, masukkan di sini
        // Route::resource('users', UserController::class); 
        Route::resource('pesan', \App\Http\Controllers\Admin\PesanHarianController::class);
        // WEB - Guru/Admin
    });
});