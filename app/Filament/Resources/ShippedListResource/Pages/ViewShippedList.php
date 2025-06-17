<?php

namespace App\Filament\Resources\ShippedListResource\Pages;

use App\Filament\Resources\ShippedListResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewShippedList extends ViewRecord
{
    protected static string $resource = ShippedListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
