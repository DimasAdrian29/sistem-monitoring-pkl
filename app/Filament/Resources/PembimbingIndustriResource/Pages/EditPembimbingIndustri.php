<?php

namespace App\Filament\Resources\PembimbingIndustriResource\Pages;

use App\Filament\Resources\PembimbingIndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditPembimbingIndustri extends EditRecord
{
    protected static string $resource = PembimbingIndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Jika admin mengetik password baru, update tabel User
        if (!empty($data['password'])) {
            $this->record->user->update([
                'password' => Hash::make($data['password']),
            ]);
        }

        // BUANG password dari array $data agar tidak memicu error kolom di tabel pembimbing_industris
        unset($data['password']);

        return $data;
    }
}
