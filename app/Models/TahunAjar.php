<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SiswaPerKelas;

class TahunAjar extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable =[
        'tahun',
        'semester',
        'aktif'
    ];

    public function siswaPerKelas()
    {
        return $this->hasOne(SiswaPerKelas::class, 'idTahunAjar','idTahunAjar');
    }

    public function tagihanPerSiswa()
    {
        return $this->hasOne(SiswaPerKelas::class, 'idTahunAjar','idTahunAjar');
    }

    public function kelas()
    {
        return $this->hasOne(SiswaPerKelas::class, 'idTahunAjar','idTahunAjar');
    }

    protected $primaryKey = 'idTahunAjar';
    protected $table = 'tahun_ajar';
    public $timestamps = false;
}