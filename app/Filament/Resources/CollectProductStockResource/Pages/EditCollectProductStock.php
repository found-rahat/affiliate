<?php

namespace App\Filament\Resources\CollectProductStockResource\Pages;

use App\Filament\Resources\CollectProductStockResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditCollectProductStock extends EditRecord
{
    protected static string $resource = CollectProductStockResource::class;

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
            ->title('Price Updated ')
            ->icon('heroicon-o-currency-bangladeshi')
            ->body('The Price has been Updated successfully.');
    }
}
