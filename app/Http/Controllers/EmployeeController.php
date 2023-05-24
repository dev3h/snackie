<?php

namespace App\Http\Controllers;

use App\Enums\AdminRoleEnum;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class EmployeeController extends Controller
{
    private $model;
    private $messageName = 'tài khoản nhân viên';
    private $folderName = 'Employee';
    private $asRoute;
    public function __construct()
    {
        parent::__construct();

        $this->model = (new Admin())->query();
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
        $arrRole = AdminRoleEnum::getArrayView();
        return view('pages.admin.' . $this->folderName . '.index', [
            'data' => $data,
            'title' => 'Danh sách ' . $this->messageName,
            'arrRole' => $arrRole,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrRole = AdminRoleEnum::getArrayView();
        return view('pages.admin.' . $this->folderName . '.create', [
            'title' => 'Thêm ' . $this->messageName,
            'arrRole' => $arrRole,
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
    public function inactive($admin_id)
    {
        $object = $this->model->find($admin_id);
        $object->status = 0;
        $object->save();
        session()->put('message', 'khóa ' . $this->messageName . ' thành công');

        return redirect()->route($this->asRoute . '.index');
    }
    public function active($admin_id)
    {
        $object = $this->model->find($admin_id);
        $object->status = 1;
        $object->save();
        session()->put('message', 'kích hoạt ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $Admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $employee)
    {
        $arrRole = AdminRoleEnum::getArrayView();
        return view('pages.admin.' . $this->folderName . '.edit', [
            'each' => $employee,
            'arrRole' => $arrRole,
            'title' => 'Sửa ' . $this->messageName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BrandProduct  $brandProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $employee)
    {
        $employee->fill($request->except('_token'));
        $employee->save();

        session()->put('message', 'sửa ' . $this->messageName . ' thành công');
        return redirect()->route($this->asRoute . '.index');

    }
}
