<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\NamaTagihan;
use App\Models\TagihanPerSiswa;
use App\Models\Golongan;

class Tagihan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable =[
        'idNamaTagihan',
        'tanggalMulai',
        'tanggalSelesai',
        'hargaBayar',
        'idGolongan',
        'kelas'
    ];

    // public function namaTagihan(): HasMany
    // {
    //     return $this->hasMany(NamaTagihan::class,'idNamaTagihan','idNamaTagihan');
    // }

    // public function tagihanPerSiswa()
    // {
    //     return $this->hasMany(TagihanPerSiswa::class, 'idTagihan', 'idTagihan');
    // }

    public function namaTagihan()
    {
        return $this->belongsTo(NamaTagihan::class, 'idNamaTagihan');
    }

    public function tagihanPerSiswa()
    {
        return $this->hasMany(TagihanPerSiswa::class, 'idTagihan');
    }

    public function golongan()
    {
        return $this->hasOne(Golongan::class,'idGolongan','idGolongan');
    }

    protected $primaryKey = 'idTagihan';
    protected $table = 'tagihan';
}