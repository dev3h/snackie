<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        $title = 'Thông tin thanh toán';

        $customer_id = session()->get('customer_id');
        $arrPaymentMethod = PaymentMethodEnum::getArrayView();

        $shipping_info = Customer::query()
            ->join('shippings', 'shippings.id', '=', 'shipping_id')
            ->select('name_receiver', 'phone_receiver', 'address_receiver')
            ->where('customers.id', $customer_id)
            ->get()
            ->first();
        if (!$shipping_info) {
            return view('pages.customer.checkout.index', [
                'title' => $title,
                'arrPaymentMethod' => $arrPaymentMethod,
            ]);
        } else {

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
            // if ($request->payment_online == 'vnpay') {
            //     return view('pages.customer.checkout.payment_online', [
            //         'title' => 'Thanh toán online',
            //         'order_id' => $order_id,
            //         'total_price' => $total_price,
            //     ]);
            // }
            if ($request->payment_online == 'vnpay') {
                return redirect()->route('customer.payment_online', [
                    'order_id' => $order_id,
                    'total_price' => $total_price,
                ]);

            }
        }

        return view('pages.customer.checkout.complete');

    }

    public function checkoutOnline(Request $request)
    {
        $order_id = $request->order_id;
        $total_price = $request->total_price;
        //return view('pages.customer.checkout.payment_online');
        return view('pages.customer.checkout.vnpay.vnpay_pay', [
            'title' => 'Thanh toán online',
            'order_id' => $order_id,
            'total_price' => $total_price,
        ]);
    }

    public function handleVnpayCreatePayment(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TmnCode = "ACTZ7JV0"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "EYRECPPXLHLWXKRGQOVTFDIZPVSADUVT"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/vnpay_php/vnpay_return.php";
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
//Config input format
        //Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        $vnp_TxnRef = rand(1, 10000); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $request->amount; // Số tiền thanh toán
        $vnp_Locale = $request->language; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = $request->bankCode; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire,
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
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();

    }

    // public function payment()
    // {
    //     $arrPaymentMethod = PaymentMethodEnum::getArrayView();

    //     return view('pages.customer.checkout.payment', [
    //         'arrPaymentMethod' => $arrPaymentMethod,
    //     ]);
    // }

    // public function order(Request $request)
    // {
    //     // insert payment
    //     $payment = Payment::create($request->except('_token'));

    //     $payment_id = $payment->id;

    //     // insert order
    //     $customer_id = session()->get('customer_id');
    //     $shipping_id = session()->get('shipping_id');
    //     $total_price = Cart::total(0, '.', '');
    //     $order = Order::create([
    //         'customer_id' => $customer_id,
    //         'shipping_id' => $shipping_id,
    //         'payment_id' => $payment_id,
    //         'total_price' => $total_price,
    //     ]);
    //     $order_id = $order->id;

    //     // insert order detail
    //     $cart = Cart::content();
    //     foreach ($cart as $item) {
    //         OrderDetail::create([
    //             'order_id' => $order_id,
    //             'product_id' => $item->id,
    //             'quantity' => $item->qty,
    //         ]);
    //     }

    //     if ($payment->method == 0) {
    //         echo "Thanh toán bằng thẻ tín dụng";
    //     } else if ($payment->method == 1) {
    //         Cart::destroy();
    //         return view('pages.customer.checkout.cash_payment');
    //     } else {
    //         echo "Thanh toán bằng thẻ ghi nợ";
    //     }
    // }

    // admin function
    public function index()
    {
        $orders = Order::query()->join('customers', 'customers.id', '=', 'customer_id')
            ->select('orders.*', 'customers.name as customer_name')
            ->orderBy('orders.id', 'desc')
            ->get();

        return view('pages.admin.' . $this->folderName . '.index', [
            'orders' => $orders,
            'title' => 'Danh sách ' . $this->messageName,
        ]);
    }
    public function show(Order $order)
    {
        $order_by_id = Order::query()->join('customers', 'customers.id', '=', 'customer_id')
            ->select('orders.*', 'customers.name as customer_name', 'customers.phone as customer_phone')
            ->where('orders.id', $order->id)
            ->where('customers.id', $order->customer_id)
            ->first();

        $order_shipping = Order::query()->join('shippings', 'shippings.id', '=', 'shipping_id')
            ->join('payments', 'payments.id', '=', 'payment_id')
            ->join('customers', 'customers.id', '=', 'customer_id')
            ->select('shippings.*', 'payments.method as payment_method')
            ->where('orders.id', $order->id)
            ->where('customers.id', $order->customer_id)
            ->where('shippings.id', $order->shipping_id)
            ->first();
        $paymentMethod = PaymentMethodEnum::getKeyByValue($order_shipping->payment_method);

        $order_products = OrderDetail::query()->join('products', 'products.id', '=', 'product_id')
            ->select('products.name as product_name', 'products.quantity as product_quantity', 'products.price as product_price', 'order_details.quantity as order_quantity')
            ->where('order_id', $order->id)
            ->get();
        $arrOrderStatus = OrderStatusEnum::getArrayView();

        return view('pages.admin.' . $this->folderName . '.show', [
            'order_by_id' => $order_by_id,
            'order_products' => $order_products,
            'arrOrderStatus' => $arrOrderStatus,
            'paymentMethod' => $paymentMethod,
            'order_shipping' => $order_shipping,
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
    public function update(Request $request, Order $order)
    {
        $order->status = $request->status;
        $order->save();

        // if order status is 3, update sold in product table and minus quantity in product table
        if ($order->status == 3) {
            $order_details = OrderDetail::query()->where('order_id', $request->order_id)->get();
            foreach ($order_details as $order_detail) {
                $product = Product::query()->where('id', $order_detail->product_id)->first();
                $product->sold = $product->sold + $order_detail->quantity;
                $product->quantity = $product->quantity - $order_detail->quantity;
                $product->save();
            }
        }

        return redirect()->route('admin.order.index')->with('success', 'Cập nhật đơn hàng thành công');
    }

    public function complete()
    {
        return view('pages.customer.checkout.complete');
    }

    public function printOrder($order_id)
    {
        $order = Order::query()->where('id', $order_id)->first();

        $order_shipping = Order::query()->join('shippings', 'shippings.id', '=', 'shipping_id')
            ->join('payments', 'payments.id', '=', 'payment_id')
            ->join('customers', 'customers.id', '=', 'customer_id')
            ->select('shippings.*', 'payments.method as payment_method')
            ->where('orders.id', $order_id)
            ->where('customers.id', $order->customer_id)
            ->where('shippings.id', $order->shipping_id)
            ->first();
        $paymentMethod = PaymentMethodEnum::getKeyByValue($order_shipping->payment_method);

        $order_products = OrderDetail::query()->join('products', 'products.id', '=', 'product_id')
            ->select('products.name as product_name', 'products.quantity as product_quantity', 'products.price as product_price', 'order_details.quantity as order_quantity')
            ->where('order_id', $order_id)
            ->get();

        $data = [
            'order' => $order,
            'order_shipping' => $order_shipping,
            'paymentMethod' => $paymentMethod,
            'order_products' => $order_products,
        ];
        $pdf = Pdf::loadView('pages.admin.Orders.preview_pdf', $data);
        return $pdf->download('custom.pdf');

    }
}
