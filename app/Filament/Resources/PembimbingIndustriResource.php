<?php
namespace App\Filament\Resources;

use App\Filament\Imports\PembimbingIndustriImporter; // Wajib ditambahkan
use App\Filament\Resources\PembimbingIndustriResource\Pages;
use App\Models\PembimbingIndustri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembimbingIndustriResource extends Resource
{
    protected static ?string $model = PembimbingIndustri::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Penempatan')
                    ->schema([
                        Forms\Components\Select::make('industri_id')
                            ->relationship('industri', 'nama')
                            ->label('Pilih Industri')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),

                Forms\Components\Section::make('Data Pembimbing')
                    ->schema([
                        Forms\Components\TextInput::make('nama')->required()->maxLength(255),
                        Forms\Components\TextInput::make('jabatan')->required()->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])->required(),

                        Forms\Components\Select::make('agama')
                            ->options([
                                'Islam'   => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu'   => 'Hindu',
                                'Buddha'  => 'Buddha',
                                'Konghucu'=> 'Konghucu',
                            ]),

                        Forms\Components\TextInput::make('nomor_telepon')
                            ->tel()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('alamat')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Manajemen Akun Login')
                    ->description('Buat username dan password secara manual.')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->label('Username Login')
                            ->required()
                            ->unique('users', 'username')
                            ->hiddenOn('edit'),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->label(fn(string $context): string => $context === 'create' ? 'Password' : 'Reset Password Baru')
                            ->required(fn(string $context): bool => $context === 'create')
                            ->revealable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('industri.nama')->label('Asal Industri')->searchable(),
                Tables\Columns\TextColumn::make('nama')->searchable(),
                Tables\Columns\TextColumn::make('jabatan')->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon')
                    ->placeholder('Belum diisi'),
                Tables\Columns\TextColumn::make('user.username')
                    ->label('Username Login')
                    ->badge()
                    ->color('warning'),
            ])
            // --- TOMBOL IMPORT DITAMBAHKAN DI SINI ---
            ->headerActions([
                Tables\Actions\ImportAction::make()
                    ->importer(PembimbingIndustriImporter::class)
                    ->label('Import Pembimbing')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('primary'),
            ])
            // ------------------------------------------
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
            'index'  => Pages\ListPembimbingIndustris::route('/'),
            'create' => Pages\CreatePembimbingIndustri::route('/create'),
            'edit'   => Pages\EditPembimbingIndustri::route('/{record}/edit'),
        ];
    }
}
