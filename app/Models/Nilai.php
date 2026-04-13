<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    // Memperbarui kolom yang diizinkan untuk diisi secara massal (mass assignment)
    protected $fillable = [
        'praktek_kerja_lapangan_id',
        'pembimbing_industri_id',
        'guru_pembimbing_id', // Tambahan kolom baru
        'aspek_soft_skills',
        'aspek_norma_k3lh',
        'aspek_kompetensi_teknis',
        'aspek_wawasan_bisnis',
        'aspek_penyusunan_laporan',
        'aspek_presentasi',
        'catatan_pembimbing_industri',
        'catatan_guru_pembimbing',
    ];

    public function praktek_kerja_lapangan()
    {
        return $this->belongsTo(PraktekKerjaLapangan::class);
    }

    public function pembimbing_industri()
    {
        return $this->belongsTo(PembimbingIndustri::class);
    }

    // Tambahan fungsi relasi ke Guru Pembimbing
    public function guru_pembimbing()
    {
        return $this->belongsTo(GuruPembimbing::class);
    }
}
