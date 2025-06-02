<?php

namespace App\Filament\Resources\CustomerInfoResource\Pages;

use App\Filament\Resources\CustomerInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerInfo extends CreateRecord
{
    protected static string $resource = CustomerInfoResource::class;
}
