<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'praktek_kerja_lapangan_id',
        'tanggal',
        'kegiatan',
        'foto',
        'status_validasi',
    ];

    // Relasi balik ke tabel PKL
    public function praktek_kerja_lapangan()
    {
        return $this->belongsTo(PraktekKerjaLapangan::class);
    }
}
