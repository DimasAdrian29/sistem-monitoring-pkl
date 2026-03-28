<?php
namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Ambil data dari form
        $data = $this->form->getState();

        // Jika form password diisi, maka update password di tabel User
        if (! empty($data['password'])) {
            $this->record->user->update([
                'password' => Hash::make($data['password']),
            ]);
        }
    }
}
