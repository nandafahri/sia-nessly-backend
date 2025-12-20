<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siswa;
use App\Models\Mapel;



class NilaiAkhir extends Model
{
    protected $table = 'nilai_akhir';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'semester',
        'tahun_ajaran',
        'nilai_harian',
        'nilai_uts',
        'nilai_uas',
        'nilai_akhir',
        'nilai_huruf',
    ];

    public function siswa()
{
    return $this->belongsTo(\App\Models\Siswa::class);
}

public function mapel()
{
    return $this->belongsTo(\App\Models\Mapel::class);
}

}


