<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class BrandProductController extends Controller
{
    private $model;
    private $messageName = 'thương hiệu sản phẩm';
    private $folderName = 'BrandsProduct';
    private $asRoute;
    public function __construct()
    {
        parent::__construct();

        $this->model = (new BrandProduct())->query();
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
        $data = $this->model->orderBy('id', 'desc')->get();
        return view('pages.admin.' . $this->folderName . '.index', [
            'data' => $data,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.' . $this->folderName . '.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->model->create($request->except('_token'));

        session()->put('message', 'thêm ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.create');

    }
    public function inactive($brand_product_id)
    {
        $object = $this->model->find($brand_product_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'không kích hoạt ' . $this->messageName . ' thành công');

        return redirect()->route($this->asRoute . '.index');
    }
    public function active($brand_product_id)
    {
        $object = $this->model->find($brand_product_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'không kích hoạt ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function show(BrandProduct $brandProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(BrandProduct $brandProduct)
    {
        return view('pages.admin.' . $this->folderName . '.edit', [
            'each' => $brandProduct,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BrandProduct $brandProduct)
    {
        $brandProduct->fill($request->except('_token'));
        $brandProduct->save();

        session()->put('message', 'sửa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(BrandProduct $brandProduct)
    {
        $brandProduct->delete();

        session()->put('message', 'xóa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }

    // end function admin page

    public function showProductsByBrandId($brand_product_id)
    {
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
        ]);

        $products = Product::where('brand_id', $brand_product_id)->where('status', 1)->orderBy('id', 'desc')->limit(4)->get();
        $brand_product_name = BrandProduct::where('id', $brand_product_id)->first()->name;

        return view('pages.customer.product.productByBrand', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
            'products' => $products,
            'brand_product_name' => $brand_product_name,
        ]);
    }
}
