<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Shipped extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Order Management';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Shipping Order';

    protected static string $view = 'filament.pages.shipped';

    public static function canAccess(): bool
    {
        return auth()->check() && auth()->user()->hasPermissionTo('Shipped as View');
    }
}
