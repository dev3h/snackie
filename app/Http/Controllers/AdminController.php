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

        return (view('pages.admin.dashboard'));
    }
    public function show_dashboard()
    {
        return view('pages.admin.dashboard');
    }
}
