<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\NilaiController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\NotifikasiController;
use App\Http\Controllers\Admin\PesanHarianController;
use App\Http\Controllers\Admin\QrController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\NilaiAkhirController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.login.form');
});

// --- RUTE UNTUK ADMINISTRATOR (Prefix: /admin, Name: admin.) ---
Route::prefix('admin')->name('admin.')->group(function () {

    // --- Otentikasi Admin (guest) ---
    Route::controller(AdminAuthController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login.form')->middleware('guest:admin');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');

    });

    
// Lupa password (belum login)
Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPasswordEmailForm'])->name('password.email.form');
Route::post('/forgot-password', [AdminAuthController::class, 'verifyEmail'])->name('password.email.verify');

// Reset password
Route::get('/reset-password', [AdminAuthController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('password.reset');


    // --- Rute yang memerlukan login admin ---
    Route::middleware('auth:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile Admin
        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('/profile', 'showProfile')->name('profile.show');
            Route::put('/profile/update', 'updateProfile')->name('profile.update');
            Route::put('/profile/password', 'updatePassword')->name('profile.password');
        });

        // --- QR Controller ---
        Route::post('generate-qr', [QrController::class, 'generate']);
        Route::get('qr-panel', [QrController::class, 'panel'])->name('qr.panel');
        Route::get('absensi/export', [AbsensiController::class, 'export'])->name('absensi.export');



        // =======================================================
        // Manajemen Resources
        // =======================================================
        Route::resource('siswa', SiswaController::class);
        Route::resource('nilai', NilaiController::class);
        Route::resource('jadwal', JadwalController::class);
        Route::resource('mapel', MapelController::class)->names('mapel');
        Route::resource('kelas', KelasController::class)->names('kelas');
        Route::resource('guru', GuruController::class)->names('guru');
        Route::resource('notifikasi', NotifikasiController::class);
        Route::resource('pesan', PesanHarianController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::resource('nilai-akhir', NilaiAkhirController::class);
    });

});
