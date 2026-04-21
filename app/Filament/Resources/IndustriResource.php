<?php
namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Models\Industri;
use Dotswan\MapPicker\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IndustriResource extends Resource
{
    protected static ?string $model = Industri::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
     protected static ?string $pluralModelLabel = 'Data Industri';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nomor_telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255),

                // Tambahkan Peta Interaktif di sini
                Map::make('lokasi')
                    ->label('Pilih Titik Lokasi Peta (Otomatis Kota Pekanbaru)')
                    ->columnSpanFull()
                // Koordinat tengah Kota Pekanbaru, Riau
                    ->defaultLocation(0.5071, 101.4451)
                    ->afterStateUpdated(function (Set $set, ?array $state): void {
                        // Saat pin digeser, otomatis mengisi input latitude dan longitude
                        if ($state) {
                            $set('latitude', $state['lat']);
                            $set('longitude', $state['lng']);
                        }
                    })
                    ->afterStateHydrated(function (Set $set, $record): void {
                        // Saat mengedit data, tampilkan pin di koordinat yang sudah tersimpan
                        if ($record && $record->latitude && $record->longitude) {
                            $set('lokasi', ['lat' => $record->latitude, 'lng' => $record->longitude]);
                        }
                    })
                    ->live(onBlur: true)
                    ->showMarker()
                    ->draggable()
                    ->zoom(12),

                Forms\Components\Textarea::make('alamat')
                    ->label('Detail Alamat (Ketik manual setelah memilih titik peta)')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('latitude')
                    ->readOnly() // Dibuat readOnly agar user tidak mengetik manual, tapi bergantung pada peta
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->readOnly()
                    ->numeric(),

                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor_telepon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
            'index'  => Pages\ListIndustris::route('/'),
            'create' => Pages\CreateIndustri::route('/create'),
            'edit'   => Pages\EditIndustri::route('/{record}/edit'),
        ];
    }
}
