<?php
namespace App\Filament\Resources\GuruPembimbingResource\Pages;

use App\Filament\Resources\GuruPembimbingResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateGuruPembimbing extends CreateRecord
{
    protected static string $resource = GuruPembimbingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Buat user otomatis menggunakan NIP sebagai username & password
        $user = User::create([
            'username' => $data['nip'],
            'password' => Hash::make($data['nip']),   // Password default = NIP
            'gmail'    => $data['nama'] . '@guru.com', // Memastikan unik
            'role'     => 'guru_pembimbing',
        ]);

        // 2. Sambungkan ID User ke data Guru Pembimbing
        $data['user_id'] = $user->id;

        return $data;
    }
}
