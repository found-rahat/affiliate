<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\AdminProduct;
use App\Models\CustomerInfo;
use App\Models\OrderListItem;
use App\Models\ShippingProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\CollectProductStockList;
use Filament\Notifications\Notification;

class Shipped extends Component
{
    public $orderNumber;
    // public $pendingOrders = [];
    // public $productIds = [];

    // public $matchedProductImages = [];
    // public $disableOrderInput = false;
    // public $productInputsPending = [];

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
    public function submitOrderNumber(){
        if (!$this->orderNumber) {
            return;
        }

        $order = CustomerInfo::with('items.product')->where('order_number', $this->orderNumber)->first();

        if (!$order) {
            session()->flash('error', "Order '{$this->orderNumber}' not found.");
            $this->dispatch('play-not_found-sound');

            Notification::make()
                ->danger()
                ->title('Not Found')
                ->body("Order '{$this->orderNumber}' not found.")
                ->send();
            return;
        }

        if ($order->status === 'Packing') {
            if ($order->shipped_type === null) {
                $order->shipped_type = 'Pending';
                $order->shipped_time = Carbon::now();
                $order->shipped_user = Auth::user()->name;
                $order->save();

                $this->dispatch('play-confirm-sound');
                session()->flash('success', "Order #{$order->order_number} set to Confirm.");
                Notification::make()
                    ->success()
                    ->title('Order Confirm')
                    ->body("Order #{$order->order_number} set to Confirm.")
                    ->send();
            } else {
                $this->dispatch('play-dublicate-sound');

                session()->flash('error', "Order Number '{$this->orderNumber}' is Duplicate");
                Notification::make()
                    ->danger()
                    ->title('Duplicate Order')
                    ->body("Order Number '{$this->orderNumber}' is Duplicate")
                    ->send();
            }
        } else {
            $this->dispatch('play-not_confirm-sound');
            session()->flash('error', "Order Number '{$this->orderNumber}' is not Packing Confirm.");
            Notification::make()
                ->danger()
                ->title('Order Not Packing')
                ->body("Order Number '{$this->orderNumber}' is not Packing Confirm.")
                ->send();
        }

        $this->orderNumber = '';
        $this->loadOrders();
    }

    public function shippedList(){
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
            $customer->shippment_id = $provider?->id;
            $customer->save();
        }
        if ($provider) {
            $provider->status = 'Confirm';
            $provider->total_product = $orderCount;
            $provider->created_at = Carbon::now();
            $provider->save();
        }


        Notification::make()->success()->title('Products Shipped')->body('Confirmed shipping orders successfully.')->send();
        $this->loadOrders();
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




        // public function confirm(){
    //     $customerinfo = CustomerInfo::where('shipped_type', 'Pending')
    //         ->where('shipped_user', Auth::user()->name)
    //         ->get();

    //     $orderCount = $customerinfo->count();

    //     $provider = ShippingProvider::where('status', 'Pending')
    //         ->where('user_name', Auth::user()->name)
    //         ->latest()
    //         ->first();

    //     foreach ($customerinfo as $customer) {
    //         $customer->shipped_type = 'Confirm';
    //         $customer->status = 'Shipped';
    //         $customer->shippment_id = $provider?->id; // optional chaining in case $provider is null
    //         $customer->save();
    //     }

    //     if ($provider) {
    //         $provider->status = 'Confirm';
    //         $provider->total_product = $orderCount;
    //         $provider->created_at = Carbon::now();
    //         $provider->save();
    //     }

    //     Notification::make()->success()->title('Confirm Orders')->body('Confirmed shipping orders successfully.')->send();

    //     return redirect('admin/shipped-lists');
    // }


    
    // public function mount(){
    //     $this->loadPendingOrders();
    // }

    // public function loadPendingOrders(){
    //     $this->pendingOrders = CustomerInfo::with('items.product')
    //     ->where('packing_type', 'Pending')
    //     ->where('packing_user', Auth::user()->name)
    //     ->latest()
    //     ->get()->toArray();
    // }

    // public function removeOrder($orderId){
    //     $order = CustomerInfo::where('packing_user',Auth::user()->name)->find($orderId);

    //     $orderItems = OrderListItem::where('order_number', $order->order_number)->get();
    //     $product = CollectProductStockList::where('Order_number', $order->order_number)->get();

    //     if ($order) {
    //         $order->packing_time = null;
    //         $order->packing_type = null;
    //         $order->packing_user = null;
    //         $order->save();

    //         $this->loadPendingOrders();
    //         $this->disableOrderInput = false;

    //         session()->flash('success', "Order #{$order->order_number} removed successfully.");
    //         Notification::make()
    //             ->success()
    //             ->title('Order Removed')
    //             ->body("Order #{$order->order_number} removed successfully.")
    //             ->send();

    //         $this->dispatch('focus-order-input');
    //     }

    //     foreach ($orderItems as $item) {
    //         $item->product_code = null;
    //         $item->packing_time = null;
    //         $item->packing_user = null;
    //         $item->order_status = 'Pending';
    //         $item->save();
    //     }

    //     foreach ($product as $items) {
    //         $items->Order_number = null;
    //         $items->packing_time = null;
    //         $items->packing_user = null;
    //         $items->sell_price = null;
    //         $items->stock_status = 'Instock';
    //         $items->save();
    //     }
    // }

