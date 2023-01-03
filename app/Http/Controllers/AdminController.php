<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('pages.admin.admin_login');
    }
    public function login(Request $request)
    {
        $email = $request->email;
        $pass = md5($request->password);

        $result = DB::table('admin')->where('email', $email)->where('password', $pass)->first();
        if ($result) {
            session()->put('admin_name', $result->name);
            session()->put('admin_id', $result->id);

            return redirect()->route('admin.dashboard');
        } else {
            session()->put('message', 'Email hoặc mật khẩu không đúng');
            return redirect()->route('admin.login');
        }
    }
    public function logout()
    {
        session()->put('admin_name', null);
        session()->put('admin_id', null);
        return redirect()->route('admin.login');
    }
    public function show_dashboard()
    {
        return view('pages.admin.dashboard');
    }
}
