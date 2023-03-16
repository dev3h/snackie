<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    private $folderName = 'pages.customer.cart.';

    public function index()
    {
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
        ]);

        return view($this->folderName . 'index', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
        ]);

    }
    //
    public function store(Request $request)
    {
        $product_qty = $request->quantity;
        $product_id = $request->id;
        $customer_id = session()->get('customer_id');
        $product = Product::find($product_id);

        $cart = session()->get('cart');
        if (isset($cart[$customer_id][$product_id])) {
            $cart[$customer_id][$product_id]['quantity'] += $product_qty;
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
}
