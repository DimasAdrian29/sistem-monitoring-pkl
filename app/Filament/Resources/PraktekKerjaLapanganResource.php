<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PraktekKerjaLapanganResource\Pages;
use App\Models\PengajuanMagang;
use App\Models\PraktekKerjaLapangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource; // Ditambahkan untuk mengatur state field lain
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
                                // Hanya tampilkan siswa yang pengajuannya "Diterima"
                                modifyQueryUsing: fn(Builder $query) => $query->whereIn('id', PengajuanMagang::where('status_pengajuan', 'Diterima')->select('siswa_id'))
                            )
                        // Tampilkan Nama - Kelas - Jurusan
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->nama} - {$record->kelas} - {$record->jurusan}")
                            ->searchable()
                            ->preload()
                            ->live() // Membuat field ini reaktif
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                // Jika admin memilih siswa (state tidak kosong)
                                if ($state) {
                                    // Cari data pengajuan magang milik siswa tersebut yang diterima
                                    $pengajuan = PengajuanMagang::where('siswa_id', $state)
                                        ->where('status_pengajuan', 'Diterima')
                                        ->first();

                                    // Jika ketemu, set nilai dropdown industri_id secara otomatis
                                    if ($pengajuan) {
                                        $set('industri_id', $pengajuan->industri_id);
                                    }
                                } else {
                                    // Kosongkan industri jika siswa dihapus dari dropdown
                                    $set('industri_id', null);
                                }
                            })
                            ->required(),

                        Forms\Components\Select::make('industri_id')
                            ->relationship('industri', 'nama')
                            ->label('Tempat Industri')
                            ->searchable()
                            ->preload()
                            // Ganti readOnly() menjadi kombinasi dua baris ini:
                            ->disabled()
                            ->dehydrated() // Wajib ditambahkan agar data yang di-disable tetap disave ke database
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Pembimbing')
                    ->schema([
                        Forms\Components\Select::make('guru_pembimbing_id')
                            ->relationship('guru_pembimbing', 'nama')
                            ->label('Guru Pembimbing (Sekolah)')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('pembimbing_industri_id')
                            ->relationship('pembimbing_industri', 'nama')
                            ->label('Pembimbing Industri (Lapangan)')
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
