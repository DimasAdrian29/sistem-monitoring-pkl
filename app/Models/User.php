<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\FilamentUser; // 1. TAMBAHKAN IMPORT INI
use Filament\Panel;                         // 2. TAMBAHKAN IMPORT INI
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 3. TAMBAHKAN 'implements FilamentUser'
class User extends Authenticatable implements HasName, FilamentUser
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
            'password' => 'hashed',
        ];
    }

    public function getFilamentName(): string
    {
        return (string) $this->username;
    }

    // 4. TAMBAHKAN FUNGSI INI UNTUK MEMBATASI AKSES PANEL FILAMENT
    public function canAccessPanel(Panel $panel): bool
    {
        // Hanya user dengan role 'admin' yang bisa mengakses Filament Panel
        return true;
    }
}
