<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $meta_desc = "Chuyên cung cấp các sản phẩm thời trang nam nữ, giày dép, túi xách, phụ kiện, đồng hồ, mỹ phẩm, thực phẩm, đồ gia dụng, đồ điện tử, đồ gia dụng, đồ chơi, đồ dùng cho bé, đồ dùng cho mẹ và bé, đồ dùng cho gia đình, đồ dùng cho nhà bếp, đồ dùng cho phòng tắm, đồ dùng cho phòng ngủ, đồ dùng cho phòng khách, đồ dùng cho phòng làm việc, đồ dùng cho phòng ăn, đồ dùng cho phòng học, đồ dùng cho phòng sinh hoạt, đồ dùng";
    protected $meta_keywords = "thời trang nam, thời trang nữ, giày dép, túi xách, phụ kiện, đồng hồ, mỹ phẩm, thực phẩm, đồ gia dụng, đồ điện tử, đồ gia dụng, đồ chơi, đồ dùng cho bé, đồ dùng cho mẹ và bé, đồ dùng cho gia đình, đồ dùng cho nhà bếp, đồ dùng cho phòng tắm, đồ dùng cho phòng ngủ, đồ dùng cho phòng khách, đồ dùng cho phòng làm việc, đồ dùng cho phòng ăn, đồ dùng cho phòng học, đồ dùng cho phòng sinh hoạt, đồ dùng";
    protected $url_canonical;
    
    public function __construct()
    {
        $this->url_canonical = url()->current();
        View::share(
            [
                'meta_desc' => $this->meta_desc,
                'meta_keywords' => $this->meta_keywords,
                'url_canonical' => $this->url_canonical,
            ]
        );
    }
}
