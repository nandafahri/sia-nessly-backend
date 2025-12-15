<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanHarian extends Model
{
    use HasFactory;

    protected $table = 'pesan_harians';

    protected $fillable = [
        'judul',
        'pesan'
    ];
}
