<?php

namespace App\Filament\Imports;

use App\Models\Siswa;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiswaImporter extends Importer
{
    protected static ?string $model = Siswa::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('nisn')
                ->label('NISN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('jenis_kelamin')
                ->rules(['nullable', 'in:Laki-laki,Perempuan']),

            ImportColumn::make('agama')
                ->rules(['nullable', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu']),

            ImportColumn::make('kelas')
                ->requiredMapping()
                ->rules(['required', 'in:XI,XII,XIII']),

            ImportColumn::make('jurusan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('nomor_telepon')
                ->rules(['nullable', 'max:20']),

            ImportColumn::make('nomor_telepon_wali')
                ->rules(['nullable', 'max:20']),

            ImportColumn::make('alamat')
                ->rules(['nullable']),
        ];
    }

    public function resolveRecord(): ?Siswa
    {
        return Siswa::firstOrNew([
            'nisn' => $this->data['nisn'],
        ]);
    }

    protected function beforeSave(): void
    {
        $nisn = $this->data['nisn'];

        // Buat atau ambil User yang sudah ada berdasarkan username (NISN)
        $user = User::firstOrCreate(
            [
                'username' => $nisn,
            ],
            [
                'password' => bcrypt($nisn), // Password default = NISN
                'role'     => 'siswa',       // ← role wajib diisi
                'gmail'    => null,          // ← nullable, aman dikosongkan
            ]
        );

        $this->record->user_id = $user->id;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data siswa selesai dan '
            . number_format($import->successful_rows)
            . ' baris berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diimpor.';
        }

        return $body;
    }
}
