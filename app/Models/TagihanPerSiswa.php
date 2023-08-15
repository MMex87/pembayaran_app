<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagihanPerSiswa extends Model
{
    use HasFactory;
    use SoftDeletes;


    public $fillable = [
        'noTagihan',
        'status',
        'idTagihan',
        'idSPK'
    ];
    
    protected $table='tagihan_per_siswa';
}