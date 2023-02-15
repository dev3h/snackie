<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Shipping;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $customer_id = session()->get('customer_id');
        $shipping_info = Customer::query()
            ->join('shippings', 'shippings.id', '=', 'shipping_id')
            ->select('name_receiver', 'phone_receiver', 'address_receiver')
            ->where('customers.id', $customer_id)
            ->get()
            ->first();
        if (!$shipping_info) {
            return view('pages.customer.checkout.index');
        } else {
            return view('pages.customer.checkout.index', [
                'shipping_info' => $shipping_info,
            ]);
        }
    }
    public function process_checkout(Request $request)
    {
        $shipping = Shipping::create($request->except('_token'));

        $shipping_id = $shipping->id;
        $customer_id = session()->get('customer_id');
        session()->put('shipping_id', $shipping_id);

        Customer::query()->where('id', $customer_id)->update([
            'shipping_id' => $shipping_id,
        ]);
        return redirect()->route('customer.payment');

    }

    public function payment()
    {
        return view('pages.customer.checkout.payment');
    }

    public function order(Request $request)
    {
        $shipping = Shipping::create($request->except('_token'));

        $shipping_id = $shipping->id;
        $customer_id = session()->get('customer_id');
        session()->put('shipping_id', $shipping_id);

        Customer::query()->where('id', $customer_id)->update([
            'shipping_id' => $shipping_id,
        ]);
        return redirect()->route('customer.payment');
    }
}
