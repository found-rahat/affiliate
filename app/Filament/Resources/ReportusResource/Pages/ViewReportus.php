<?php

namespace App\Filament\Resources\ReportusResource\Pages;

use App\Filament\Resources\ReportusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReportus extends ViewRecord
{
    protected static string $resource = ReportusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
