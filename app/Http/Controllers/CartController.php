<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Coupon;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    private $folderName = 'pages.customer.cart.';

    public function index()
    {
        $title = 'Giỏ hàng';
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
        ]);

        return view($this->folderName . 'index', [
            'title' => $title,
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
        ]);

    }

    public function handleSubTotal($cart_customer)
    {
        $sub_total = 0;
        foreach ($cart_customer as $key => $value) {
            if ($key != 'sub_total') {
                $sub_total += $value['price'] * $value['quantity'];
            }
        }

        $cart_customer['sub_total'] = $sub_total;
    }

    public function store(Request $request)
    {
        $product_qty = $request->quantity;
        $product_id = $request->id;
        $customer_id = session()->get('customer_id');
        $product = Product::find($product_id);

        $cart = session()->get('cart');
        $res = [];
        if (isset($cart[$customer_id][$product_id])) {
            $cart[$customer_id][$product_id]['quantity'] += $product_qty;

            // $this->handleSubTotal($cart[$customer_id]);
            $sub_total = 0;
            foreach ($cart[$customer_id] as $key => $value) {
                if ($key != 'sub_total') {
                    $sub_total += $value['price'] * $value['quantity'];
                }
            }

            $cart[$customer_id]['sub_total'] = $sub_total;

            session()->put('cart', $cart);
            $res = [
                'status' => 200,
                'message' => 'Tăng số lượng ' . $product->name . ' thành công',
            ];

        } else {
            $cart[$customer_id][$product_id] = [
                'id' => $product_id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $product_qty,
                'image' => $product->image,
            ];

            session()->put('cart', $cart);
            $res = [
                'status' => 200,
                'message' => "Thêm thành công " . $product->name . ' vào giỏ hàng',
                'data' => sizeof($cart[$customer_id]),
            ];

        }
        return response()->json($res);
    }

    public function update_old(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        return redirect()->route('customer.cart');
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $customer_id = session()->get('customer_id');
        $carts = session()->get('cart');

        if ($type == '0') {

            if ($carts[$customer_id][$id]['quantity'] > 1) {
                $carts[$customer_id][$id]['quantity']--;
            } else {
                session()->forget('cart.' . $customer_id . '.' . $id);
            }
        } else {
            $carts[$customer_id][$id]['quantity']++;
        }

        session()->put('cart', $carts);
        $res = [
            'data' => sizeof($carts[$customer_id]),
        ];
        return response()->json($res);
    }
    public function delete(Request $request)
    {
        $customer_id = session()->get('customer_id');
        $id = $request->id;

        $carts = session()->get('cart');
        session()->forget('cart.' . $customer_id . '.' . $id);

        $res = [
            'data' => sizeof($carts[$customer_id]),
        ];
        return response()->json($res);
    }

    public function deleteItemCartChecked(Request $request)
    {
        $customer_id = session()->get('customer_id');
        $ids = $request->ids;

        $carts = session()->get('cart');
        foreach ($ids as $id) {
            session()->forget('cart.' . $customer_id . '.' . $id);
        }

        $res = [
            'data' => sizeof($carts[$customer_id]),
        ];
        return response()->json($res);
    }

    public function deleteAllCart()
    {
        $customer_id = session()->get('customer_id');
        $carts = session()->get('cart');
        session()->forget('cart.' . $customer_id);
        $customer_id = session()->get('customer_id');
        // delete session coupon with customer
        $coupon_session = session()->get('coupon');
        if ($coupon_session) {
            session()->forget('coupon' . $customer_id);
        }
        $res = [
            'data' => sizeof($carts[$customer_id]),
        ];
        return response()->json($res);
    }

    public function checkCoupon(Request $request)
    {
        $customer_id = session()->get('customer_id');
        $coupon_session = session()->get('coupon' . $customer_id);

        $coupon_code = $request->coupon;
        $coupon = Coupon::where('code', $coupon_code)->first();

        if ($coupon) {
            $count_coupon = $coupon->count();
            if ($count_coupon > 0) {
                // coupon voi customer
                if ($coupon_session == true) {
                    if ($coupon_session[$customer_id]['coupon_code'] != $coupon_code) {
                        // forget session coupon with customer and add new coupon
                        session()->forget('coupon' . $customer_id);
                        $coupon_session[$customer_id] = [
                            'coupon_code' => $coupon->code,
                            'coupon_type' => $coupon->type,
                            'coupon_detail' => $coupon->detail,
                        ];
                        session()->put('coupon', $coupon_session);
                    }
                } else {
                    $coupon_session[$customer_id] = [
                        'coupon_code' => $coupon->code,
                        'coupon_type' => $coupon->type,
                        'coupon_detail' => $coupon->detail,
                    ];
                    session()->put('coupon', $coupon_session);
                }

                $res = [
                    'status' => 200,
                    'message' => 'Mã giảm giá thành công',
                    'data' => $coupon->detail,
                ];
            }
        } else {
            $res = [
                'status' => 400,
                'message' => 'Mã giảm giá không đúng',
                'data' => 0,
            ];
        }
        // $customer_id = session()->get('customer_id');
        // $carts = session()->get('cart');
        // $total = 0;
        // foreach ($carts[$customer_id] as $cart) {
        //     $total += $cart['price'] * $cart['quantity'];
        // }
        // if ($coupon) {
        //     $res = [
        //         'status' => 200,
        //         'message' => 'Mã giảm giá thành công',
        //         'data' => $total * 0.1,
        //     ];
        // }
        return response()->json($res);
    }

    public function unsetCoupon()
    {
        $customer_id = session()->get('customer_id');
        $coupon_session = session()->get('coupon');
        if ($coupon_session) {
            session()->forget('coupon' . $customer_id);
        }
        $res = [
            'status' => 200,
            'message' => 'Xóa mã giảm giá thành công',
        ];
        return response()->json($res);
    }
}
