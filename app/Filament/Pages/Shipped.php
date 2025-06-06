<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Shipped extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.shipped';
}
