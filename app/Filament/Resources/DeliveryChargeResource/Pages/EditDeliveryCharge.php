<?php

namespace App\Filament\Resources\DeliveryChargeResource\Pages;

use App\Filament\Resources\DeliveryChargeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDeliveryCharge extends EditRecord
{
    protected static string $resource = DeliveryChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
