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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                            ->directory('cv-pengajuan') // Folder penyimpanan di storage/app/public/cv-pengajuan
                            ->maxSize(5120)             // Maksimal 5MB
                            ->required()
                            ->downloadable(), // Tombol untuk download langsung dari admin
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
            'index'  => Pages\ListPengajuanMagangs::route('/'),
            'create' => Pages\CreatePengajuanMagang::route('/create'),
            'edit'   => Pages\EditPengajuanMagang::route('/{record}/edit'),
        ];
    }
}
