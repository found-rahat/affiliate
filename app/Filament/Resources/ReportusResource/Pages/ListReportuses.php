<?php

namespace App\Filament\Resources\ReportusResource\Pages;

use App\Filament\Resources\ReportusResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReportuses extends ListRecords
{
    protected static string $resource = ReportusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
