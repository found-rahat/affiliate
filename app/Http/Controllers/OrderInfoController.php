<?php

namespace App\Http\Controllers;

use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CuriorServiceProviderCost;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderInfoController extends Controller
{
    use HasFactory;

    public function index(Request $request)
    {
        $user = Auth::user();
        $order_number = $request->query('order_number');

        $query = CustomerInfo::with('orderlist.adminproduct')->where('order_number', $order_number)->get();
        $curior = CuriorServiceProviderCost::get();

        return view('orderinfo', [
            'query' => $query,
            'curior' => $curior,
        ]);
    }
    public function payment(Request $request)
    {
        $user = Auth::user();
        $order_number = $request->query('order_number');

        $query = CustomerInfo::with('orderlist.adminproduct')->where('order_number', $order_number)->get();

        return view('pre', [
            'query' => $query,
        ]);
    }
    public function prepaymentUpdate(Request $request)
    {
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
            return redirect()
                ->route('orderinfo', ['order_number' => $order_number])
                ->with('success', 'Payment/Discount updated successfully!');
        }

        return redirect()->route('user.orderlist')->with('error', 'Nothing to update.');
    }
    public function customerinfoUpdate(Request $request)
    {
        $order_number = $request->input('order_number');

        $amount = null;
        $provider = null;

        if ($request->filled('curior')) {
            $curior = CuriorServiceProviderCost::where('title', $request->curior)->first(); // ✅ use first()

            if ($curior) {
                $amount = $curior->amount;
                $provider = $curior->name;
            }
        }

        $customer = CustomerInfo::where('order_number', $order_number)->firstOrFail();
        if (is_null($amount) || is_null($provider)) {
            $amount = $customer->shipping_fee;
            $provider = $customer->shipping_provider;
        }

        $customer->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone_number,
            'order_note' => $request->note,
            'shipping_fee' => $amount,
            'shipping_provider' => $provider,
        ]);
        return redirect()
            ->route('orderinfo', ['order_number' => $order_number])
            ->with('success', 'Information updated successfully!');
    }
}
