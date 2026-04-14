<?php
namespace App\Filament\Resources;

use App\Filament\Imports\SiswaImporter; // Import class Importer yang baru dibuat
use App\Filament\Resources\SiswaResource\Pages;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi Siswa')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nisn')
                            ->label('NISN / NIK (Digunakan untuk Username login)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])->required(),

                        // Agama dibuat Nullable (Opsional)
                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam'   => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu'   => 'Hindu',
                                'Buddha'  => 'Buddha',
                                'Konghucu'=> 'Konghucu',
                            ]),

                        Forms\Components\Select::make('kelas')
                            ->options([
                                'XI' => 'Kelas XI',
                                'XII' => 'Kelas XII',
                                'XIII' => 'Kelas XIII',
                            ])
                            ->required(),

                        Forms\Components\Select::make('jurusan')
                            ->options([
                                'Teknik Konstruksi dan Perumahan' => 'Teknik Konstruksi dan Perumahan',
                                'Desain Pemodelan dan Informasi Bangunan' => 'Desain Pemodelan dan Informasi Bangunan',
                                'Teknik Pemesinan' => 'Teknik Pemesinan',
                                'Teknik Kendaraan Ringan' => 'Teknik Kendaraan Ringan',
                                'Teknik Sepeda Motor' => 'Teknik Sepeda Motor',
                                'Teknik Audio Video' => 'Teknik Audio Video',
                                'Teknik Instalasi Tenaga Listrik' => 'Teknik Instalasi Tenaga Listrik',
                                'Teknik Pemanasan, Tata Udara dan Pendinginan' => 'Teknik Pemanasan, Tata Udara dan Pendinginan',
                                'Teknik Geologi Pertambangan (4Tahun)' => 'Teknik Geologi Pertambangan (4Tahun)',
                                'Teknik Komputer dan Jaringan' => 'Teknik Komputer dan Jaringan',
                                'Desain Komunikasi Visual' => 'Desain Komunikasi Visual',
                            ])
                            ->searchable()
                            ->required(),

                        // Nomor telepon dibuat Nullable (Opsional)
                        Forms\Components\TextInput::make('nomor_telepon')
                            ->tel(),

                        // Nomor telepon wali dibuat Nullable (Opsional)
                        Forms\Components\TextInput::make('nomor_telepon_wali')
                            ->tel(),

                        // Alamat dibuat Nullable (Opsional)
                        Forms\Components\Textarea::make('alamat')
                            ->columnSpanFull(),

                    ])->columns(2),

                Forms\Components\Section::make('Manajemen Akun')
                    ->description('Reset password siswa jika lupa. Kosongkan jika tidak ingin diubah.')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Password Baru')
                            ->dehydrated(false)
                            ->revealable(),
                    ])
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nisn')->label('NISN/NIK')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kelas')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('jurusan')->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon')
                    ->placeholder('Belum diisi'), // Menampilkan teks jika null
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Username Login')
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jurusan')
                    ->options([
                        'Teknik Konstruksi dan Perumahan' => 'Teknik Konstruksi dan Perumahan',
                        'Desain Pemodelan dan Informasi Bangunan' => 'Desain Pemodelan dan Informasi Bangunan',
                        'Teknik Pemesinan' => 'Teknik Pemesinan',
                        'Teknik Kendaraan Ringan' => 'Teknik Kendaraan Ringan',
                        'Teknik Sepeda Motor' => 'Teknik Sepeda Motor',
                        'Teknik Audio Video' => 'Teknik Audio Video',
                        'Teknik Instalasi Tenaga Listrik' => 'Teknik Instalasi Tenaga Listrik',
                        'Teknik Pemanasan, Tata Udara dan Pendinginan' => 'Teknik Pemanasan, Tata Udara dan Pendinginan',
                        'Teknik Geologi Pertambangan (4Tahun)' => 'Teknik Geologi Pertambangan (4Tahun)',
                        'Teknik Komputer dan Jaringan' => 'Teknik Komputer dan Jaringan',
                        'Desain Komunikasi Visual' => 'Desain Komunikasi Visual',
                    ]),
            ])
            // --- BAGIAN INI DITAMBAHKAN UNTUK TOMBOL IMPORT CSV ---
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(SiswaImporter::class)
                    ->label('Import Siswa')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
            ])
            // --------------------------------------------------------
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index'  => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit'   => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
