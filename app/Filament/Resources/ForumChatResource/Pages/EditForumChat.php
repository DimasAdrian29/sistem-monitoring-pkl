<?php

namespace App\Filament\Resources\ForumChatResource\Pages;

use App\Filament\Resources\ForumChatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForumChat extends EditRecord
{
    protected static string $resource = ForumChatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
