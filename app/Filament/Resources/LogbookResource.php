<?php
namespace App\Filament\Resources;

use App\Filament\Resources\LogbookResource\Pages;
use App\Models\Logbook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LogbookResource extends Resource
{
    protected static ?string $model = Logbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
     protected static ?string $pluralModelLabel = 'Data Logbook';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kegiatan')
                    ->schema([
                        Forms\Components\Select::make('praktek_kerja_lapangan_id')
                            ->relationship('praktek_kerja_lapangan', 'id')
                        // Menampilkan Nama Siswa dan Industri di dropdown, bukan angka ID
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->siswa->nama . ' (di ' . $record->industri->nama . ')')
                            ->label('Pilih Data PKL Siswa')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\DatePicker::make('tanggal')
                            ->default(now())
                            ->required(),

                        Forms\Components\Select::make('status_validasi')
                            ->options([
                                'Menunggu'  => 'Menunggu Validasi',
                                'Disetujui' => 'Disetujui',
                                'Ditolak'   => 'Ditolak',
                            ])
                            ->default('Menunggu')
                            ->required(),

                        Forms\Components\Textarea::make('kegiatan')
                            ->label('Deskripsi Kegiatan')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Dokumentasi')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->label('Foto Kegiatan (Opsional)')
                            ->image()
                            ->directory('foto-logbook') // Tersimpan di storage/app/public/foto-logbook
                            ->maxSize(2048)             // Maksimal 2MB
                            ->imageEditor(),            // Fitur crop/edit gambar bawaan Filament
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('praktek_kerja_lapangan.siswa.nama')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kegiatan')
                    ->limit(30) // Membatasi teks yang panjang agar tabel rapi
                    ->searchable(),
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular(),
                Tables\Columns\BadgeColumn::make('status_validasi')
                    ->colors([
                        'warning' => 'Menunggu',
                        'success' => 'Disetujui',
                        'danger'  => 'Ditolak',
                    ]),
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
            'index'  => Pages\ListLogbooks::route('/'),
            'create' => Pages\CreateLogbook::route('/create'),
            'edit'   => Pages\EditLogbook::route('/{record}/edit'),
        ];
    }
}
