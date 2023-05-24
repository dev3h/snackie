<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BrandProduct;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Product;
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
        return view('pages.' . $this->folderName . '.admin_login', [
            'title' => 'Đăng nhập quyền quản trị',
        ]);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $pass = md5($request->password);

        $result = Admin::where('email', $email)->where('password', $pass)->first();
        if ($result) {
            session()->put('admin_name', $result->username);
            session()->put('admin_id', $result->id);

            return redirect()->route($this->asRoute . '.dashboard');
        } else {
            session()->put('message', 'Email hoặc mật khẩu không đúng');
            return redirect()->route($this->asRoute . '.index');
        }
    }
    public function show_dashboard()
    {
        $categories_count = CategoryProduct::count();
        $brand_count = BrandProduct::count();
        $product_count = Product::count();
        $customer_count = Customer::count();
        $statistics = [
            [
                'title' => 'Số lượng danh mục',
                'count' => $categories_count,
            ],
            [
                'title' => 'Số lượng thương hiệu',
                'count' => $brand_count,
            ],
            [
                'title' => 'Số lượng sản phẩm',
                'count' => $product_count,
            ],
            [
                'title' => 'Số lượng khách hàng',
                'count' => $customer_count,
            ],
        ];

        return view('pages.' . $this->folderName . '.dashboard.index', [
            'title' => 'Trang quản trị',
            'statistics' => $statistics,
        ]);
    }

    public function getRevenue()
    {
        $max_date = $_GET['days'] ?? 7;
        $revenue = DB::table('orders')
            ->select(DB::raw("DATE_FORMAT(created_at, '%e-%m') as ngay, SUM(total_price) as 'doanh thu'"))
            ->whereRaw("DATE(created_at) >= CURDATE() - INTERVAL $max_date DAY")
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%e-%m')"))
            ->get();

        $arr = [];
        $today = date('d');
        if ($today < $max_date) {
            $get_day_last_month = $max_date - $today;

            $last_month = date('m', strtotime('-1 month'));
            $last_month_date = date('Y-m-d', strtotime('-1 month'));
            $max_day_last_month = date('t', strtotime($last_month_date));
            $start_day_last_month = $max_day_last_month - $get_day_last_month;

            for ($i = $start_day_last_month; $i <= $start_day_last_month; $i++) {
                $key = $i . '-' . $last_month;
                $arr[$key] = 0;
            }
            $start_day_this_month = 1;
        } else {
            $start_day_this_month = $today - $max_date;
        }
        $this_month = date('m');

        for ($i = $start_day_this_month; $i <= $today; $i++) {
            $key = $i . '-' . $this_month;
            $arr[$key] = 0;
        }
        foreach ($revenue as $each) {
            $eachArray = get_object_vars($each);
            $arr[$eachArray['ngay']] = (float) $eachArray['doanh thu'];
        }

        return response()->json($arr);
    }

    public function getSold()
    {
        $max_date = $_GET['days'] ?? 7;
        $sold = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->select('products.id as ma_san_pham', 'products.name as ten_san_pham', DB::raw("DATE_FORMAT(orders.created_at, '%e-%m') as ngay"), DB::raw('SUM(order_details.quantity) as so_san_pham_ban_duoc'))
            ->whereRaw("DATE(orders.created_at) >= CURDATE() - INTERVAL $max_date DAY")
            ->groupBy('products.id', 'products.name', DB::raw("DATE_FORMAT(orders.created_at, '%e-%m')"))
            ->get();

        $arr = [];

        $today = date('d');
        if ($today < $max_date) {
            $get_day_last_month = $max_date - $today;

            $last_month = date('m', strtotime('-1 month'));
            $last_month_date = date('Y-m-d', strtotime('-1 month'));
            $max_day_last_month = date('t', strtotime($last_month_date));

            $start_day_last_month = $max_day_last_month - $get_day_last_month;

            $start_day_this_month = 1;
        } else {
            $start_day_this_month = $today - $max_date;
        }

        foreach ($sold as $each) {
            $eachArray = get_object_vars($each);

            $ma_san_pham = $eachArray['ma_san_pham'];
            if (empty($arr[$ma_san_pham])) {

                $arr[$ma_san_pham] = [
                    'name' => $eachArray['ten_san_pham'],
                    'y' => (int) $eachArray['so_san_pham_ban_duoc'],
                    'drilldown' => (int) $eachArray['ma_san_pham'],
                ];
            } else {
                $arr[$ma_san_pham]['y'] += (int) $eachArray['so_san_pham_ban_duoc'];
            }
        }
        $arr2 = [];
        foreach ($arr as $ma_san_pham => $each) {
            $arr2[$ma_san_pham] = [
                'name' => $each['name'],
                'id' => $ma_san_pham,
            ];
            $arr2[$ma_san_pham]['data'] = [];
            if ($today < $max_date) {
                for ($i = $start_day_last_month; $i <= $start_day_last_month; $i++) {
                    $key = $i . '-' . $last_month;
                    $arr2[$ma_san_pham]['data'][$key] = [
                        $key,
                        0,
                    ];
                }
            }
        }
        foreach ($sold as $each) {
            $eachArray = get_object_vars($each);

            $ma_san_pham = $eachArray['ma_san_pham'];
            $key = $eachArray['ngay'];
            $arr2[$ma_san_pham]['data'][$key] = [
                $key,
                (int) $eachArray['so_san_pham_ban_duoc'],
            ];
        }
        return response()->json([$arr, $arr2]);
    }
    public function logout()
    {
        session()->put('admin_name', null);
        session()->put('admin_id', null);
        return redirect()->route($this->asRoute . '.index');
    }
}
