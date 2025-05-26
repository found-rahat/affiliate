<?php

namespace App\Filament\Resources\AdminProductResource\Pages;

use App\Filament\Resources\AdminProductResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAdminProduct extends CreateRecord
{
    protected static string $resource = AdminProductResource::class;



    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product Created ')
            ->icon('heroicon-o-credit-card')
            ->body('The Product has been created successfully.');
    }
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
