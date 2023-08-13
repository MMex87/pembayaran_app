<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaPerKelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable =[
        'idSiswa',
        'idTahunAjar',
        'idKelas'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class,'idSiswa','idSiswa');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'idKelas','idkelas');
    }

    // public function siswa()
    // {
    //     return $this->belongsTo(Siswa::class, 'idSiswa','idSiswa');
    // }

    // public function kelas()
    // {
    //     return $this->belongsTo(Kelas::class, 'idKelas','idkelas');
    // }

    public $timestamps = false;
}