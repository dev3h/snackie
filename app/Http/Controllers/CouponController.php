<?php

namespace App\Http\Controllers;

use App\Enums\CouponTypeEnum;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class CouponController extends Controller
{
    private $model;
    private $messageName = 'mã giảm giá';
    private $folderName = 'Coupons';
    private $asRoute;
    public function __construct()
    {
        parent::__construct();

        $this->model = (new Coupon())->query();
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $this->asRoute = $arr[0] . '.' . $arr[1];
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);

        $arrCouponType = CouponTypeEnum::getArrayView();

        View::share(
            [
                'messageName' => $this->messageName,
                'asRoute' => $this->asRoute,
                'arrCouponType' => $arrCouponType,
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $brandProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        return view('pages.admin.' . $this->folderName . '.edit', [
            'each' => $coupon,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $coupon->fill($request->except('_token'));
        $coupon->save();

        session()->put('message', 'sửa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        session()->put('message', 'xóa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }
}
