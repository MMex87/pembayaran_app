<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TagihanPerSiswa;
use App\Models\Users;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'invoice',
        'verify',
        'idTPS',
        'idUser'
    ];

    public function tagihanPerSiswa()
    {
        return $this->belongsTo(TagihanPerSiswa::class, 'idTPS');
    }
    
    public function users()
    {
        return $this->belongsTo(Users::class, 'idUser');
    }

    protected $primaryKey = 'idTransaksi';
    protected $table = 'transaksi';
}