<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethodEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Shipping;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CheckoutController extends Controller
{
    private $model;
    private $messageName = 'đơn hàng';
    private $folderName = 'Orders';
    private $asRoute;
    public function __construct()
    {
        $this->model = (new Order())->query();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $this->asRoute = $arr[0] . '.' . $arr[1];
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);
        View::share(
            [
                'messageName' => $this->messageName,
                'asRoute' => $this->asRoute,
            ]
        );
    }
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
        $arrPaymentMethod = PaymentMethodEnum::getArrayView();

        return view('pages.customer.checkout.payment', [
            'arrPaymentMethod' => $arrPaymentMethod,
        ]);
    }

    public function order(Request $request)
    {
        // insert payment
        $payment = Payment::create($request->except('_token'));

        $payment_id = $payment->id;

        // insert order
        $customer_id = session()->get('customer_id');
        $shipping_id = session()->get('shipping_id');
        $total_price = Cart::total(0, '.', '');
        $order = Order::create([
            'customer_id' => $customer_id,
            'shipping_id' => $shipping_id,
            'payment_id' => $payment_id,
            'total_price' => $total_price,
        ]);
        $order_id = $order->id;

        // insert order detail
        $cart = Cart::content();
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order_id,
                'product_id' => $item->id,
                'quantity' => $item->qty,
            ]);
        }

        if ($payment->method == 0) {
            echo "Thanh toán bằng thẻ tín dụng";
        } else if ($payment->method == 1) {
            Cart::destroy();
            return view('pages.customer.checkout.cash_payment');
        } else {
            echo "Thanh toán bằng thẻ ghi nợ";
        }
    }

    // admin function
    public function index()
    {
        $orders = Order::query()->join('customers', 'customers.id', '=', 'customer_id')
            ->select('orders.*', 'customers.name as customer_name')
            ->orderBy('orders.id', 'desc')
            ->get();

        return view('pages.admin.' . $this->folderName . '.index', [
            'orders' => $orders,
        ]);
    }
    public function show(Order $order)
    {
        $order_by_id = Order::query()->join('customers', 'customers.id', '=', 'customer_id')
        ->join('shippings', 'shippings.id', '=', 'orders.shipping_id')
        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select('orders.*', 'customers.name as customer_name', 'customers.phone as customer_phone', 'shippings.*')
            ->where('orders.id', $order->id)
            ->get()
            ->first();
            
        $order_products = OrderDetail::query()->join('products', 'products.id', '=', 'product_id')
            ->select('products.*', 'order_details.quantity')
            ->where('order_id', $order->id)
            ->get();
        

        return view('pages.admin.' . $this->folderName . '.show', [
            'order_by_id' => $order_by_id,
            'order_products' => $order_products,
        ]);

    }
    public function destroy()
    {
        $orders = Order::query()->join('customers', 'customers.id', '=', 'customer_id')
            ->select('orders.*', 'customers.name as customer_name')
            ->orderBy('orders.id', 'desc')
            ->get();

        return view('pages.admin.' . $this->folderName . '.index', [
            'orders' => $orders,
        ]);
    }
}
