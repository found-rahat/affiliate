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
    public $pendingOrders = [];
    public $productIds = [];

    public $matchedProductImages = [];
    public $disableOrderInput = false;
    public $productInputsPending = [];

    public function mount(){
        $this->loadPendingOrders();
    }

    public function loadPendingOrders(){
        $this->pendingOrders = CustomerInfo::with('items.product')
        ->where('shipped_type', 'Pending')
        ->where('shipped_user', Auth::user()->name)
        ->latest()
        ->get()->toArray();
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

        if ($order->status === 'Processing') {
            if ($order->shipped_type === null) {
                $order->shipped_type = 'Pending';
                $order->shipped_time = Carbon::now();
                $order->shipped_user = Auth::user()->name;
                $order->save();

                // Clear and rebuild pending orders list
                $this->pendingOrders = CustomerInfo::with('items.product')->where('shipped_type', 'Pending')->latest()->get()->toArray();

                $this->disableOrderInput = true;
                $this->productInputsPending = [];

                // Find all items needing product codes
                foreach ($order->items as $item) {
                    if (empty($item['product_code'])) {
                        $this->productInputsPending[] = $item['id'];
                    }
                }

                // Focus on first empty product input if available
                if (!empty($this->productInputsPending)) {
                    $this->dispatch('focus-input', id: $this->productInputsPending[0]);
                }
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
            session()->flash('error', "Order Number '{$this->orderNumber}' is not Confirm.");
            Notification::make()
                ->danger()
                ->title('Order Not Confirm')
                ->body("Order Number '{$this->orderNumber}' is not Confirm.")
                ->send();
        }

        $this->orderNumber = '';
        $this->loadPendingOrders();
    }

    public function removeOrder($orderId){
        $order = CustomerInfo::where('shipped_user',Auth::user()->name)->find($orderId);

        $orderItems = OrderListItem::where('order_number', $order->order_number)->get();
        $product = CollectProductStockList::where('Order_number', $order->order_number)->get();

        if ($order) {
            $order->shipped_time = null;
            $order->shipped_type = null;
            $order->shipped_user = null;
            $order->save();

            $this->loadPendingOrders();
            $this->disableOrderInput = false;

            session()->flash('success', "Order #{$order->order_number} removed successfully.");
            Notification::make()
                ->success()
                ->title('Order Removed')
                ->body("Order #{$order->order_number} removed successfully.")
                ->send();

            $this->dispatch('focus-order-input');
        }

        foreach ($orderItems as $item) {
            $item->product_code = null;
            $item->packing_time = null;
            $item->packing_user = null;
            $item->order_status = 'Pending';
            $item->save();
        }

        foreach ($product as $items) {
            $items->Order_number = null;
            $items->packing_time = null;
            $items->packing_user = null;
            $items->sell_price = null;
            $items->stock_status = 'Instock';
            $items->save();
        }
    }

    public function SubmitProductIdlist($itemId){
        $productId = $this->productIds[$itemId] ?? null;

        if (!$productId) {
            session()->flash('error', 'No Product Code Provided.');
            return;
        }

        $orderItem = OrderListItem::find($itemId);
        $product = CollectProductStockList::find($productId);

        // $adminProduct = AdminProduct::find($product->admin_product_id);
        if (!$product) {
            session()->flash('error', "Product ID '{$productId}' not found in stock.");
            $this->dispatch('play-not_found-sound');

            Notification::make()
                ->danger()
                ->title('Product Not Found')
                ->body("Product ID '{$productId}' not found in stock.")
                ->send();
            return;
        }
        if ($product->stock_status === 'sold') {
            session()->flash('error', "Product #{$productId} is already Sold and can't be updated.");
            $this->dispatch('play-not_found-sound');

            Notification::make()
                ->title('Already Sold')
                ->danger()
                ->body("Product #{$productId} is already Sold and can't be updated.")
                ->send();
            return;
        }

        if ($product->admin_product_id) {
            $adminProduct = AdminProduct::find($product->admin_product_id);
            if ($adminProduct && $adminProduct->image) {
                $images = is_array($adminProduct->image) ? $adminProduct->image : json_decode($adminProduct->image, true);

                if (is_array($images)) {
                    $this->matchedProductImages[$itemId] = $images[0] ?? null;
                }
            }
        }

        if ($orderItem) {
            $orderItem->product_code = $productId;
            $orderItem->packing_time = Carbon::now()->format('Y-m-d H-i-s');
            $orderItem->packing_user = Auth::user()->name;
            $orderItem->order_status = 'sold';
            $orderItem->save();
            $this->dispatch('play-set_product_code-sound');
            unset($this->productIds[$itemId]);
            $this->loadPendingOrders();
        }

        if ($product) {
            $product->Order_number = $orderItem->order_number;
            $product->packing_time = Carbon::now()->format('Y-m-d H-i-s');
            $product->packing_user = Auth::user()->name;
            $product->sell_price = $orderItem->unit_price;
            $product->stock_status = 'sold';
            $product->save();

            $this->dispatch('play-set_product_code-sound');
            session()->flash('success', 'Product added successfully.');
            Notification::make()->success()->title('Product Added')->body('Product added successfully.')->send();
        }

        // Remove from pending list
        $this->productInputsPending = array_values(array_filter($this->productInputsPending, fn($id) => $id != $itemId));

        // Focus on next input or re-enable order input
        if (!empty($this->productInputsPending)) {
            $this->dispatch('focus-input', id: $this->productInputsPending[0]);
        } else {
            $this->disableOrderInput = false;
            $this->dispatch('focus-order-input');
        }
    }

    public function clearAll(){
        $order = CustomerInfo::where('shipped_type','Pending')->where('shipped_user',Auth::user()->name)->get();
        $orderNumbers = $order->pluck('order_number')->toArray();
        $orderItems = OrderListItem::whereIn('order_number',$orderNumbers)->get();
        $products = CollectProductStockList::whereIn('Order_number',$orderNumbers)->get();

        foreach($order as $orderlist){
            $orderlist->shipped_type = NULL;
            $orderlist->shipped_time = NULL;
            $orderlist->shipped_user = NULL;
            $orderlist->save();
        }


        foreach($orderItems as $orderItemslist){
            $orderItemslist->product_code = NULL;
            $orderItemslist->packing_time = NULL;
            $orderItemslist->packing_user = NULL;
            $orderItemslist->order_status='Pending';
            $orderItemslist->save();
        }
        foreach($products as $productlist){
            $productlist->stock_status = 'Instock';
            $productlist->Order_number = NULL;
            $productlist->packing_user = NULL; 
            $productlist->packing_time=NULL;
            $productlist->sell_price = NULL;
            $productlist->save();
        }
        session()->flash('error', "All Product Removed");
        Notification::make()
            ->danger()
            ->title('Remove All')
            ->body("All Product Removed")
            ->send();
        $this->dispatch('reloadPage');

    }

    public function render(){
        return view('livewire.shipped');
    }
}
