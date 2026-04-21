<?php

namespace App\Filament\Imports;

use App\Models\Siswa;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class SiswaImporter extends Importer
{
    protected static ?string $model = Siswa::class;

    public static function getColumns(): array
    {
        // Kolom-kolom ini yang akan otomatis menjadi Template CSV untuk diunduh
        return [
            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nisn')
                ->label('NISN')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('jenis_kelamin')
                ->requiredMapping()
                ->rules(['nullable']),
            ImportColumn::make('agama'),
            ImportColumn::make('kelas')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('jurusan')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('nomor_telepon'),
            ImportColumn::make('nomor_telepon_wali'),
            ImportColumn::make('alamat'),
        ];
    }

    public function resolveRecord(): ?Siswa
    {
        // Cari siswa berdasarkan NISN.
        // Jika sudah ada, data akan di-update. Jika belum, akan dibuat baru.
        return Siswa::firstOrNew([
            'nisn' => $this->data['nisn'],
        ]);
    }

    protected function beforeSave(): void
    {
        // LOGIKA PENTING: Buat akun login (User) sebelum menyimpan data Siswa
        $user = User::firstOrCreate(
            ['username' => $this->data['nisn']], // Cari user berdasarkan username (NISN)
            [
                'name' => $this->data['nama'],
                'password' => bcrypt($this->data['nisn']), // Password default disamakan dengan NISN
            ]
        );

        // Hubungkan ID User yang baru dibuat ke kolom user_id di tabel Siswa
        $this->record->user_id = $user->id;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data siswa selesai dan ' . number_format($import->successful_rows) . ' baris berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diimpor.';
        }

        return $body;
    }
}
