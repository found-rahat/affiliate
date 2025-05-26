<?php

namespace App\Filament\Resources\UserPanalResource\Pages;

use App\Filament\Resources\UserPanalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserPanal extends EditRecord
{
    protected static string $resource = UserPanalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
