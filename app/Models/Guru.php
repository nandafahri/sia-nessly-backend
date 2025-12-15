<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'gurus';
    protected $fillable = ['nip', 'nama', 'telepon'];

    // Relasi ke mapel yang dia ajar
public function mapels()
{
    return $this->hasMany(Mapel::class, 'guru_id');
}

}
