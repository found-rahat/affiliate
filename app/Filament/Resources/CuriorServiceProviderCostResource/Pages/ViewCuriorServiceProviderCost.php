<?php

namespace App\Filament\Resources\CuriorServiceProviderCostResource\Pages;

use App\Filament\Resources\CuriorServiceProviderCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCuriorServiceProviderCost extends ViewRecord
{
    protected static string $resource = CuriorServiceProviderCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
