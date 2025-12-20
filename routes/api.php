<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaAuthController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Controllers\Api\NotifikasiController;
use App\Http\Controllers\Api\PesanHarianController;
use App\Http\Controllers\Api\AbsenApiController;
use App\Http\Controllers\Api\StatusAbsensiController;



Route::post('/login-siswa', [SiswaAuthController::class, 'login']);
Route::post('/register-siswa', [SiswaAuthController::class, 'register']);
Route::get('/jadwal', [JadwalController::class, 'index']);
Route::get('/nilai', [NilaiController::class, 'index']);
Route::post('/siswa/change-password', [SiswaAuthController::class, 'changePassword']);
Route::post('/siswa/verify', [SiswaAuthController::class, 'verifyAccount']);
Route::put('/siswa/update-email', [SiswaAuthController::class, 'updateEmail']);
Route::get('/notifikasi', [NotifikasiController::class, 'index']);
Route::get('/pesan-hari-ini', [PesanHarianController::class, 'apiGetLatest']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/absen/{qrToken}', [AbsenApiController::class, 'absen']);
    Route::get('/absensi/{nisn}', [AbsenApiController::class, 'getAbsensi']);
    Route::get('/status/jumlah-jadwal/{nisn}', [StatusAbsensiController::class, 'jumlahJadwalHariIni']);
    Route::get('/status/jumlah-absensi/{nisn}', [StatusAbsensiController::class, 'jumlahAbsensiHariIni']);

});