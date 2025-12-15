<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    protected $table = 'qrs';

    public $timestamps = true;

    protected $fillable = [
        'mapel_id',
        'kelas_id',
        'jam_mulai',
        'jam_selesai',
        'qr_token',
        'qr_url',
        'qr_expired_at',
    ];

    protected $dates = ['qr_expired_at'];

    public function absensi()
    {
        return $this->hasMany(\App\Models\Absensi::class, 'qr_id', 'id');
    }
}
