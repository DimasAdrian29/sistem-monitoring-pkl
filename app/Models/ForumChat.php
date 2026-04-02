<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'industri_id', // Menggunakan ID Industri sebagai ruang grup
        'user_id',
        'isi_pesan',
    ];

    // Relasi ke tabel Industri (Grup)
    public function industri()
    {
        return $this->belongsTo(Industri::class);
    }

    // Relasi ke pengirim pesan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
