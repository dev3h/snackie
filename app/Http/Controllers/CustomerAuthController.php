<?php

namespace App\Http\Controllers;

use App\Events\UserRegisteredEvent;
use App\Models\Customer;
use App\Models\Social;
use App\Rules\CapchaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; //sử dụng model Login
use Laravel\Socialite\Facades\Socialite;

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
        if (auth()->check()) {
            $customer = Customer::query()->where('id', auth()->id())->update([
                'password' => Hash::make($request->password),
            ]);
        } else {
            // check captcha
            // $request->validate([
            //     'g-recaptcha-response' => new CapchaRule(),
            // ]);

            $customer = Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
        }

        session()->put('customer_id', $customer->id);
        session()->put('customer_name', $customer->name);

        $postData = session()->get('route_waiting_to_login_data');
        $postRoute = session()->get('route_waiting_to_login');

        if ($postRoute != null) {
            if ($postData != null) {
                // redirect route with data and method is post
                session()->forget(['route_waiting_to_login_data', 'route_waiting_to_login']);
                return redirect($postRoute)->withInput($postData);
            }
        } else {
            UserRegisteredEvent::dispatch($customer);
            return redirect()->route('customer.home');
        }

    }
    public function logout()
    {
        session()->forget(['customer_id', 'customer_name']);
        return redirect()->route('customer.home');
    }

    // ! phần này học bài authen bài 99 sẽ quay lại bài 58 để sửa lại cái belongsTo
    public function callback($provider)
    {
        // login thành công thì trả lại user của github
        $data = Socialite::driver($provider)->user();
        // dd($data->getId());
        // $user = Customer::firstOrCreate([
        //     'email' => $data->getEmail(),
        // ], [
        //     'name' => $data->getName(),
        //     'email' => $data->getEmail(),
        //     // 'avatar' => $data->getAvatar(),
        // ]
        // );

        // Auth::login($user);

        $account = Social::where('provider_user_id', $data->getId())->first();

        if ($account) {
            $user = $account->customer;

            Auth::login($user);

            session()->put('customer_id', $user->id);
            session()->put('customer_name', $user->name);

            return redirect()->route('customer.home');
        } else {
            // $user = Customer::create([
            //     'name' => $data->getName(),
            //     'email' => $data->getEmail(),
            //     // 'avatar' => $data->getAvatar(),
            // ]);
            // Auth::login($user);

            $customer = Customer::where('email', $data->getEmail())->first();

            if (!$customer) {
                $user = Customer::create([
                    'name' => $data->getName(),
                    'email' => $data->getEmail(),
                    // 'avatar' => $data->getAvatar(),
                    'password' => Hash::make($data->getId()),
                ]);
                Social::create([
                    'provider_user_id' => $data->getId(),
                    'provider' => $provider,
                    'customer_id' => $user->id,
                ]);
                Auth::login($user);

            } else {
                Auth::login($customer);
            }
            session()->put('customer_id', $user->id);
            session()->put('customer_name', $user->name);

            return redirect()->route('customer.home');
        }
    }
}
