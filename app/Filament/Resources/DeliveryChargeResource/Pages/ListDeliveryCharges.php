<?php

namespace App\Filament\Resources\DeliveryChargeResource\Pages;

use App\Filament\Resources\DeliveryChargeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeliveryCharges extends ListRecords
{
    protected static string $resource = DeliveryChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
