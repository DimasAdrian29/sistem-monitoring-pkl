<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PraktekKerjaLapanganResource\Pages;
use App\Models\PengajuanMagang;
use App\Models\PraktekKerjaLapangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PraktekKerjaLapanganResource extends Resource
{
    protected static ?string $model = PraktekKerjaLapangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Peserta & Tempat Magang')
                    ->schema([
                        Forms\Components\Select::make('siswa_id')
                            ->label('Nama Siswa')
                            ->relationship(
                                name: 'siswa',
                                titleAttribute: 'nama',
                                modifyQueryUsing: fn(Builder $query) => $query->whereIn('id', PengajuanMagang::where('status_pengajuan', 'Diterima')->select('siswa_id'))
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nama} - {$record->kelas} - {$record->jurusan}")
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if ($state) {
                                    $pengajuan = PengajuanMagang::where('siswa_id', $state)
                                        ->where('status_pengajuan', 'Diterima')
                                        ->first();

                                    if ($pengajuan) {
                                        $set('industri_id', $pengajuan->industri_id);
                                        $set('pembimbing_industri_id', null);
                                    }
                                } else {
                                    $set('industri_id', null);
                                    $set('pembimbing_industri_id', null);
                                }
                            })
                            ->required(),

                        Forms\Components\Select::make('industri_id')
                            ->relationship('industri', 'nama')
                            ->label('Tempat Industri')
                            ->searchable()
                            ->preload()
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pembimbing')
                    ->schema([
                        // PERUBAHAN GURU PEMBIMBING ADA DI SINI
                        Forms\Components\Select::make('guru_pembimbing_id')
                            ->label('Guru Pembimbing (Sekolah)')
                            ->relationship(
                                name: 'guru_pembimbing',
                                titleAttribute: 'nama'
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nama} - {$record->jurusan}")
                            ->searchable(['nama', 'jurusan'])
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('pembimbing_industri_id')
                            ->label('Pembimbing Industri (Lapangan)')
                            ->relationship(
                                name: 'pembimbing_industri',
                                titleAttribute: 'nama',
                                modifyQueryUsing: function (Builder $query, Get $get) {
                                    $query->with('industri');
                                    $industriId = $get('industri_id');

                                    if ($industriId) {
                                        $query->where('industri_id', $industriId);
                                    } else {
                                        $query->whereNull('id');
                                    }
                                }
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nama} - " . ($record->industri->nama ?? 'Tidak Ada Industri'))
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Waktu & Status Pelaksanaan')
                    ->schema([
                        Forms\Components\DatePicker::make('tgl_mulai')
                            ->label('Tanggal Mulai')
                            ->required(),
                        Forms\Components\DatePicker::make('tgl_selesai')
                            ->label('Tanggal Selesai')
                            ->required()
                            ->afterOrEqual('tgl_mulai'),
                        Forms\Components\Select::make('status_magang')
                            ->options([
                                'Aktif'   => 'Aktif',
                                'Selesai' => 'Selesai',
                                'Batal'   => 'Batal',
                            ])
                            ->default('Aktif')
                            ->required(),
                    ])->columns(3),
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
                    ->label('Industri')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guru_pembimbing.nama')
                    ->label('Guru Pembimbing')
                    // Opsional: Tambahkan jurusan sebagai deskripsi kecil di bawah nama pada tabel
                    ->description(fn($record) => $record->guru_pembimbing?->jurusan)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pembimbing_industri.nama')
                    ->label('Pembimbing Lapangan')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tgl_mulai')
                    ->label('Mulai')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tgl_selesai')
                    ->label('Selesai')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status_magang')
                    ->label('Status')
                    ->colors([
                        'success' => 'Aktif',
                        'primary' => 'Selesai',
                        'danger'  => 'Batal',
                    ]),
            ])
            ->filters([
                //
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
            'index'  => Pages\ListPraktekKerjaLapangans::route('/'),
            'create' => Pages\CreatePraktekKerjaLapangan::route('/create'),
            'edit'   => Pages\EditPraktekKerjaLapangan::route('/{record}/edit'),
        ];
    }
}
