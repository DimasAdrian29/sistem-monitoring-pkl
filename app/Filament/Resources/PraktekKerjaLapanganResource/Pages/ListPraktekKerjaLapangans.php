<?php

namespace App\Filament\Resources\PraktekKerjaLapanganResource\Pages;

use App\Filament\Resources\PraktekKerjaLapanganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPraktekKerjaLapangans extends ListRecords
{
    protected static string $resource = PraktekKerjaLapanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
