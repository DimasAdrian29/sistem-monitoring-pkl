<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $fillable = [
        'praktek_kerja_lapangan_id',
        'url_sertifikat',
        'dicetak_pada',
    ];

    protected $casts = [
        'dicetak_pada' => 'datetime',
    ];

    // Relasi ke PKL
    public function pkl()
    {
        return $this->belongsTo(PraktekKerjaLapangan::class, 'praktek_kerja_lapangan_id');
    }
}
