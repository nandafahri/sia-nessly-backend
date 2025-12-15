<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'kelas_id',
        'qr_id',
        'jadwal_id',
        'waktu_absen',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(\App\Models\Siswa::class);
    }

    // Relasi ke Mapel
    public function mapel()
    {
        return $this->belongsTo(\App\Models\Mapel::class);
    }

    // Relasi ke Kelas
    public function kelas()
    {
        return $this->belongsTo(\App\Models\Kelas::class);
    }

    // Relasi ke QR
    public function qr()
    {
        return $this->belongsTo(\App\Models\Qr::class, 'qr_id', 'id');
    }

    // Relasi ke Jadwal (opsional)
    public function jadwal()
    {
        return $this->belongsTo(\App\Models\Jadwal::class);
    }
}
