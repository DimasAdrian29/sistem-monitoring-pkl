<?php
namespace App\Filament\Resources;

use App\Filament\Resources\GuruPembimbingResource\Pages;
use App\Models\GuruPembimbing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuruPembimbingResource extends Resource
{
    protected static ?string $model = GuruPembimbing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Guru Pembimbing')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nip')
                            ->label('NIP (Digunakan untuk Username login)')
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
                        Forms\Components\TextInput::make('jurusan')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('nomor_telepon')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Manajemen Akun')
                    ->description('Reset password guru jika lupa. Kosongkan jika tidak ingin diubah.')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label('Password Baru')
                            ->dehydrated(false) // Tidak disimpan ke tabel guru_pembimbings
                            ->revealable(),
                    ])
                    ->hiddenOn('create'), // Hanya tampil saat mengedit data
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')->label('NIP')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('jurusan')->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon'),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Username Login')
                    ->badge()
                    ->color('info'),
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
            'index'  => Pages\ListGuruPembimbings::route('/'),
            'create' => Pages\CreateGuruPembimbing::route('/create'),
            'edit'   => Pages\EditGuruPembimbing::route('/{record}/edit'),
        ];
    }
}
