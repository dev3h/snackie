<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{

    // return home page
    public function index(Request $request, $slug = null)
    {
        $title = 'Trang chủ';
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
            'slug',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
            'slug',
        ]);
        session()->forget('cart');

        $search = $request->get('q');

        $data_filer = Product::query()
            ->join('category_products', 'category_products.id', '=', 'category_id')
            ->join('brand_products', 'brand_products.id', '=', 'brand_id')
            ->select('products.id as product_id', 'products.name as product_name', 'products.price as product_price', 'products.image as product_image', 'products.slug as product_slug', 'category_products.name as category_name', 'category_products.slug as category_slug', 'brand_products.name as brand_name', 'brand_products.slug as brand_slug')
            ->where('products.status', 1)
            ->where('products.name', 'like', '%' . $search . '%')
            ->orderBy('products.id', 'desc');

        if (Route::currentRouteName() == 'customer.category_product_selected') {
            $data = $data_filer
                ->where('category_products.slug', $slug)
                ->paginate(4);
            $category_name = CategoryProduct::where('slug', $slug)->first()->name;
            dd($category_name);
            $title = 'Danh mục sản phẩm: ' . $category_name;

        } elseif (Route::currentRouteName() == 'customer.brand_product_selected') {
            $data = $data_filer
                ->where('brand_products.slug', $slug)
                ->paginate(4);
            $brand_name = BrandProduct::where('slug', $slug)->first()->name;
            $title = 'Thương hiệu sản phẩm: ' . $brand_name;
        } else {
            $data = Product::query()
                ->select('products.id as product_id', 'products.name as product_name', 'products.price as product_price', 'products.image as product_image', 'products.slug as product_slug')
                ->where('status', 1)
                ->where('name', 'like', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->paginate(4);
        }

        $data->appends(['q' => $search]);
        return view('pages.customer.home', [
            'title' => $title,
            'products' => $data,
            'search' => $search,
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
        ]);
    }
}
