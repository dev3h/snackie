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
        $arrPaymentMethod = PaymentMethodEnum::getArrayView();

        $shipping_info = Customer::query()
            ->join('shippings', 'shippings.id', '=', 'shipping_id')
            ->select('name_receiver', 'phone_receiver', 'address_receiver')
            ->where('customers.id', $customer_id)
            ->get()
            ->first();
        if (!$shipping_info) {
            return view('pages.customer.checkout.index');
        } else {
            $title = 'Thông tin thanh toán';
            return view('pages.customer.checkout.index', [
                'title' => $title,
                'shipping_info' => $shipping_info,
                'arrPaymentMethod' => $arrPaymentMethod,
            ]);
        }
    }
    public function process_checkout(Request $request)
    {

        $shipping = Shipping::create($request->except([
            '_token',
            'method',
            'payment_online',
        ]));

        $shipping_id = $shipping->id;
        $customer_id = session()->get('customer_id');
        session()->put('shipping_id', $shipping_id);

        Customer::query()->where('id', $customer_id)->update([
            'shipping_id' => $shipping_id,
        ]);

        // insert payment
        $payment = Payment::create($request->only([
            'method',
        ]));

        $payment_id = $payment->id;

// insert order
        $carts = session()->get('cart');
        $cart_customer = $carts[$customer_id];

        $total_price = 0;
        foreach ($cart_customer as $item => $value) {
            $total_price += $value['price'] * $value['quantity'];
        }
        $order = Order::create([
            'customer_id' => $customer_id,
            'shipping_id' => $shipping_id,
            'payment_id' => $payment_id,
            'total_price' => $total_price,
        ]);
        $order_id = $order->id;

// insert order detail
        foreach ($cart_customer as $item => $value) {
            OrderDetail::create([
                'order_id' => $order_id,
                'product_id' => $value['id'],
                'quantity' => $value['quantity'],
            ]);
        }

        session()->forget('cart.' . $customer_id);

        if ($request->method == 0) {
            // request get payment_online
            if ($request->payment_online == 'vnpay') {
                return view('pages.customer.checkout.payment_online', [
                    'title' => 'Thanh toán online',
                    'order_id' => $order_id,
                    'total_price' => $total_price,
                ]);
            }
        }

        return view('pages.customer.checkout.cash_payment');

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

    public function processPaymentOnline($request)
    {
        if ($request->paymentOnline && $request->paymentOnline == 'vnpay') {
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            // return về trạng nào
            $vnp_Returnurl = "https://localhost/checkout";
            $vnp_TmnCode = "ACTZ7JV0"; //Mã website tại VNPAY
            $vnp_HashSecret = "EYRECPPXLHLWXKRGQOVTFDIZPVSADUVT"; //Chuỗi bí mật

            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

            $vnp_TxnRef = $_POST['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
            $vnp_OrderInfo = $_POST['order_desc'];
            $vnp_OrderType = $_POST['order_type'];
            $vnp_Amount = str_replace(',', '', $_POST['amount']) * 100;
            $vnp_Locale = $_POST['language'];
            $vnp_BankCode = $_POST['bank_code'];
            $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

            $inputData = array(
                "vnp_Version" => "2.0.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
            );

            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . $key . "=" . $value;
                } else {
                    $hashdata .= $key . "=" . $value;
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
                $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
                $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
            }
            $returnData = array('code' => '00'
                , 'message' => 'success'
                , 'data' => $vnp_Url);
            echo json_encode($returnData);

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
