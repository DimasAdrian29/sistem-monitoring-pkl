<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama', 'nisn', 'jenis_kelamin', 'agama',
        'alamat', 'kelas', 'jurusan', 'nomor_telepon', 'nomor_telepon_wali'
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
