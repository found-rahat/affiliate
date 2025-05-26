<?php

namespace App\Filament\Resources\CuriorServiceProviderCostResource\Pages;

use App\Filament\Resources\CuriorServiceProviderCostResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateCuriorServiceProviderCost extends CreateRecord
{
    protected static string $resource = CuriorServiceProviderCostResource::class;

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
         ->success()
            ->title('Curior Created')
            ->body('The Curior has been created successfully.');

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
