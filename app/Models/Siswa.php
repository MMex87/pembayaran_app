<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Kelas;
use App\Models\SiswaPerKelas;
use App\Models\Golongan;

class Siswa extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'namaSiswa',
        'tanggalLahir',
        'nik',
        'jenisKelamin',
        'noHP',
        'alamat',
        'idKelas',
        'noKIP',
        'namaWali',
        'status',
        'idGolongan'
    ];


    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'siswa_per_kelas', 'idSiswa', 'idKelas');
    }
    
    public function siswaPerKelas()
    {
        return $this->hasMany(SiswaPerKelas::class, 'idSiswa');
    }
    
    public function golongan()
    {
        return $this->belongsTo(Golongan::class,'idGolongan');
    }

    protected $primaryKey = 'idSiswa';
    public $timestamps = false;
    protected $table = 'siswa';
}