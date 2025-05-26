<?php

namespace App\Filament\Resources\AdminProductResource\Pages;

use App\Filament\Resources\AdminProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdminProduct extends ViewRecord
{
    protected static string $resource = AdminProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
