<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\CustomerInfo;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status');

        $query = CustomerInfo::with('orderlist.adminproduct')->where('user_id', $user->id)->where('status','Pending');

        if (!empty($status)) {
            $query = CustomerInfo::with('orderlist.adminproduct')->where('user_id', $user->id)->where('status',$status);
        }

        $customerInfos = $query->get();
        // ---------------------order list button -------------------
        $pendingOrder = CustomerInfo::where('user_id', $user->id)->where('status','Pending')->count();
        $ProcessingOrder = CustomerInfo::where('user_id', $user->id)->where('status','Processing')->count();
        $HoldOrder = CustomerInfo::where('user_id', $user->id)->where('status','Hold')->count();
        $PackingOrder = CustomerInfo::where('user_id', $user->id)->where('status','Packing')->count();
        $ShippedOrder = CustomerInfo::where('user_id', $user->id)->where('status','Shipped')->count();
        $DeliveredOrder = CustomerInfo::where('user_id', $user->id)->where('status','Delivered')->count();
        $Delivery_FailedOrder = CustomerInfo::where('user_id', $user->id)->where('status','Delivery_Failed')->count();
        $CanceledOrder = CustomerInfo::where('user_id', $user->id)->where('status','Canceled')->count();
        $UnpaidOrder = CustomerInfo::where('user_id', $user->id)->where('status','Unpaid')->count();

        return view('orderlist', [
            'customerInfo' => $customerInfos,
            'pendingOrder'=> $pendingOrder,
            'ProcessingOrder'=> $ProcessingOrder,
            'HoldOrder'=> $HoldOrder,
            'PackingOrder'=> $PackingOrder,
            'ShippedOrder'=> $ShippedOrder,
            'DeliveredOrder'=> $DeliveredOrder,
            'Delivery_FailedOrder'=> $Delivery_FailedOrder,
            'CanceledOrder'=> $CanceledOrder,
            'UnpaidOrder'=> $UnpaidOrder,
        ]);
    }
}
