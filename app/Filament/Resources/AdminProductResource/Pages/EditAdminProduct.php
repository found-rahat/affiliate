<?php

namespace App\Filament\Resources\AdminProductResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AdminProductResource;

class EditAdminProduct extends EditRecord
{
    protected static string $resource = AdminProductResource::class;

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
            ->title('Product Updated ')
            ->icon('heroicon-o-bookmark-square')
            ->body('The Product has been Updated successfully.');
    }
     protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
