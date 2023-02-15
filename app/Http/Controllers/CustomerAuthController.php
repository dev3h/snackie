<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function login()
    {
        if (session()->has('customer_id')) {
            return redirect()->back();
        }
        return view('pages.customer.auth.auth');
    }
    public function register()
    {
        if (session()->has('customer_id')) {
            return redirect()->back();
        }

        return view('pages.customer.auth.auth');
    }
    public function processLogin(Request $request)
    {
        try {

            $user = Customer::query()->where('email', $request->email)->firstOrFail();

            if (Hash::check($request->password, $user->password) == false) {
                throw new \Exception('Sai mật khẩu');
            }

            session()->put('customer_id', $user->id);
            session()->put('customer_name', $user->name);

            $postData = session()->get('route_waiting_to_login_data');
            $postRoute = session()->get('route_waiting_to_login');


            if ($postRoute) {
                if ($postData) {
                    session()->forget(['route_waiting_to_login_data', 'route_waiting_to_login']);
                    return redirect($postRoute)->withInput($postData)->withMethod('POST');
                }
            }
            return redirect()->route('customer.home');

        } catch (\Throwable $e) {
            return redirect()->route('customer.login')->with('error', $e->getMessage());
        }

    }
    public function processRegister(Request $request)
    {
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        session()->put('customer_id', $customer->id);
        session()->put('customer_name', $customer->name);

        $postData = session('route_waiting_to_login_data');
        $postRoute = session('route_waiting_to_login');

        if (session()->has($postRoute)) {
            if (session()->has($postData)) {
                // redirect route with data and method is post
                session()->forget(['route_waiting_to_login_data', 'route_waiting_to_login']);
                return redirect($postRoute)->withInput($postData);
            }
        }
    }
    public function logout()
    {
        session()->forget(['customer_id', 'customer_name']);
        return redirect()->route('customer.home');
    }
}
