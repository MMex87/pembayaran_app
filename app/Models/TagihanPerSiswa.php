<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tagihan;
use App\Models\SiswaPerKelas;
use App\Models\Transaksi;
use App\Models\TahunAjar;

class TagihanPerSiswa extends Model
{
    use HasFactory;
    use SoftDeletes;


    public $fillable = [
        'noTagihan',
        'status',
        'idTagihan',
        'idSPK',
        'idTahunAjar'
    ];

    public function siswaPerKelas()
    {
        return $this->belongsTo(SiswaPerKelas::class,'idSPK');
    }

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'idTagihan');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'idTPS');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'idTahunAjar','idTahunAjar');
    }


    protected $primaryKey = 'idTPS';
    protected $table='tagihan_per_siswa';
}