<?php

namespace App\Filament\Resources\CuriorServiceProviderCostResource\Pages;

use App\Filament\Resources\CuriorServiceProviderCostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCuriorServiceProviderCosts extends ListRecords
{
    protected static string $resource = CuriorServiceProviderCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
