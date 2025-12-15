<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Kelas extends Model
{
    protected $fillable = [
        'tingkat',
        'jurusan',
        'nama_kelas',
        'wali_kelas_id',
    ];

    // Relasi ke guru (wali kelas)
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

        public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
