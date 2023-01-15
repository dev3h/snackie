<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::get();
        return view('pages.admin.Products.index', [
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
        $categories_product = CategoryProduct::orderBy('id', 'desc')->get();
        $brands_product = BrandProduct::orderBy('id', 'desc')->get();
        return view('pages.admin.Products.create', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
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
            Product::create($arr);

            session()->put('message', 'thêm sản phẩm thành công');
        } else {
            $arr = $request->except('_token');
            $arr['image'] = '';
            Product::create($arr);
            session()->put('message', 'thêm sản phẩm thành công');
        }

        return redirect()->route('product.create');

    }

    public function inactive($product_id)
    {
        $object = Product::find($product_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'không kích hoạt sản phẩm thành công');
        return redirect()->route('product.index');
    }
    public function active($product_id)
    {
        $object = Product::find($product_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'kích hoạt sản phẩm thành công');
        return redirect()->route('product.index');
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
        return view('pages.admin.Products.edit', [
            'each' => $product,
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
        $product->fill($request->except('_token'));
        $product->save();

        session()->put('message', 'sửa sản phẩm thành công');
        return redirect()->route('product.index');

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

        session()->put('message', 'xóa sản phẩm thành công');
        return redirect()->route('product.index');

    }
}
