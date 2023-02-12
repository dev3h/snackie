<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        return view('pages.customer.checkout.index');
    }
    public function process_checkout(Request $request)
    {
        $customer_order = Order::create($request->except('_token'));

        $order_id = $customer_order->id;
        session()->put('order_id', $order_id);
        $cart = Cart::content();
        foreach ($cart as $item) {
            Order_product::create([
                'order_id' => $order_id,
                'product_id' => $item->id,
                'quantity' => $item->qty,
            ]);
        }

    }
}
