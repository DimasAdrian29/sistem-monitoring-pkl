<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsensiResource\Pages;
use App\Models\Absensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Utama')
                    ->schema([
                        Forms\Components\Select::make('praktek_kerja_lapangan_id')
                            ->relationship('praktek_kerja_lapangan', 'id')
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->siswa->nama . ' (di ' . $record->industri->nama . ')')
                            ->label('Data PKL Siswa')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('pembimbing_industri_id')
                            ->relationship('pembimbing_industri', 'nama')
                            ->label('Pembimbing Industri (Validator)')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('status_kehadiran')
                            ->options([
                                'Hadir' => 'Hadir',
                                'Izin'  => 'Izin',
                                'Sakit' => 'Sakit',
                                'Alpa'  => 'Alpa',
                            ])->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Waktu & Lokasi')
                    ->schema([
                        Forms\Components\TimePicker::make('jam_masuk'),
                        Forms\Components\TimePicker::make('jam_pulang'),
                        Forms\Components\TextInput::make('jarak_ke_industri')->suffix(' meter')->numeric(),
                        Forms\Components\TextInput::make('latitude'),
                        Forms\Components\TextInput::make('longitude'),
                    ])->columns(2),

                Forms\Components\Section::make('Bukti & Validasi')
                    ->schema([
                        // Penambahan Field Foto (Opsional)
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Bukti Absensi')
                            ->image() // Hanya menerima file gambar
                            ->directory('absensi-foto') // Folder penyimpanan di storage/app/public
                            ->columnSpanFull(), // Agar tampilan lebih lebar

                        Forms\Components\Select::make('status_validasi')
                            ->options([
                                'Menunggu'  => 'Menunggu',
                                'Disetujui' => 'Disetujui',
                                'Ditolak'   => 'Ditolak',
                            ])->default('Menunggu')->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('praktek_kerja_lapangan.siswa.nama')->label('Siswa')->searchable(),

                // Menampilkan Foto di Tabel
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(), // Membuat foto berbentuk lingkaran

                Tables\Columns\TextColumn::make('tanggal')->date()->sortable(),
                Tables\Columns\TextColumn::make('status_kehadiran')->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Hadir' => 'success',
                        'Izin'  => 'warning',
                        'Sakit' => 'info',
                        'Alpa'  => 'danger',
                    }),
                Tables\Columns\TextColumn::make('jam_masuk')->time(),
                Tables\Columns\TextColumn::make('jam_pulang')->time(),
                Tables\Columns\TextColumn::make('status_validasi') // Menggunakan TextColumn dengan badge() karena BadgeColumn sudah deprecated di versi terbaru
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Menunggu' => 'warning',
                        'Disetujui' => 'success',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit'   => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }
}
