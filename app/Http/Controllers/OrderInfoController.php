<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderInfoController extends Controller
{
    use HasFactory;

    public function index(Request $request){

        $user = Auth::user();
        $order_number = $request->query('order_number');

        $query = CustomerInfo::with('orderlist.adminproduct')->where('order_number', $order_number)->get();
        
        return view('orderinfo',[
            'query' => $query,
        ]);
    }

    
}
