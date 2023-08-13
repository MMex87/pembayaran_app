<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TahunAjar extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable =[
        'tahun',
        'semester',
    ];

    protected $table = 'tahun_ajar';
    public $timestamps = false;
}