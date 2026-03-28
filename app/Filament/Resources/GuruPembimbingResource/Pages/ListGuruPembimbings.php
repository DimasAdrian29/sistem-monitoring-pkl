<?php

namespace App\Filament\Resources\GuruPembimbingResource\Pages;

use App\Filament\Resources\GuruPembimbingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuruPembimbings extends ListRecords
{
    protected static string $resource = GuruPembimbingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
