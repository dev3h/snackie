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
        if (!session()->has('customer_id') ) {
            if($request->isMethod('post')) {
                session()->put('route_waiting_to_login_data', $request->all());
            }
            session()->put('route_waiting_to_login', url()->current());
            return redirect()->route('customer.login');
        }

        return $next($request);
    }
}
