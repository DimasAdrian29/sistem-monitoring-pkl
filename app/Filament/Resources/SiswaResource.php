<?php
namespace App\Filament\Resources;

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
                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam'   => 'Islam', 'Kristen'   => 'Kristen',
                                'Katolik' => 'Katolik', 'Hindu'   => 'Hindu',
                                'Buddha'  => 'Buddha', 'Konghucu' => 'Konghucu',
                            ])->required(),
                        Forms\Components\TextInput::make('kelas')->required(),
                        Forms\Components\TextInput::make('jurusan')->required(),
                        Forms\Components\TextInput::make('nomor_telepon')->tel()->required(),
                        Forms\Components\TextInput::make('nomor_telepon_wali')->tel()->required(),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Manajemen Akun')
                    ->description('Reset password siswa jika lupa. Kosongkan jika tidak ingin diubah.')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Password Baru')
                            ->dehydrated(false) // Jangan masukkan ke tabel siswa
                            ->revealable(),
                    ])
                    ->hiddenOn('create'), // Hanya tampil saat di halaman Edit
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nisn')->label('NISN/NIK')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('kelas')->searchable(),
                Tables\Columns\TextColumn::make('jurusan')->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon'),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Username Login')
                    ->badge()
                    ->color('success'),
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
            'index'  => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit'   => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
