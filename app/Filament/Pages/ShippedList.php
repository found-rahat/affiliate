<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\CustomerInfo;
use App\Models\ShippingProvider;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class ShippedList extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static string $view = 'filament.pages.shipped-list';
    protected static ?string $title = 'Shipped Orders';
    protected static ?string $slug = 'shipped-list';
    protected static bool $shouldRegisterNavigation = false; // hide from sidebar

    public $orders;

    public $selectedProvider;

    public function mount()
    {
        $this->selectedProvider = '';
        $this->loadOrders();
    }

    public function submitProvider()
    {
        if ($this->selectedProvider) {
            ShippingProvider::create([
                'user_name' => Auth::user()->name,
                'provider_name' => $this->selectedProvider,
            ]);
        }

        $this->loadOrders();
    }
    public function confirm(){
        $customerinfo = CustomerInfo::where('shipped_type', 'Pending')
            ->where('shipped_user', Auth::user()->name)
            ->get();

        $orderCount = $customerinfo->count();

        $provider = ShippingProvider::where('status', 'Pending')
            ->where('user_name', Auth::user()->name)
            ->latest()
            ->first();

        foreach ($customerinfo as $customer) {
            $customer->shipped_type = 'Confirm';
            $customer->status = 'Shipped';
            $customer->shippment_id = $provider?->id; // optional chaining in case $provider is null
            $customer->save();
        }

        if ($provider) {
            $provider->status = 'Confirm';
            $provider->total_product = $orderCount;
            $provider->save();
        }

        Notification::make()->success()->title('Confirm Orders')->body('Confirmed shipping orders successfully.')->send();

        return redirect('admin/shipped-lists');
    }

    public function loadOrders()
    {
        // Only show orders for current logged-in user
        $this->orders = CustomerInfo::where('shipped_type', 'Pending')
            ->where('shipped_user', Auth::user()->name)
            ->latest()
            ->get();
    }
}
