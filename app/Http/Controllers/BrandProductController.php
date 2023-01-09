<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use Illuminate\Http\Request;

class BrandProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = BrandProduct::get();
        return view('pages.admin.BrandsProduct.index', [
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
        return view('pages.admin.BrandsProduct.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        BrandProduct::create($request->except('_token'));

        session()->put('message', 'thêm thương hiệu sản phẩm thành công');
        return redirect()->route('brand_product.create');

    }
    public function inactive($brand_product_id)
    {
        $object = BrandProduct::find($brand_product_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'không kích hoạt thương hiệu sản phẩm thành công');
        return redirect()->route('brand_product.index');
    }
    public function active($brand_product_id)
    {
        $object = BrandProduct::find($brand_product_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'kích hoạt thương hiệu sản phẩm thành công');
        return redirect()->route('brand_product.index');
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
        return view('pages.admin.BrandsProduct.edit', [
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

        session()->put('message', 'sửa thương hiệu sản phẩm thành công');
        return redirect()->route('brand_product.index');

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

        session()->put('message', 'xóa thương hiệu sản phẩm thành công');
        return redirect()->route('brand_product.index');

    }
}
