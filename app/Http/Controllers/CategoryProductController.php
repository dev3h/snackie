<?php

namespace App\Http\Controllers;

use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class CategoryProductController extends Controller
{
    private $model;
    private $messageName = 'danh mục sản phẩm';
    private $folderName = 'CategoriesProduct';
    private $asRoute;
    public function __construct()
    {
        parent::__construct();

        $this->model = (new CategoryProduct())->query();
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
        // $data = $this->model->orderBy('id', 'desc')->get();
        // return view('pages.admin.' . $this->folderName . '.index', [
        //     'data' => $data,
        //     'title' => 'Danh sách ' . $this->messageName,
        // ]);
        return view('pages.admin.' . $this->folderName . '.index', [
            'title' => 'Danh sách ' . $this->messageName,
        ]);
    }

    public function api()
    {
        return DataTables::of($this->model)
            ->editColumn('status', function ($object) {
                if ($object->status == 1) {
                    return route('admin.category_product.inactive', $object->id);
                }
                return route('admin.category_product.active', $object->id);
            })
            ->addColumn('edit', function ($object) {
                return route('admin.category_product.edit', $object);
            })
            ->addColumn('destroy', function ($object) {
                return route('admin.category_product.destroy', $object);
            })
            ->rawColumns(['edit'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.' . $this->folderName . '.create', [
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
        $this->model->create($request->except('_token'));

        session()->put('message', 'thêm ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.create');
    }

    public function inactive($category_product_id)
    {
        $object = $this->model->find($category_product_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'không kích hoạt ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');
    }
    public function active($category_product_id)
    {
        $object = $this->model->find($category_product_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'kích hoạt ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');
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
        return view('pages.admin.' . $this->folderName . '.edit', [
            'each' => $categoryProduct,
            'title' => 'Sửa ' . $this->messageName,
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

        session()->put('message', 'sửa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryProduct  $categoryProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryProduct $categoryProduct)
    {
        $categoryProduct->delete();

        $arr = [];
        $arr['message'] = 'xóa ' . $this->messageName . ' thành công';
        $arr['status'] = true;
        return response()->json($arr);

    }

    // end function admin page

    public function showProductsByCategoryId($category_product_id)
    {
        $categories_product = CategoryProduct::where('status', 1)->get([
            'id',
            'name',
        ]);
        $brands_product = BrandProduct::where('status', 1)->get([
            'id',
            'name',
        ]);

        $products = Product::where('category_id', $category_product_id)->where('status', 1)->orderBy('id', 'desc')->limit(4)->get();
        $category_product_name = CategoryProduct::where('id', $category_product_id)->first()->name;

        return view('pages.customer.product.productByCategory', [
            'categories_product' => $categories_product,
            'brands_product' => $brands_product,
            'products' => $products,
            'category_product_name' => $category_product_name,
        ]);
    }
}
