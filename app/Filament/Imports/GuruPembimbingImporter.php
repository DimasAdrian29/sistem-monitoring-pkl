<?php

namespace App\Filament\Imports;

use App\Models\GuruPembimbing;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class GuruPembimbingImporter extends Importer
{
    protected static ?string $model = GuruPembimbing::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nip')
                ->label('NIP')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('jenis_kelamin')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('agama'),
            ImportColumn::make('jurusan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nomor_telepon')
                ->rules(['max:255']),
            ImportColumn::make('alamat'),
        ];
    }

    public function resolveRecord(): ?GuruPembimbing
    {
        // Mencari guru berdasarkan NIP, update jika sudah ada, buat baru jika belum.
        return GuruPembimbing::firstOrNew([
            'nip' => $this->data['nip'],
        ]);
    }

    protected function beforeSave(): void
    {
        // LOGIKA PENTING: Buat akun login (User) sebelum menyimpan data Guru
        $user = User::firstOrCreate(
            ['username' => $this->data['nip']], // Username menggunakan NIP
            [
                'name' => $this->data['nama'],
                'password' => bcrypt($this->data['nip']), // Password default disamakan dengan NIP
            ]
        );

        // Hubungkan ID User yang baru dibuat ke kolom user_id di tabel GuruPembimbing
        $this->record->user_id = $user->id;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data guru pembimbing selesai dan ' . number_format($import->successful_rows) . ' baris berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diimpor.';
        }

        return $body;
    }
}
