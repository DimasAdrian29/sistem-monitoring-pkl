<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NilaiResource\Pages;
use App\Models\Nilai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NilaiResource extends Resource
{
    protected static ?string $model = Nilai::class;

    protected static ?string $navigationIcon = 'heroicon-o-star'; // Mengganti icon agar lebih relevan dengan 'Nilai'

    protected static ?string $navigationLabel = 'Penilaian PKL';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Penilaian')
                    ->schema([
                        Forms\Components\Select::make('praktek_kerja_lapangan_id')
                            ->relationship(
                                name: 'praktek_kerja_lapangan',
                                titleAttribute: 'id',
                                // Memastikan data siswa dan industri ikut terambil agar nama muncul
                                modifyQueryUsing: fn (Builder $query) => $query->with(['siswa', 'industri'])
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->siswa->nama} (di {$record->industri->nama})")
                            ->label('Data PKL Siswa')
                            ->searchable()
                            ->preload() // Memperbaiki daftar agar muncul saat diklik
                            ->required(),

                        Forms\Components\Select::make('pembimbing_industri_id')
                            ->relationship('pembimbing_industri', 'nama')
                            ->label('Pembimbing Industri')
                            ->searchable()
                            ->preload() // Memperbaiki daftar agar muncul saat diklik
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Input Nilai (0-100)')
                    ->schema([
                        Forms\Components\TextInput::make('disiplin')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::updateNilaiAkhir($set, $get)),

                        Forms\Components\TextInput::make('tanggung_jawab')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::updateNilaiAkhir($set, $get)),

                        Forms\Components\TextInput::make('kompetensi_teknis')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, Forms\Get $get) => self::updateNilaiAkhir($set, $get)),

                        Forms\Components\TextInput::make('nilai_akhir')
                            ->label('Nilai Akhir (Rata-rata)')
                            ->numeric()
                            ->readOnly()
                            ->required(),
                    ])->columns(4),

                Forms\Components\Textarea::make('catatan_pembimbing')
                    ->placeholder('Contoh: Siswa sangat proaktif dalam mengerjakan tugas...')
                    ->columnSpanFull(),
            ]);
    }

    // Fungsi Logika Hitung Rata-rata
    public static function updateNilaiAkhir(Forms\Set $set, Forms\Get $get): void
    {
        $disiplin = (float) ($get('disiplin') ?? 0);
        $tanggungJawab = (float) ($get('tanggung_jawab') ?? 0);
        $kompetensi = (float) ($get('kompetensi_teknis') ?? 0);

        $rataRata = ($disiplin + $tanggungJawab + $kompetensi) / 3;

        // Menggunakan format angka yang bisa dibaca sebagai numeric oleh database
        $set('nilai_akhir', round($rataRata, 2));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('praktek_kerja_lapangan.siswa.nama')
                    ->label('Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('praktek_kerja_lapangan.industri.nama')
                    ->label('Industri')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nilai_akhir')
                    ->label('Rata-rata')
                    ->badge()
                    ->color(fn ($state) => $state >= 75 ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Input')
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
            'index' => Pages\ListNilais::route('/'),
            'create' => Pages\CreateNilai::route('/create'),
            'edit' => Pages\EditNilai::route('/{record}/edit'),
        ];
    }
}
