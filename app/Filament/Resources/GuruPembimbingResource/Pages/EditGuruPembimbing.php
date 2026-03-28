<?php

namespace App\Filament\Resources\GuruPembimbingResource\Pages;

use App\Filament\Resources\GuruPembimbingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditGuruPembimbing extends EditRecord
{
    protected static string $resource = GuruPembimbingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        // Jika form password diisi, maka update password di tabel User
        if (!empty($data['password'])) {
            $this->record->user->update([
                'password' => Hash::make($data['password']),
            ]);
        }
    }
}
