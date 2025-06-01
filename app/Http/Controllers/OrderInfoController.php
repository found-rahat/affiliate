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
    public function payment(Request $request){
       $user = Auth::user();
        $order_number = $request->query('order_number');

        $query = CustomerInfo::with('orderlist.adminproduct')->where('order_number', $order_number)->get();
        
        return view('pre',[
            'query' => $query,
        ]);
        
    }
    public function prepaymentUpdate(Request $request){

        $user = Auth::user();
        $order_number = $request->input('order_number');

        $customer = CustomerInfo::where('order_number', $order_number)->firstOrFail();

        $dataToUpdate = [];

        if ($request->filled('pre_payment')) {
            $dataToUpdate['pre_payment'] = $request->input('pre_payment');
            $dataToUpdate['pre_payment_user'] = $user->name;
        }

        if ($request->filled('discount')) {
            $dataToUpdate['discount'] = $request->input('discount');
            $dataToUpdate['discount_user'] = $user->name;
        }

        if (!empty($dataToUpdate)) {
            $customer->update($dataToUpdate);
            return redirect()->route('user.orderlist')->with('success', 'Payment/Discount updated successfully!');
        }

        return redirect()->route('user.orderlist')->with('error', 'Nothing to update.');
    }
    
}
