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
        $product_qnt = $request->quantity ?? 1;
        $product_id = $request->id;
        $customer_id = session()->get('customer_id');
        $product = Product::find($product_id);

        $cart = session()->get('cart');
        if (isset($cart[$customer_id][$product_id])) {
            $cart[$customer_id][$product_id]['quantity'] += $product_qnt;
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
                'quantity' => $product_qnt,
                'image' => $product->image,
            ];
            session()->put('cart', $cart);
            $res = [
                'status' => 200,
                'message' => "Thêm thành công " . $product->name . ' vào giỏ hàng',
                'data' => sizeof($cart[$customer_id]),
            ];

        }
        echo json_encode($res);
        return false;
    }

    public function update(Request $request)
    {
        $rowId = $request->rowId;
        $qty = $request->qty;
        Cart::update($rowId, $qty);
        return redirect()->route('customer.cart');
    }
    public function delete($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('customer.cart');
    }
}
