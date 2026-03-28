<?php
namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateSiswa extends CreateRecord
{
    protected static string $resource = SiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Buat user otomatis menggunakan NISN/NIK sebagai username & password
        $user = User::create([
            'username' => $data['nisn'],
            'password' => Hash::make($data['nisn']),    // Password default = NISN
            'gmail'    => $data['nama'] . '@siswa.com', // Kolom gmail wajib diisi & unik
            'role'     => 'siswa',
        ]);

        // 2. Sambungkan ID User yang baru dibuat ke data Siswa
        $data['user_id'] = $user->id;

        return $data;
    }
}
