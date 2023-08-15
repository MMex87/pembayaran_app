<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\NamaTagihan;

class Tagihan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable =[
        'idNamaTagihan',
        'tanggalMulai',
        'tanggalSelesai',
        'status',
        'kelas'
    ];

    public function namaTagihan(): HasMany
    {
        return $this->hasMany(NamaTagihan::class,'idNamaTagihan','idNamaTagihan');
    }

    protected $table = 'tagihan';
}