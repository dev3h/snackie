<?php

namespace App\Http\Controllers;

use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = CategoryProduct::get();
        return view('pages.admin.CategoriesProduct.index', [
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.CategoriesProduct.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $object = new CategoryProduct();
        $object->fill($request->except('_token'));
        $object->save();

        session()->put('message', 'thêm danh mục sản phẩm thành công');
        return redirect()->route('category_product.create');
    }

    public function inactive($category_product_id)
    {
        $object = CategoryProduct::find($category_product_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'không kích hoạt danh mục sản phẩm thành công');
        return redirect()->route('category_product.index');
    }
    public function active($category_product_id)
    {
        $object = CategoryProduct::find($category_product_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'kích hoạt danh mục sản phẩm thành công');
        return redirect()->route('category_product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryProduct $categoryProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryProduct $categoryProduct)
    {
        return view('pages.admin.CategoriesProduct.edit', [
            'each' => $categoryProduct,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryProduct $categoryProduct)
    {
        $categoryProduct->fill($request->except('_token'));
        $categoryProduct->save();

        session()->put('message', 'sửa danh mục sản phẩm thành công');
        return redirect()->route('category_product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        //
    }
}
