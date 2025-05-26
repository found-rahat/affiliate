<?php

namespace App\Filament\Resources\AdminProductResource\Pages;

use App\Filament\Resources\AdminProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdminProducts extends ListRecords
{
    protected static string $resource = AdminProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