    // public function SubmitProductIdlist($itemId){
    //     $productId = $this->productIds[$itemId] ?? null;

    //     if (!$productId) {
    //         session()->flash('error', 'No Product Code Provided.');
    //         return;
    //     }

    //     $orderItem = OrderListItem::find($itemId);
    //     $product = CollectProductStockList::find($productId);

    //     // $adminProduct = AdminProduct::find($product->admin_product_id);
    //     if (!$product) {
    //         unset($this->productIds[$itemId]);
    //         session()->flash('error', "Product ID '{$productId}' not found in stock.");
    //         $this->dispatch('play-not_found-sound');

    //         Notification::make()
    //             ->danger()
    //             ->title('Product Not Found')
    //             ->body("Product ID '{$productId}' not found in stock.")
    //             ->send();
    //         return;
    //     }
    //     if ($product->stock_status === 'sold') {
    //         unset($this->productIds[$itemId]);
    //         session()->flash('error', "Product #{$productId} is already Sold and can't be updated.");
    //         $this->dispatch('play-not_found-sound');

    //         Notification::make()
    //             ->title('Already Sold')
    //             ->danger()
    //             ->body("Product #{$productId} is already Sold and can't be updated.")
    //             ->send();
    //         return;
    //     }

    //     if ($product->admin_product_id) {
    //         $adminProduct = AdminProduct::find($product->admin_product_id);
    //         if ($adminProduct && $adminProduct->image) {
    //             $images = is_array($adminProduct->image) ? $adminProduct->image : json_decode($adminProduct->image, true);

    //             if (is_array($images)) {
    //                 $this->matchedProductImages[$itemId] = $images[0] ?? null;
    //             }
    //         }
    //     }

    //     if ($orderItem) {
    //         $orderItem->product_code = $productId;
    //         $orderItem->packing_time = Carbon::now()->format('Y-m-d H-i-s');
    //         $orderItem->packing_user = Auth::user()->name;
    //         $orderItem->order_status = 'sold';
    //         $orderItem->save();
    //         $this->dispatch('play-set_product_code-sound');
    //         unset($this->productIds[$itemId]);
    //         $this->loadPendingOrders();
    //     }

    //     if ($product) {
    //         $product->Order_number = $orderItem->order_number;
    //         $product->packing_time = Carbon::now()->format('Y-m-d H-i-s');
    //         $product->packing_user = Auth::user()->name;
    //         $product->sell_price = $orderItem->unit_price;
    //         $product->stock_status = 'sold';
    //         $product->save();

    //         $this->dispatch('play-set_product_code-sound');
    //         session()->flash('success', 'Product added successfully.');
    //         Notification::make()->success()->title('Product Added')->body('Product added successfully.')->send();
    //     }

    //     // Remove from pending list
    //     $this->productInputsPending = array_values(array_filter($this->productInputsPending, fn($id) => $id != $itemId));

    //     // Focus on next input or re-enable order input
    //     if (!empty($this->productInputsPending)) {
    //         $this->dispatch('focus-input', id: $this->productInputsPending[0]);
    //     } else {
    //         $this->disableOrderInput = false;
    //         $this->dispatch('focus-order-input');
    //     }
    // }

    // public function clearAll(){
    //     $order = CustomerInfo::where('packing_type','Pending')->where('packing_user',Auth::user()->name)->get();
    //     $orderNumbers = $order->pluck('order_number')->toArray();
    //     $orderItems = OrderListItem::whereIn('order_number',$orderNumbers)->get();
    //     $products = CollectProductStockList::whereIn('Order_number',$orderNumbers)->get();

    //     foreach($order as $orderlist){
    //         $orderlist->packing_type = NULL;
    //         $orderlist->packing_time = NULL;
    //         $orderlist->packing_user = NULL;
    //         $orderlist->save();
    //     }


    //     foreach($orderItems as $orderItemslist){
    //         $orderItemslist->product_code = NULL;
    //         $orderItemslist->packing_time = NULL;
    //         $orderItemslist->packing_user = NULL;
    //         $orderItemslist->order_status='Pending';
    //         $orderItemslist->save();
    //     }
    //     foreach($products as $productlist){
    //         $productlist->stock_status = 'Instock';
    //         $productlist->Order_number = NULL;
    //         $productlist->packing_user = NULL; 
    //         $productlist->packing_time=NULL;
    //         $productlist->sell_price = NULL;
    //         $productlist->save();
    //     }
    //     session()->flash('error', "All Product Removed");
    //     Notification::make()
    //         ->danger()
    //         ->title('Remove All')
    //         ->body("All Product Removed")
    //         ->send();
    //     $this->dispatch('reloadPage');

    // }

    // public function PackingList(){
    //     $customerinfo = CustomerInfo::where('packing_type', 'Pending')
    //         ->where('packing_user', Auth::user()->name)
    //         ->get();

    //     foreach ($customerinfo as $customer) {
    //         $customer->packing_type = 'Confirm';
    //         $customer->status = 'Packing';
    //         $customer->save();
    //     }

    //     Notification::make()->success()->title('Confirm Orders')->body('Confirmed shipping orders successfully.')->send();

    // }


    // // public function shippedList(){
    // //     return redirect('/admin/shipped-list');
    // // }

    // public function render(){
    //     return view('livewire.shipped');
    // }
}
