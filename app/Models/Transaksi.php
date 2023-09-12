<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TagihanPerSiswa;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'invoice',
        'verify',
        'idTPS'
    ];

    public function tagihanPerSiswa()
    {
        return $this->belongsTo(TagihanPerSiswa::class, 'idTPS');
    }

    protected $primaryKey = 'idTransaksi';
    protected $table = 'transaksi';
}