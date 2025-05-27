<?php

namespace App\Filament\Resources\AddCartResource\Pages;

use App\Filament\Resources\AddCartResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddCarts extends ListRecords
{
    protected static string $resource = AddCartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
