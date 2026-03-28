<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 1. TAMBAHKAN 'implements HasName' DI SINI
class User extends Authenticatable implements HasName
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'gmail',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            // 2. HAPUS 'email_verified_at' KARENA KOLOMNYA SUDAH TIDAK ADA
            'password' => 'hashed',
        ];
    }

    // 3. FUNGSI INI SEKARANG AKAN TERBACA OLEH FILAMENT
    public function getFilamentName(): string
    {
        return (string) $this->username;
    }
}
