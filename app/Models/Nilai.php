<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'jenis_nilai',
        'nilai_angka',
        'nilai_huruf',
        'semester',
        'tahun_ajaran',
        'keterangan',
    ];

    /**
     * Relasi: Nilai dimiliki oleh Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Relasi: Nilai dimiliki oleh Mata Pelajaran
     */
    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}