<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    private $model;
    private $folderName = 'admin';
    private $asRoute;
    public function __construct()
    {
        $routeName = Route::currentRouteName();
        $arr = explode('.', $routeName);
        $this->asRoute = $arr[0];
        $arr = array_map('ucfirst', $arr);
        $title = implode(' - ', $arr);
        View::share(
            [
                'asRoute' => $this->asRoute,
            ]
        );

    }
    public function index()
    {
        return view('pages.' . $this->folderName . '.admin_login');
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $pass = md5($request->password);

        $result = DB::table('admin')->where('email', $email)->where('password', $pass)->first();
        if ($result) {
            session()->put('admin_name', $result->name);
            session()->put('admin_id', $result->id);

            return redirect()->route($this->asRoute . '.dashboard');
        } else {
            session()->put('message', 'Email hoặc mật khẩu không đúng');
            return redirect()->route($this->asRoute . '.index');
        }
    }
    public function show_dashboard()
    {
        return view('pages.' . $this->folderName . '.dashboard');
    }
    public function logout()
    {
        session()->put('admin_name', null);
        session()->put('admin_id', null);
        return redirect()->route($this->asRoute . '.index');
    }
}
