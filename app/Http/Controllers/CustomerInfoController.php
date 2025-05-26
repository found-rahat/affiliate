<?php

namespace App\Http\Controllers;

use App\Models\AddCart;
use App\Models\CuriorServiceProviderCost;
use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerInfoController extends Controller
{
   
      public function customerinsert(Request $request) {
        $user = Auth::user();
        $grandTotal = 0;
        $grandqty = 0 ;
        
        $cartItems = AddCart::with('product')->where('user_name', $user->name)->get();
        foreach ($cartItems as $item) {
            $price = (float) $item->sell_price;
            $qty = (int) $item->quentity;
            $total = $price * $qty;
            $grandTotal += $total;
            $grandqty += $qty;
        }

        $curior = CuriorServiceProviderCost::where('title',$request->curior)->get();
        foreach ($curior as $cost) {
            $amount = $cost->amount;
            $provider = $cost->name;
        }


        $lastOrder = CustomerInfo::orderBy('order_number', 'desc')->first();
        if ($lastOrder && preg_match('/^Ds(\d+)$/', $lastOrder->order_number, $matches)) {
            $nextNumber = intval($matches[1]) + 125;
        } else{
            $nextNumber = 1; // Start from 1 if no previous order
        }

        // Format to string like Ds0001
        $orderNumber = 'Ds' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
                


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
        ]);
        return back()->with('success', 'Order submitted successfully!');

    }
}
