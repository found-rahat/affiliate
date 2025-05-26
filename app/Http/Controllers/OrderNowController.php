<?php

namespace App\Http\Controllers;

use App\Models\AddCart;
use App\Models\AdminProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderNowController extends Controller
{
    public function buynow()
    {
        $user = Auth::user();

        $cartItems = AddCart::with('product')->where('user_name', $user->name)->get();
        return view('addtocard', compact('cartItems'));

    }

    public function updateCart(Request $request)
    {
        $quantities = $request->input('quantities');
        $prices = $request->input('prices');

        foreach ($quantities as $cartId => $qty) {
            $price = isset($prices[$cartId]) ? $prices[$cartId] : null;

            AddCart::where('id', $cartId)->update([
                'quentity' => intval($qty),
                'sell_price' => floatval($price),
            ]);
        }

        return redirect()->route('user.addviewclick')->with('success', 'Cart updated successfully!');
    }

    public function ordernow()
    {
         $product_list = AdminProduct::where('status', '1')->get();
        return view('ordernow', [
            'product_lists' => $product_list,
        ]);
    }

    public function productview(Request $request)
    {
        $id = $request->query('id'); // Get the ?id=5 from URL

        $product = AdminProduct::findOrFail($id);

        return view('productview', compact('product'));
    }

    public function addtocard(Request $request)
    {
        $user = Auth::user();
        AddCart::insert([
            'user_name' => $user->name,
            'product_id' => $request->product_id,
            'sell_price' => $request->sell_price,
            'quentity' => $request->quentity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('user.addviewclick')->with('success', 'Add to Card has been successfully.');
    }

    public function addviewclick(Request $request)
    {
        $id = $request->input('id');
        $user = Auth::user();
        $product = AdminProduct::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        AddCart::insert([
            'user_name' => $user->name,
            'product_id' => $id,
            'sell_price' => $product->sell_price,
            'quentity' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('user.ordernow')->with('success', 'Add to Cart has been successfully.');
    }

    public function addcarddelete($id){
        $cartItem = AddCart::find($id);

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found.');
    }
}
