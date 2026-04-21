<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PengajuanMagangResource\Pages;
use App\Models\PengajuanMagang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PengajuanMagangResource extends Resource
{
    protected static ?string $model = PengajuanMagang::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text'; // Bisa disesuaikan
     protected static ?string $pluralModelLabel = 'Pengajuan Magang';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Pengajuan')
                    ->schema([
                        Forms\Components\Select::make('siswa_id')
                            ->relationship('siswa', 'nama')
                            ->label('Nama Siswa')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('industri_id')
                            ->relationship('industri', 'nama')
                            ->label('Tujuan Industri')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\DatePicker::make('tgl_pengajuan')
                            ->label('Tanggal Pengajuan')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('status_pengajuan')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Diterima' => 'Diterima',
                                'Ditolak'  => 'Ditolak',
                            ])
                            ->default('Menunggu')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Dokumen Pendukung')
                    ->schema([
                        Forms\Components\FileUpload::make('cv')
                            ->label('Upload CV (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('cv-pengajuan') // Disimpan di storage/app/public/cv-pengajuan
                            ->maxSize(5120)             // Maksimal 5MB
                            ->required()
                            ->downloadable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('industri.nama')
                    ->label('Industri Tujuan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_pengajuan')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status_pengajuan')
                    ->label('Status')
                    ->colors([
                        'warning' => 'Menunggu',
                        'success' => 'Diterima',
                        'danger'  => 'Ditolak',
                    ]),
                Tables\Columns\TextColumn::make('cv')
                    ->label('Dokumen CV')
                    ->formatStateUsing(fn() => 'Lihat CV')
                    ->url(fn($record) => asset('storage/' . $record->cv))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-text'),
            ])
            ->filters([
                // Filter untuk memudahkan admin melihat berdasarkan status
                Tables\Filters\SelectFilter::make('status_pengajuan')
                    ->label('Filter Status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diterima' => 'Diterima',
                        'Ditolak'  => 'Ditolak',
                    ]),
            ])
            ->actions([
                // ACTION: Terima Pengajuan
                Tables\Actions\Action::make('terima')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Pengajuan')
                    ->modalDescription('Apakah Anda yakin ingin menerima pengajuan magang ini?')
                    ->action(fn (PengajuanMagang $record) => $record->update(['status_pengajuan' => 'Diterima']))
                    // Sembunyikan jika status sudah Diterima
                    ->hidden(fn (PengajuanMagang $record) => $record->status_pengajuan === 'Diterima'),

                // ACTION: Tolak Pengajuan
                Tables\Actions\Action::make('tolak')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pengajuan')
                    ->modalDescription('Apakah Anda yakin ingin menolak pengajuan magang ini?')
                    ->action(fn (PengajuanMagang $record) => $record->update(['status_pengajuan' => 'Ditolak']))
                    // Sembunyikan jika status sudah Diterima ATAU Ditolak
                    ->hidden(fn (PengajuanMagang $record) => in_array($record->status_pengajuan, ['Diterima', 'Ditolak'])),

                // Aksi Bawaan Filament
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
            'index'  => Pages\ListPengajuanMagangs::route('/'),
            'create' => Pages\CreatePengajuanMagang::route('/create'),
            'edit'   => Pages\EditPengajuanMagang::route('/{record}/edit'),
        ];
    }
}
