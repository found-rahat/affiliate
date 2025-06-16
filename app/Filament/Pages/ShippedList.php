<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\CustomerInfo;
use Illuminate\Support\Facades\Auth;

class ShippedList extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static string $view = 'filament.pages.shipped-list';
    protected static ?string $title = 'Shipped Orders';
    protected static ?string $slug = 'shipped-list';
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar

    public $orders;

    public function mount()
    {
        // Only show orders for current logged-in user
        $this->orders = CustomerInfo::where('shipped_type', 'Pending')
            ->where('shipped_user', Auth::user()->name)
            ->latest()
            ->get();
    }
}
