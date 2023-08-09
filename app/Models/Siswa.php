<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'namaSiswa',
            'tanggalLahir' ,
            'nik',
            'jenisKelamin',
            'noHP',
            'alamat',
            'idKelas',
            'noKIP',
            'namaWali',
            'status'
    ];

    public $timestamps = false;
    protected $table = 'siswa';
}