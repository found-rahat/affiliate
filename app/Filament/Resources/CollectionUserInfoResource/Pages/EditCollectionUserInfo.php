<?php

namespace App\Filament\Resources\CollectionUserInfoResource\Pages;

use App\Filament\Resources\CollectionUserInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCollectionUserInfo extends EditRecord
{
    protected static string $resource = CollectionUserInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
