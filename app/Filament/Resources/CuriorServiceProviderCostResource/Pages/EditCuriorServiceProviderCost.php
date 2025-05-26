<?php

namespace App\Filament\Resources\CuriorServiceProviderCostResource\Pages;

use App\Filament\Resources\CuriorServiceProviderCostResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCuriorServiceProviderCost extends EditRecord
{
    protected static string $resource = CuriorServiceProviderCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Curier Updated')
            ->body('The Curier has been Updated successfully.');
    }




    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
