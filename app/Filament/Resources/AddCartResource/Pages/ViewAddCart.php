<?php

namespace App\Filament\Resources\AddCartResource\Pages;

use App\Filament\Resources\AddCartResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAddCart extends ViewRecord
{
    protected static string $resource = AddCartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
        ];
    }
}
