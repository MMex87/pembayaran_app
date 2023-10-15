<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SiswaPerKelas;
use App\Models\Siswa;
use App\Models\TahunAjar;

class Kelas extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'namaKelas',
        'waliKelas',
        'emailWaliKelas',
        'idTahunAjar'
    ];

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_per_kelas', 'idKelas', 'idSiswa');
    }

    public function siswaPerKelas()
    {
        return $this->hasMany(SiswaPerKelas::class, 'idKelas', 'idKelas');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'idTahunAjar','idTahunAjar');
    }


    protected $primaryKey = 'idKelas';
    public $timestamps = false;
}