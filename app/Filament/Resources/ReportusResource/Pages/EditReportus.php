<?php

namespace App\Filament\Resources\ReportusResource\Pages;

use App\Filament\Resources\ReportusResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditReportus extends EditRecord
{
    protected static string $resource = ReportusResource::class;

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
            ->title('Report updated')
            ->body('The Report has been saved successfully.');

    }
    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
