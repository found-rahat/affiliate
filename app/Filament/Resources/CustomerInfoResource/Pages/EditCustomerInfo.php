<?php

namespace App\Filament\Resources\CustomerInfoResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CustomerInfoResource;

class EditCustomerInfo extends EditRecord
{
    protected static string $resource = CustomerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
{
    return Notification::make()
        ->success()
        ->title('Customer Info Updated')
        ->body('The Customer has been Updated successfully.');
}

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->record]);
    }
}
