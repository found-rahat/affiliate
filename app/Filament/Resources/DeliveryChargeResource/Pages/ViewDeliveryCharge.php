<?php

namespace App\Filament\Resources\DeliveryChargeResource\Pages;

use App\Filament\Resources\DeliveryChargeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDeliveryCharge extends ViewRecord
{
    protected static string $resource = DeliveryChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
