<?php

namespace App\Http\Controllers;

use App\Models\AdminProduct;
use App\Models\CustomerInfo;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderListController extends Controller
{
    public function index(){

        $user = Auth::user();
        $customerInfos = CustomerInfo::with('orderlist.adminproduct')
        ->where('user_id', $user->id)
        ->get();

        return view('orderlist',[
            'customerInfo' => $customerInfos,
        ]);
        // return view('orderlist');s
    }

}
