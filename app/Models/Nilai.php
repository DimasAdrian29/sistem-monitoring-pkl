<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'praktek_kerja_lapangan_id',
        'pembimbing_industri_id',
        'disiplin',
        'tanggung_jawab',
        'kompetensi_teknis',
        'nilai_akhir',
        'catatan_pembimbing',
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
