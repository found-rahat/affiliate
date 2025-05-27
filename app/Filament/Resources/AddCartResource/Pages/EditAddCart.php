<?php

namespace App\Filament\Resources\AddCartResource\Pages;

use App\Filament\Resources\AddCartResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddCart extends EditRecord
{
    protected static string $resource = AddCartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
