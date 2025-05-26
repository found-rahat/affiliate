<?php

namespace App\Filament\Resources\CollectProductStockResource\Pages;

use App\Filament\Resources\CollectProductStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCollectProductStock extends ViewRecord
{
    protected static string $resource = CollectProductStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
