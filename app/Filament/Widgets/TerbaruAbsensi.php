<?php

namespace App\Filament\Widgets;

use App\Models\Absensi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TerbaruAbsensi extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 1;
    protected static ?string $heading = 'Absensi Siswa Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Absensi::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('praktekKerjaLapangan.siswa.nama')
                    ->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('status_kehadiran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Hadir' => 'success',
                        'Izin' => 'warning',
                        'Sakit' => 'info',
                        'Alpa' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('jam_masuk')
                    ->time(),
                Tables\Columns\TextColumn::make('jarak_ke_industri')
                    ->label('Jarak')
                    ->suffix(' km'),
                Tables\Columns\TextColumn::make('status_validasi')
                    ->label('Validasi')
                    ->icon(fn (string $state): string => match ($state) {
                        'Disetujui' => 'heroicon-m-check-circle',
                        'Menunggu' => 'heroicon-m-clock',
                        'Ditolak' => 'heroicon-m-x-circle',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Disetujui' => 'success',
                        'Menunggu' => 'warning',
                        'Ditolak' => 'danger',
                    }),
            ]);
    }
}
