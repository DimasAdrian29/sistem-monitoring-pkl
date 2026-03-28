<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ForumChatResource\Pages;
use App\Models\ForumChat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ForumChatResource extends Resource
{
    protected static ?string $model = ForumChat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kirim Pesan (Admin Mode)')
                    ->schema([
                        Forms\Components\Select::make('praktek_kerja_lapangan_id')
                            ->relationship('praktek_kerja_lapangan', 'id')
                            ->getOptionLabelFromRecordUsing(fn($record) => "Grup: {$record->siswa->nama} (di {$record->industri->nama})")
                            ->label('Pilih Ruang Chat (Data PKL)')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'username')
                            ->label('Kirim Sebagai')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Textarea::make('isi_pesan')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('praktek_kerja_lapangan.siswa.nama')
                    ->label('Grup Siswa')
                    ->description(fn($record) => 'Industri: ' . $record->praktek_kerja_lapangan->industri->nama)
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.username')
                    ->label('Pengirim')
                    ->badge()
                    ->color(fn($record) => match ($record->user->role) {
                        'admin'               => 'danger',
                        'guru_pembimbing'     => 'info',
                        'pembimbing_industri' => 'warning',
                        default               => 'success', // Siswa
                    }),

                Tables\Columns\TextColumn::make('isi_pesan')
                    ->label('Pesan')
                    ->wrap() // Agar teks panjang turun ke bawah
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Pesan terbaru di atas
            ->actions([
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
            'index'  => Pages\ListForumChats::route('/'),
            'create' => Pages\CreateForumChat::route('/create'),
            'edit'   => Pages\EditForumChat::route('/{record}/edit'),
        ];
    }
}
