<?php

namespace App\Filament\Resources\CollectionUserInfoResource\Pages;

use App\Filament\Resources\CollectionUserInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollectionUserInfos extends ListRecords
{
    protected static string $resource = CollectionUserInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
