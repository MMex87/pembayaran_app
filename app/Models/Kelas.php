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
        return $this->belongsToMany(Siswa::class, 'siswa_per_kelas', 'idKelas', 'idSiswa');
    }

    protected $primaryKey = 'idKelas';
    public $timestamps = false;
}