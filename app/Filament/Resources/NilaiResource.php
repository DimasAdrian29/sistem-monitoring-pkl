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

    protected static ?string $navigationIcon = 'heroicon-o-star';

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
                                modifyQueryUsing: fn (Builder $query) => $query->with(['siswa', 'industri'])
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->siswa->nama} (di {$record->industri->nama})")
                            ->label('Data PKL Siswa')
                            ->searchable()
                            ->preload()
                            ->required(),

                        // Asumsi penginput bisa memilih siapa pembimbing industri & guru pembimbing yang menilai
                        Forms\Components\Select::make('pembimbing_industri_id')
                            ->relationship('pembimbing_industri', 'nama')
                            ->label('Pembimbing Industri')
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('guru_pembimbing_id')
                            ->relationship('guru_pembimbing', 'nama')
                            ->label('Guru Pembimbing')
                            ->searchable()
                            ->preload(),
                    ])->columns(3),

                Forms\Components\Section::make('Input Nilai Aspek (0-100)')
                    ->schema([
                        Forms\Components\TextInput::make('aspek_soft_skills')
                            ->label('1. Soft Skills')
                            ->helperText('Menerapkan Soft skills yang dibutuhkan dunia kerja')
                            ->numeric()->minValue(0)->maxValue(100)->required(),

                        Forms\Components\TextInput::make('aspek_norma_k3lh')
                            ->label('2. Norma, POS & K3LH')
                            ->helperText('Menerapkan norma, POS dan K3LH di tempat PKL')
                            ->numeric()->minValue(0)->maxValue(100)->required(),

                        Forms\Components\TextInput::make('aspek_kompetensi_teknis')
                            ->label('3. Kompetensi Teknis')
                            ->helperText('Menerapkan kompetensi teknis dari sekolah/dunia kerja')
                            ->numeric()->minValue(0)->maxValue(100)->required(),

                        Forms\Components\TextInput::make('aspek_wawasan_bisnis')
                            ->label('4. Wawasan Bisnis & Wirausaha')
                            ->helperText('Memahami alur bisnis dunia kerja dan wawasan wirausaha')
                            ->numeric()->minValue(0)->maxValue(100)->required(),

                        Forms\Components\TextInput::make('aspek_penyusunan_laporan')
                            ->label('5. Penyusunan Laporan')
                            ->helperText('Menyusun laporan PKL sesuai kaidah penulisan ilmiah')
                            ->numeric()->minValue(0)->maxValue(100)->required(),

                        Forms\Components\TextInput::make('aspek_presentasi')
                            ->label('6. Presentasi Hasil')
                            ->helperText('Mempresentasikan hasil PKL & capaian kompetensi')
                            ->numeric()->minValue(0)->maxValue(100)->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Catatan Pembimbing')
                    ->schema([
                        Forms\Components\Textarea::make('catatan_pembimbing_industri')
                            ->label('Catatan dari Pembimbing Industri')
                            ->placeholder('Masukkan evaluasi dari pihak industri...')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('catatan_guru_pembimbing')
                            ->label('Catatan dari Guru Pembimbing')
                            ->placeholder('Masukkan evaluasi dari guru sekolah...')
                            ->columnSpanFull(),
                    ]),
            ]);
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

                // Menampilkan salah satu nilai aspek sebagai indikator di tabel, sisanya disembunyikan (toggleable)
                Tables\Columns\TextColumn::make('aspek_kompetensi_teknis')
                    ->label('Nilai Teknis')
                    ->sortable(),

                Tables\Columns\TextColumn::make('aspek_soft_skills')->label('Soft Skills')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('aspek_norma_k3lh')->label('K3LH')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('aspek_wawasan_bisnis')->label('Bisnis')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('aspek_penyusunan_laporan')->label('Laporan')->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('aspek_presentasi')->label('Presentasi')->toggleable(isToggledHiddenByDefault: true),

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
