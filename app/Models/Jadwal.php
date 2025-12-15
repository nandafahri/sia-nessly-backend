<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwals';

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'guru_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'qr_token',
        'qr_url',
        'qr_expired_at'
    ];

    // FIX: Casting agar format() tidak error
    protected $casts = [
        'qr_expired_at' => 'datetime',
        'jam_mulai'     => 'datetime:H:i',
        'jam_selesai'   => 'datetime:H:i',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function isQrActive()
    {
        return $this->qr_token !== null &&
               $this->qr_expired_at !== null &&
               now()->lt($this->qr_expired_at);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
