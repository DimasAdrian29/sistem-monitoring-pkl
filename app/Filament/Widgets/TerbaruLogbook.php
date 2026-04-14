<?php

namespace App\Filament\Widgets;

use App\Models\Logbook;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TerbaruLogbook extends BaseWidget
{
    protected static ?int $sort = 3; // Muncul di bawah chart
    // Ubah dari 'full' menjadi 1:
    protected int | string | array $columnSpan = 1;
    protected static ?string $heading = 'Logbook Siswa Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Logbook::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('praktekKerjaLapangan.siswa.nama')
                    ->label('Nama Siswa'),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kegiatan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('status_validasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Disetujui' => 'success',
                        'Menunggu' => 'warning',
                        'Ditolak' => 'danger',
                    }),
            ]);
    }
}
