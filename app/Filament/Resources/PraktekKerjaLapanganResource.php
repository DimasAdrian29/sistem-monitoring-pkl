<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PraktekKerjaLapanganResource\Pages;
use App\Models\PengajuanMagang;
use App\Models\PraktekKerjaLapangan;
use App\Models\Siswa;
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
    protected static ?string $pluralModelLabel = 'Praktek Kerja Lapangan';

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
                                modifyQueryUsing: function (Builder $query, ?PraktekKerjaLapangan $record) {
                                    // 1. Ambil siswa yang pengajuannya sudah Diterima
                                    $query->whereIn('id', PengajuanMagang::where('status_pengajuan', 'Diterima')->select('siswa_id'));

                                    // 2. Filter agar siswa yang sudah masuk ke Praktek Kerja Lapangan tidak muncul lagi
                                    if ($record) {
                                        // Mode EDIT: Sembunyikan semua siswa yang sudah di PKL, KECUALI siswa pada record yang sedang diedit ini
                                        $query->whereNotIn('id', PraktekKerjaLapangan::where('id', '!=', $record->id)->select('siswa_id'));
                                    } else {
                                        // Mode CREATE: Sembunyikan semua siswa yang sudah terdaftar di PKL
                                        $query->whereNotIn('id', PraktekKerjaLapangan::select('siswa_id'));
                                    }
                                }
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
                // 1. Filter Status Magang
                Tables\Filters\SelectFilter::make('status_magang')
                    ->label('Status Magang')
                    ->options([
                        'Aktif'   => 'Aktif',
                        'Selesai' => 'Selesai',
                        'Batal'   => 'Batal',
                    ]),

                // 2. Filter Kelas (Mengambil dari relasi siswa)
                Tables\Filters\SelectFilter::make('kelas')
                    ->label('Kelas')
                    ->options([
                        'X'   => 'Kelas X',
                        'XI'  => 'Kelas XI',
                        'XII' => 'Kelas XII',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('siswa', function (Builder $query) use ($data) {
                                $query->where('kelas', $data['value']);
                            });
                        }
                    }),

                // 3. Filter Jurusan (Dinamis mengambil jurusan unik dari tabel siswa)
                Tables\Filters\SelectFilter::make('jurusan')
                    ->label('Jurusan')
                    ->options(fn () => Siswa::query()->select('jurusan')->distinct()->pluck('jurusan', 'jurusan')->toArray())
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->whereHas('siswa', function (Builder $query) use ($data) {
                                $query->where('jurusan', $data['value']);
                            });
                        }
                    }),
            ])
            ->actions([
                // Action Tombol Update Status Selesai
                Tables\Actions\Action::make('tandai_selesai')
                    ->label('Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai PKL Selesai')
                    ->modalDescription('Apakah Anda yakin ingin mengubah status magang siswa ini menjadi Selesai?')
                    ->action(fn (PraktekKerjaLapangan $record) => $record->update(['status_magang' => 'Selesai']))
                    ->visible(fn (PraktekKerjaLapangan $record) => $record->status_magang !== 'Selesai'), // Sembunyikan jika sudah selesai

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
