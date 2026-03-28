<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industri extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama',
        'alamat',
        'nomor_telepon',
        'email',
        'deskripsi',
        'latitude',
        'longitude',
    ];
}
