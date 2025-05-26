<?php

namespace App\Filament\Resources\CollectProductStockResource\Pages;

use App\Filament\Resources\CollectProductStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCollectProductStocks extends ListRecords
{
    protected static string $resource = CollectProductStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
