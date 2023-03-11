<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CheckLoginCustomerPageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('customer_id')) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                if ($request->isMethod('post')) {
                    session()->put('route_waiting_to_login_data', $request->all());
                }
                session()->put('route_waiting_to_login', url()->current());
                // redirect to login page with json response

                return response()->json([
                    'status' => '401',
                    'message' => 'Bạn chưa đăng nhập',
                    'redirect' => route('customer.login'),
                ]);
            } else {
                return redirect()->route('login');
            }

        }

    }
}
