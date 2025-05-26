<?php

namespace App\Filament\Resources\UserPanalResource\Pages;

use App\Filament\Resources\UserPanalResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserPanal extends ViewRecord
{
    protected static string $resource = UserPanalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
