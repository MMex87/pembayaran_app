<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaksi;

class Users extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'nama',
        'jabatan'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'idUser');
    }

    protected $primaryKey = 'idUser';
    protected $table = 'users';
    public $timestamps = false;
}