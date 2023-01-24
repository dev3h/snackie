<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;

class HomeController extends Controller
{
    // private $model;
    // private $messageName = 'sản phẩm';
    // private $folderName = 'Products';
    // private $asRoute;
    // public function __construct()
    // {
    //     $this->model = (new Product())->query();
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

    // return home page
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

        // $products = Product::join('category_products', 'category_products.id', '=', 'category_id')
        //     ->join('brand_products', 'brand_products.id', '=', 'brand_id')
        //     ->select('products.*', 'category_products.name as category_name', 'brand_products.name as brand_name')
        //     ->where('products.status', 1)
        //     ->orderBy('products.id', 'desc')
        //     ->get();

        $products = Product::where('status', 1)->orderBy('id', 'desc')->limit(4)->get();

        return view('pages.customer.home', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
            'products' => $products,
        ]);
    }
}
