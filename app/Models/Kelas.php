<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'namaKelas',
        'waliKelas',
        'emailWaliKelas'
    ];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_per_kelas', 'kelas_id', 'siswa_id');
    }

    public $timestamps = false;
}