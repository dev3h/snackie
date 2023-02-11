<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function login() {
        return view('pages.customer.auth.auth');
    }
    public function register() {
        return view('pages.customer.auth.auth');
    }
    public function processRegister(Request $request) {
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);
        
        session()->put('customer_id', $customer->id);
        session()->put('customer_name', $customer->name);

        return redirect()->back();
    }
}
