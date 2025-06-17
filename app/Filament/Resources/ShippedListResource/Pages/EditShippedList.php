<?php

namespace App\Filament\Resources\ShippedListResource\Pages;

use App\Filament\Resources\ShippedListResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShippedList extends EditRecord
{
    protected static string $resource = ShippedListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }
}
