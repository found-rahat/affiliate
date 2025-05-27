<?php

namespace App\Http\Controllers;

use App\Models\AddCart;
use App\Models\AdminProduct;
use App\Models\CuriorServiceProviderCost;
use App\Models\CustomerInfo;
use App\Models\OrderList;
use App\Models\OrderListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerInfoController extends Controller
{
    public function customerinsert(Request $request)
    {
        $user = Auth::user();
        $grandTotal = 0;
        $grandqty = 0;

        $cartItems = AddCart::with('product')->where('user_name', $user->name)->get();
        foreach ($cartItems as $item) {
            $price = (float) $item->sell_price;
            $qty = (int) $item->quentity;
            $total = $price * $qty;
            $grandTotal += $total;
            $grandqty += $qty;
        }

        $curior = CuriorServiceProviderCost::where('title', $request->curior)->get();
        foreach ($curior as $cost) {
            $amount = $cost->amount;
            $provider = $cost->name;
        }

        //---------------------order number generate--------------------------------
        $lastOrder = CustomerInfo::orderBy('order_number', 'desc')->first();
        if ($lastOrder && preg_match('/^Ds(\d+)$/', $lastOrder->order_number, $matches)) {
            $nextNumber = intval($matches[1]) + 125;
        } else {
            $nextNumber = 1;
        }

        $orderNumber = 'Ds' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        // ----------------------Customer Info insert------------------------
        CustomerInfo::insert([
            'user_id' => $user->id,
            'order_number' => $orderNumber,
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone_number,
            'item_quentity' => $grandqty,
            'total_paid' => $grandTotal,
            'order_create_time' => now(),
            'shipping_fee' => $amount,
            'shipping_provider' => $provider,
            'order_note' => $request->note,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ------------------------order list insert----------------------
        foreach ($cartItems as $item) {
            $admin_products = AdminProduct::where('id', $item->product->id)->first();
            $customer_info_id = CustomerInfo::orderBy('id', 'desc')->first();
            $customer_info = $customer_info_id->id;

            $price = (float) $item->sell_price;
            $qty = (int) $item->quentity;
            $total = $price * $qty;

            OrderList::insert([
                'user_id' => $user->id,
                'product_id' => $item->product->id,
                'customer_info_id' => $customer_info,
                'order_number' => $orderNumber,
                'order_create_time' => now(),
                'item_price' => $admin_products->sell_price,
                'item_quentity' => $qty,
                'unit_price' => $price,
                'paid_price' => $total,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // ----------------order list item insert--------------------
            for ($i = 0; $i < $qty; $i++) {
                $order_list_id = OrderList::orderBy('id', 'desc')->first();
                $order_list = $order_list_id->id;
                OrderListItem::insert([
                    'user_id' => $user->id,
                    'product_id' => $item->product->id,
                    'customer_info_id' => $customer_info,
                    'order_list_id' => $order_list,
                    'order_number' => $orderNumber,
                    'order_create_time' => now(),
                    'item_price' => $admin_products->sell_price,
                    'unit_price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        // ----------------Add to Cart Delete--------------------
        AddCart::where('user_name', $user->name)->delete();
        
        return redirect()->route('user.orderlist')->with('success', 'Order submitted successfully!');
    }
}
