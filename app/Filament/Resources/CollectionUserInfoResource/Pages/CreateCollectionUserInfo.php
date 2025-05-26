<?php

namespace App\Filament\Resources\CollectionUserInfoResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CollectionUserInfoResource;

class CreateCollectionUserInfo extends CreateRecord
{
    protected static string $resource = CollectionUserInfoResource::class;
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
        ->success()
        ->title('Collection id Created')
        ->body('The Collection id has been created successfully.');

    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
