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
    // private $model;
    // private $messageName = 'danh mục sản phẩm';
    // private $folderName = 'CategoriesProduct';
    // private $asRoute;
    // public function __construct()
    // {
    //     $this->model = (new Cart())->query();
    //     $routeName = Route::currentRouteName();
    //     $arr = explode('.', $routeName);
    //     $this->asRoute = $arr[0];
    //     $arr = array_map('ucfirst', $arr);
    //     $title = implode(' - ', $arr);
    //     View::share(
    //         [
    //             'messageName' => $this->messageName,
    //             'asRoute' => $this->asRoute,
    //         ]
    //     );

    // }
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

        return view($this->folderName .'show_cart', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
        ]);

    }
    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->qty;

        $product_data = Product::where('id', $product_id)->first();

        $data['id'] = $product_data->id;
        $data['qty'] = $quantity;
        $data['name'] = $product_data->name;
        $data['price'] = $product_data->price;
        $data['weight'] = '0';
        $data['options']['image'] = $product_data->image;
        Cart::add($data);
        // set tax 10%
        Cart::setGlobalTax(10);


        return redirect()->route('customer.cart');

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
