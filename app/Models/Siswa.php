<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\NilaiAkhir;
class Siswa extends Model
{
    use HasApiTokens, HasFactory;
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'nisn',
        'email',
        'password',
        'kelas_id',
        'alamat',
        'jenis_kelamin',
        'nomor_telepon',
        'foto_profil', // WAJIB
    ];

    protected $hidden = [
        'password',
    ];


    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }


public function absensi()
{
    return $this->hasMany(\App\Models\Absensi::class, 'siswa_id');
}

public function nilaiAkhir()
{
    return $this->hasMany(\App\Models\NilaiAkhir::class);
}


}
