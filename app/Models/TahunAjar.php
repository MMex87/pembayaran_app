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
    ];

    public function siswaPerKelas()
    {
        return $this->hasMany(SiswaPerKelas::class, 'idTahunAjar');
    }

    protected $primaryKey = 'idTahunAjar';
    protected $table = 'tahun_ajar';
    public $timestamps = false;
}