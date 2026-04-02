<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PraktekKerjaLapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'industri_id',
        'guru_pembimbing_id',
        'pembimbing_industri_id',
        'tgl_mulai',
        'tgl_selesai',
        'status_magang',
    ];

    // Relasi ke Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke Industri
    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    // Relasi ke Guru Pembimbing
    public function guru_pembimbing()
    {
        return $this->belongsTo(GuruPembimbing::class);
    }

    // Relasi ke Pembimbing Industri
    public function pembimbing_industri()
    {
        return $this->belongsTo(PembimbingIndustri::class);
    }

    // Relasi ke Absensi (Tambahan baru untuk memperbaiki error)
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
    // app/Models/PraktekKerjaLapangan.php
    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }
}
