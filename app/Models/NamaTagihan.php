<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Tagihan;

class NamaTagihan extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'namaTagihan'
    ];

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'idNamaTagihan');
    }

    protected $primaryKey = 'idNamaTagihan';
    protected $table = "nama_tagihan";
}