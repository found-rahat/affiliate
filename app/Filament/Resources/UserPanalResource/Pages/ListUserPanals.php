<?php

namespace App\Filament\Resources\UserPanalResource\Pages;

use App\Filament\Resources\UserPanalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserPanals extends ListRecords
{
    protected static string $resource = UserPanalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
