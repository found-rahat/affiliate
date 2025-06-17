<?php

namespace App\Filament\Resources\ShippedListResource\Pages;

use App\Filament\Resources\ShippedListResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShippedLists extends ListRecords
{
    protected static string $resource = ShippedListResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
