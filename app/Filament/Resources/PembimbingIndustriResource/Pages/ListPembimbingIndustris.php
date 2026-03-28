<?php

namespace App\Filament\Resources\PembimbingIndustriResource\Pages;

use App\Filament\Resources\PembimbingIndustriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembimbingIndustris extends ListRecords
{
    protected static string $resource = PembimbingIndustriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
