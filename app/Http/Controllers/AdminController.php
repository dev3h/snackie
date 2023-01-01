<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('pages.admin.admin_login');
    }
    public function show_dashboard() {
        return view('admin_layout');
    }
}
