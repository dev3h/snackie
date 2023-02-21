<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    // return home page
    public function index(Request $request)
    {
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
        ]);

        $search = $request->get('q');
        $data = Product::query()
            ->where('status', 1)
            ->where('name', 'like', '%' . $search . '%')
            ->orderBy('id', 'desc')
            ->paginate(4);

        $data->appends(['q' => $search]);
        return view('pages.customer.home', [
            'products' => $data,
            'search' => $search,
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
        ]);

        // $products = Product::join('category_products', 'category_products.id', '=', 'category_id')
        //     ->join('brand_products', 'brand_products.id', '=', 'brand_id')
        //     ->select('products.*', 'category_products.name as category_name', 'brand_products.name as brand_name')
        //     ->where('products.status', 1)
        //     ->orderBy('products.id', 'desc')
        //     ->get();

        // $products = Product::where('status', 1)->orderBy('id', 'desc')->limit(4)->get();

        // return view('pages.customer.home', [
        //     'categories_product' => $categories_product,
        //     'brands_product' => $brands_product,
        //     'products' => $products,
        // ]);
    }
}
