<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'praktek_kerja_lapangan_id',
        'pembimbing_industri_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status_kehadiran',
        'foto',
        'jarak_ke_industri',
        'latitude',
        'longitude',
        'status_validasi',
    ];

    public function praktek_kerja_lapangan()
    {
        return $this->belongsTo(PraktekKerjaLapangan::class);
    }

    public function pembimbing_industri()
    {
        return $this->belongsTo(PembimbingIndustri::class);
    }
}
