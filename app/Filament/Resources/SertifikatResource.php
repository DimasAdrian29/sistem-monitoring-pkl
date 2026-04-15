<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SertifikatResource\Pages;
use App\Models\PraktekKerjaLapangan;
use App\Models\Sertifikat;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class SertifikatResource extends Resource
{
    // Kita pakai model PKL sebagai sumber data utama
    protected static ?string $model = PraktekKerjaLapangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Sertifikat';
    protected static ?string $modelLabel = 'Sertifikat';
    protected static ?string $pluralModelLabel = 'Kelola Sertifikat';
    protected static ?string $navigationGroup = 'Manajemen PKL';

    public static function form(Form $form): Form
    {
        // Form tidak dipakai, tapi wajib ada
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Hanya tampilkan siswa dengan status Selesai
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->where('status_magang', 'Selesai')
                ->with(['siswa', 'industri', 'guruPembimbing', 'pembimbingIndustri', 'nilai', 'sertifikat'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('siswa.nisn')
                    ->label('NISN')
                    ->searchable(),

                Tables\Columns\TextColumn::make('siswa.kelas')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('siswa.jurusan')
                    ->label('Jurusan'),

                Tables\Columns\TextColumn::make('industri.nama')
                    ->label('Tempat Industri')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tgl_mulai')
                    ->label('Mulai')
                    ->date('d M Y'),

                Tables\Columns\TextColumn::make('tgl_selesai')
                    ->label('Selesai')
                    ->date('d M Y'),

                // Status sertifikat: sudah/belum dicetak
                Tables\Columns\BadgeColumn::make('sertifikat.dicetak_pada')
                    ->label('Status Sertifikat')
                    ->formatStateUsing(fn ($state) => $state ? 'Sudah Dicetak' : 'Belum Dicetak')
                    ->color(fn ($state) => $state ? 'success' : 'warning'),
            ])
            ->filters([
                SelectFilter::make('kelas')
                    ->label('Filter Kelas')
                    ->options(fn () =>
                        \App\Models\Siswa::distinct()->pluck('kelas', 'kelas')->toArray()
                    )
                    ->query(fn (Builder $query, array $data) =>
                        $data['value'] ? $query->whereHas('siswa', fn($q) => $q->where('kelas', $data['value'])) : $query
                    ),

                SelectFilter::make('jurusan')
                    ->label('Filter Jurusan')
                    ->options(fn () =>
                        \App\Models\Siswa::distinct()->pluck('jurusan', 'jurusan')->toArray()
                    )
                    ->query(fn (Builder $query, array $data) =>
                        $data['value'] ? $query->whereHas('siswa', fn($q) => $q->where('jurusan', $data['value'])) : $query
                    ),

                SelectFilter::make('industri_id')
                    ->label('Filter Tempat Industri')
                    ->options(fn () =>
                        \App\Models\Industri::pluck('nama', 'id')->toArray()
                    ),
            ])
            ->actions([
                // Tombol Cetak Sertifikat
                Action::make('cetak')
                    ->label('Cetak Sertifikat')
                    ->icon('heroicon-o-printer')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->modalHeading('Generate Sertifikat')
                    ->modalDescription('Sertifikat PDF akan di-generate dan disimpan. Lanjutkan?')
                    ->action(function (PraktekKerjaLapangan $record) {
                        try {
                            // Load relasi yang dibutuhkan
                            $record->load(['siswa', 'industri', 'guruPembimbing', 'pembimbingIndustri', 'nilai']);

                            // Generate PDF dari template blade
                            $pdf = Pdf::loadView('sertifikat.template', ['pkl' => $record])
                                ->setPaper('a4', 'landscape');

                            // Nama file unik
                            $filename = 'sertifikat_' . $record->siswa->nisn . '_' . time() . '.pdf';
                            $path = 'sertifikats/' . $filename;

                            // Simpan ke storage/app/public/sertifikats/
                            Storage::disk('public')->put($path, $pdf->output());

                            // Simpan atau update record sertifikat
                            Sertifikat::updateOrCreate(
                                ['praktek_kerja_lapangan_id' => $record->id],
                                [
                                    'url_sertifikat' => $path,
                                    'dicetak_pada'   => now(),
                                ]
                            );

                            Notification::make()
                                ->title('Sertifikat berhasil di-generate!')
                                ->success()
                                ->send();

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal generate sertifikat')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),

                // Tombol Preview/Download (hanya muncul jika sudah dicetak)
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->url(fn (PraktekKerjaLapangan $record) =>
                        $record->sertifikat ? Storage::url($record->sertifikat->url_sertifikat) : null
                    )
                    ->openUrlInNewTab()
                    ->visible(fn (PraktekKerjaLapangan $record) => (bool) $record->sertifikat),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSertifikats::route('/'),
        ];
    }
}
