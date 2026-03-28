<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'praktek_kerja_lapangan_id',
        'user_id',
        'isi_pesan',
    ];

    public function praktek_kerja_lapangan()
    {
        return $this->belongsTo(PraktekKerjaLapangan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
