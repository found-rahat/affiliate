<?php

namespace App\Filament\Resources\CustomerInfoResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\CustomerInfoResource;
use App\Models\CustomerInfo;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ListCustomerInfos extends ListRecords
{
    protected static string $resource = CustomerInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

  public function getTabs(): array
    {
        return [
            'Pending'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Pending')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Pending');
                }),
            'Processing'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Processing')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Processing');
                }),
            'Hold'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Hold')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Hold');
                }),

            'Packing'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Packing')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Packing');
                }),

            'Shipped'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Shipped')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Shipped');
                }),

            'Delivered'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Delivered')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Delivered');
                }),
            'Delivery_Failed'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Delivery_Failed')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Delivery_Failed');
                }),
            'Canceled'=> Tab::make()
                ->badge(CustomerInfo::where('status', 'Canceled')->count())
                ->modifyQueryUsing(function(Builder $query){
                    return $query->where('status','Canceled');
                }),
        ];
    }
}
