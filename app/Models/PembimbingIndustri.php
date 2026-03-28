<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembimbingIndustri extends Model
{
    use HasFactory;

    protected $fillable = [
        'industri_id', 'user_id', 'nama', 'jabatan',
        'jenis_kelamin', 'agama', 'alamat', 'nomor_telepon'
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Industri
    // Relasi ke tabel Industri
    public function industri()
    {
        // Cukup panggil class-nya saja, Laravel akan otomatis mencari foreign key 'industri_id' dan primary key 'id'
        return $this->belongsTo(Industri::class);
    }
}
