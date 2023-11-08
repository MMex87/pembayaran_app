<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Siswa;

class Golongan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'namaGolongan'
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class,'idGolongan');
    }

    public $timestamps = false;
    protected $table = 'golongan';
    protected $primaryKey = 'idGolongan';

}