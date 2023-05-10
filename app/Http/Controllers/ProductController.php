<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{
    private $model;
    private $messageName = 'sản phẩm';
    private $folderName = 'Products';
    private $asRoute;
    public function __construct()
    {
        parent::__construct();

        $this->model = (new Product())->query();
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model->join('category_products', 'category_products.id', '=', 'category_id')
            ->join('brand_products', 'brand_products.id', '=', 'brand_id')
            ->select('products.*', 'category_products.name as category_name', 'brand_products.name as brand_name')
            ->orderBy('products.id', 'desc')
            ->get();

        return view('pages.admin.' . $this->folderName . '.index', [
            'data' => $data,
            'title' => 'Danh sách ' . $this->messageName,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories_product = CategoryProduct::orderBy('id', 'desc')->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::orderBy('id', 'desc')->get([
            'id',
            'name',
        ]);
        return view('pages.admin.' . $this->folderName . '.create', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
            'title' => 'Thêm ' . $this->messageName,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $get_image = $request->file('image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $new_name_image = current(explode('.', $get_name_image));
            $new_image = $new_name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/products', $new_image);

            $arr = $request->except('_token');
            $arr['image'] = $new_image;
            $this->model->create($arr);

            session()->put('message', 'thêm ' . $this->messageName . ' thành công');
        } else {
            $arr = $request->except('_token');
            $arr['image'] = '';
            $this->model->create($arr);
            session()->put('message', 'thêm ' . $this->messageName . ' thành công');
        }

        return redirect()->route($this->asRoute . '.create');

    }

    public function inactive($product_id)
    {
        $object = $this->model->find($product_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'không kích hoạt ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }
    public function active($product_id)
    {
        $object = $this->model->find($product_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'kích hoạt ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories_product = CategoryProduct::orderBy('id', 'desc')->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::orderBy('id', 'desc')->get([
            'id',
            'name',
        ]);

        return view('pages.admin.' . $this->folderName . '.edit', [
            'each' => $product,
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
            'title' => 'Sửa ' . $this->messageName,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $get_image = $request->file('image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $new_name_image = current(explode('.', $get_name_image));
            $new_image = $new_name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/products', $new_image);

            $arr = $request->except('_token');
            $arr['image'] = $new_image;
            $product->fill($arr);
            $product->save();

            session()->put('message', 'sửa ' . $this->messageName . ' thành công');

        } else {
            $arr = $request->except('_token');
            $product->fill($arr);
            $product->save();

            session()->put('message', 'sửa ' . $this->messageName . ' thành công');

        }

        return redirect()->route($this->asRoute . '.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->put('message', 'xóa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }

    // end function admin page

    public function detailProduct($slug)
    {
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $details_product = $this->model->join('category_products', 'category_products.id', '=', 'category_id')
            ->join('brand_products', 'brand_products.id', '=', 'brand_id')
            ->select('products.id as product_id', 'products.name as product_name','products.sold as product_sold','products.quantity as product_quantity', 'products.price as product_price', 'products.image as product_image', 'products.slug as product_slug', 'products.description as product_des', 'products.content as product_content', 'products.category_id as product_category_id', 'products.brand_id as product_brand_id', 'category_products.name as category_name', 'brand_products.name as brand_name')
            ->where('products.slug', $slug)
            ->get()
            ->first();
        $title = $details_product->product_name;

        $facebook_share_img = $details_product->product_image;
        $facebook_share_title = $details_product->product_name;
        $facebook_share_description = $details_product->product_description;
        $facebook_share_url = url()->current();

        $category_id = $details_product->product_category_id;
        $brand_id = $details_product->product_brand_id;

        // get related product by category id
        $related_category_products = Product
            ::whereNotIn('slug', [$slug])
            ->where('category_id', $category_id)
            ->get();
        if (count($related_category_products) == 0) {
            $related_brand_products = Product
                ::whereNotIn('slug', [$slug])
                ->where('brand_id', $brand_id)
                ->get();
        }

        $arr = [
            'title' => $title,
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
            'details_product' => $details_product,

            'facebook_share_img' => $facebook_share_img,
            'facebook_share_title' => $facebook_share_title,
            'facebook_share_description' => $facebook_share_description,
            'facebook_share_url' => $facebook_share_url,
        ];
        if (count($related_category_products) > 0) {
            $arr['related_products'] = $related_category_products;
        } elseif (count($related_brand_products) > 0) {
            $arr['related_products'] = $related_brand_products;
        }
        return view('pages.customer.product.detail_product', $arr);
    }
}
