<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPembimbing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nama', 'nip', 'jenis_kelamin',
        'agama', 'alamat', 'jurusan', 'nomor_telepon'
    ];

    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
