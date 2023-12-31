<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TagihanPerSiswa;
use App\Models\TahunAjar;

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
        return $this->belongsTo(Kelas::class, 'idKelas','idKelas');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'idTahunAjar','idTahunAjar');
    }

    public function tagihanPerSiswa()
    {
        return $this->hasMany(TagihanPerSiswa::class, 'idSPK');
    }

    protected $primaryKey = 'idSPK';
    public $timestamps = false;
}