<?php

namespace App\Filament\Imports;

use App\Models\PembimbingIndustri;
use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PembimbingIndustriImporter extends Importer
{
    protected static ?string $model = PembimbingIndustri::class;

    public static function getColumns(): array
    {
        return [
            // Mengambil relasi industri berdasarkan kolom 'nama'
            // Di CSV, admin cukup mengetik nama industrinya (misal: "PT Telkom")
            ImportColumn::make('industri')
                ->relationship(resolveUsing: 'nama')
                ->requiredMapping()
                ->rules(['required']),

            ImportColumn::make('nama')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('jabatan')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('jenis_kelamin')
                ->requiredMapping()
                ->rules(['required']),

            ImportColumn::make('agama'),

            ImportColumn::make('nomor_telepon')
                ->rules(['max:255']),

            ImportColumn::make('alamat'),

            // Kolom username wajib diisi di CSV untuk membuat akun login
            ImportColumn::make('username')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?PembimbingIndustri
    {
        // Karena tidak ada NIP/NISN, kita menggunakan kombinasi nama dan id industri
        // agar tidak terjadi duplikat ganda jika di-import ulang
        if (isset($this->data['nama']) && isset($this->data['industri_id'])) {
            return PembimbingIndustri::firstOrNew([
                'nama' => $this->data['nama'],
                'industri_id' => $this->data['industri_id'],
            ]);
        }

        return new PembimbingIndustri();
    }

    protected function beforeSave(): void
    {
        // LOGIKA PENTING: Buat akun login (User) sebelum menyimpan data Pembimbing
        $user = User::firstOrCreate(
            ['username' => $this->data['username']], // Username diambil dari CSV
            [
                'name' => $this->data['nama'],
                'password' => bcrypt($this->data['username']), // Password default = username
            ]
        );

        // Hubungkan ID User ke tabel PembimbingIndustri
        $this->record->user_id = $user->id;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Import data pembimbing industri selesai dan ' . number_format($import->successful_rows) . ' baris berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal diimpor.';
        }

        return $body;
    }
}
