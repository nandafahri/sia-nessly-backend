<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mapel;

class Mapel extends Model
{
    use HasFactory;

    // WAJIB: Definisikan nama tabel secara eksplisit
    protected $table = 'mapels'; 
    
    protected $fillable = ['nama'];
    
    // Definisikan relasi ke Guru (jika ada)
public function guru()
{
    return $this->belongsTo(Guru::class, 'id'); 
}

public function nilaiAkhir()
{
    return $this->hasMany(\App\Models\NilaiAkhir::class);
}


}