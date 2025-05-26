<?php

namespace App\Filament\Resources\CollectionUserInfoResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\CollectionUserInfoResource;

class ViewCollectionUserInfo extends ViewRecord
{
    protected static string $resource = CollectionUserInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\EditAction::make(),
            Action::make('View Collected Products')
                ->url(fn ($record) => CollectionUserInfoResource::getUrl('view-collected-products', [
                    'recordId' => $record->id,
                ]))
                ->label('Collected Products')
                ->icon('heroicon-o-eye')
        ];
    }
}
