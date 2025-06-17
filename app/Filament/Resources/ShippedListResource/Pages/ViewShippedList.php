<?php
namespace App\Filament\Resources\ShippedListResource\Pages;

use App\Models\CustomerInfo;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ShippedListResource;

class ViewShippedList extends ViewRecord
{
    protected static string $resource = ShippedListResource::class;

    public function getView(): string
    {
        return 'filament.resources.shipped-list-resource.pages.view-shipped-list';
    }

    protected function getViewData(): array
    {
        return [
            'customerOrders' => CustomerInfo::where('shippment_id', $this->record->id)->get(),
        ];
    }
}
