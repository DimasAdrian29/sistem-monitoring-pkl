<?php

namespace App\Filament\Resources\PembimbingIndustriResource\Pages;

use App\Filament\Resources\PembimbingIndustriResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreatePembimbingIndustri extends CreateRecord
{
    protected static string $resource = PembimbingIndustriResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Buat User baru dari $data bawaan form
        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'gmail'    => $data['username'] . '@industri.com',
            'role'     => 'pembimbing_industri',
        ]);

        // 2. Sambungkan ID User ke data Pembimbing Industri
        $data['user_id'] = $user->id;

        // 3. BUANG username & password dari array $data agar Filament tidak menyimpannya ke tabel pembimbing_industris
        unset($data['username']);
        unset($data['password']);

        return $data;
    }
}
