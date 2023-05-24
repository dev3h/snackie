<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckLoginAminPageMiddleware;
use App\Http\Middleware\CheckLoginCustomerPageMiddleware;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// lang route
Route::get('/lang/{locale}', function ($locale) {
    $available_locales = config('app.locales', []);

    if (!in_array($locale, $available_locales)) {
        $locale = config('app.fallback_locale');
    }
    session()->put('locale', $locale);

    return redirect()->back();
})->name('lang');

// customer route

// customer auth route
Route::group(['as' => 'customer.'], function () {
    Route::get('/login', [CustomerAuthController::class, 'login'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'processLogin'])->name('process_login');

    Route::get('/register', [CustomerAuthController::class, 'register'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'processRegister'])->name('process_register');

    // socialite
    Route::get('/auth/redirect/{provider}', function ($provider) {
        return Socialite::driver($provider)->redirect();
    })->name('socialite_redirect');

    Route::get('/auth/callback/{provider}', [CustomerAuthController::class, 'callback'])->name('socialite_callback');

});

Route::group(['as' => 'customer.'], function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // get products by category selected
    Route::get('/danh-muc-san-pham/{slug?}', [HomeController::class, 'index'])->name('category_product_selected');
    // get products by brand selected
    Route::get('/thuong-hieu-san-pham/{slug?}', [HomeController::class, 'index'])->name('brand_product_selected');

    Route::get('/chi-tiet-san-pham/{slug?}', [ProductController::class, 'detailProduct'])->name('product_detail');

    // customer is signed in
    Route::group([
        'middleware' => CheckLoginCustomerPageMiddleware::class,
    ], function () {
        // cart
        Route::get('/gio-hang', [CartController::class, 'index'])->name('cart');
        Route::get('/save-cart', [CartController::class, 'store'])->name('save_cart');
        Route::get('/delete-item-cart', [CartController::class, 'delete'])->name('delete__item_cart');
        Route::get('/delete-item-cart-checked', [CartController::class, 'deleteItemCartChecked'])->name('delete__item_cart_checked');
        Route::get('/delete-all-cart', [CartController::class, 'deleteAllCart'])->name('delete__all_cart');
        Route::get('/update_cart_qty', [CartController::class, 'update'])->name('update_qty_cart');

        //coupon
        Route::post('/check-coupon', [CartController::class, 'checkCoupon'])->name('check_coupon');
        Route::get('/unset-coupon', [CartController::class, 'unsetCoupon'])->name('unset_coupon');

        // checkout
        Route::get('/thong-tin-thanh-toan', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/thong-tin-thanh-toan', [CheckoutController::class, 'process_checkout'])->name('process_checkout');
        // Route::get('/thanh-toan', [CheckoutController::class, 'payment'])->name('payment');
        // Route::get('/phuong-thuc-thanh-toan/{method}', [CheckoutController::class, 'paymentMethod'])->name('payment_method');
        // Route::post('/dat-hang', [CheckoutController::class, 'order'])->name('order');
        Route::get('/vnpay', [CheckoutController::class, 'checkoutOnline'])->name('payment_online');
        Route::post('/process-vnpay', [CheckoutController::class, 'handleVnpayCreatePayment'])->name('handle_vnpay_create_payment');
        Route::get('/hoan-thanh', [CheckoutController::class, 'complete'])->name('complete');

        // logout
        Route::get('/logout', [CustomerAuthController::class, 'logout'])->name('logout');
    });
});

// end customer route

// Admin route

// admin auth route
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('', [AdminController::class, 'index'])->name('index');
    Route::post('', [AdminController::class, 'login'])->name('process_login');
});

Route::group([
    'middleware' => CheckLoginAminPageMiddleware::class,
], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminController::class, 'show_dashboard'])->name('dashboard');
        Route::get('/revenue', [AdminController::class, 'getRevenue'])->name('get_revenue');
        Route::get('/sold', [AdminController::class, 'getSold'])->name('get_sold');

        // Category Product route
        Route::group(['prefix' => '/categories-product', 'as' => 'category_product.'], function () {
            Route::get('', [CategoryProductController::class, 'index'])->name('index');
            Route::get('/api', [CategoryProductController::class, 'api'])->name('api');

            Route::get('/inactive/{category_product_id}', [CategoryProductController::class, 'inactive'])->name('inactive');
            Route::get('/active/{category_product_id}', [CategoryProductController::class, 'active'])->name('active');

            Route::get('/create', [CategoryProductController::class, 'create'])->name('create');
            Route::post('/create', [CategoryProductController::class, 'store'])->name('store');

            Route::get('/edit/{category_product}', [CategoryProductController::class, 'edit'])->name('edit');
            Route::put('/edit/{category_product}', [CategoryProductController::class, 'update'])->name('update');

            Route::delete('/destroy/{category_product}', [CategoryProductController::class, 'destroy'])->name('destroy');
        });

        // Brand Product route
        Route::group(['prefix' => '/brand-product', 'as' => 'brand_product.'], function () {
            Route::get('', [BrandProductController::class, 'index'])->name('index');

            Route::get('/inactive/{brand_product_id}', [BrandProductController::class, 'inactive'])->name('inactive');
            Route::get('/active/{brand_product_id}', [BrandProductController::class, 'active'])->name('active');

            Route::get('/create', [BrandProductController::class, 'create'])->name('create');
            Route::post('/create', [BrandProductController::class, 'store'])->name('store');

            Route::get('/edit/{brand_product}', [BrandProductController::class, 'edit'])->name('edit');
            Route::put('/edit/{brand_product}', [BrandProductController::class, 'update'])->name('update');

            Route::delete('/destroy/{brand_product}', [BrandProductController::class, 'destroy'])->name('destroy');
        });

        // Product route
        Route::group(['prefix' => '/product', 'as' => 'product.'], function () {
            Route::get('', [ProductController::class, 'index'])->name('index');

            Route::get('/inactive/{product_id}', [ProductController::class, 'inactive'])->name('inactive');
            Route::get('/active/{product_id}', [ProductController::class, 'active'])->name('active');

            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/create', [ProductController::class, 'store'])->name('store');

            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::put('/edit/{product}', [ProductController::class, 'update'])->name('update');

            Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
        });

        // Employee route
        Route::group(['prefix' => '/employee', 'as' => 'employee.'], function () {
            Route::get('', [EmployeeController::class, 'index'])->name('index');

            Route::get('/inactive/{employee_id}', [EmployeeController::class, 'inactive'])->name('inactive');
            Route::get('/active/{employee_id}', [EmployeeController::class, 'active'])->name('active');

            Route::get('/create', [EmployeeController::class, 'create'])->name('create');
            Route::post('/create', [EmployeeController::class, 'store'])->name('store');

            Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('edit');
            Route::put('/edit/{employee}', [EmployeeController::class, 'update'])->name('update');
        });

        // Coupon route
        Route::group(['prefix' => '/coupon', 'as' => 'coupon.'], function () {
            Route::get('', [CouponController::class, 'index'])->name('index');

            Route::get('/inactive/{coupon_id}', [CouponController::class, 'inactive'])->name('inactive');
            Route::get('/active/{coupon_id}', [CouponController::class, 'active'])->name('active');

            Route::get('/create', [CouponController::class, 'create'])->name('create');
            Route::post('/create', [CouponController::class, 'store'])->name('store');

            Route::get('/edit/{coupon}', [CouponController::class, 'edit'])->name('edit');
            Route::put('/edit/{coupon}', [CouponController::class, 'update'])->name('update');

            Route::delete('/destroy/{coupon}', [CouponController::class, 'destroy'])->name('destroy');

        });

        // Order route
        Route::group(['prefix' => '/order', 'as' => 'order.'], function () {
            Route::get('', [CheckoutController::class, 'index'])->name('index');

            Route::get('/show/{order}', [CheckoutController::class, 'show'])->name('show');
            Route::put('/update/{order}', [CheckoutController::class, 'update'])->name('update');

            Route::delete('/destroy/{order}', [CheckoutController::class, 'destroy'])->name('destroy');

            Route::get('/print-order/{order}', [CheckoutController::class, 'printOrder'])->name('print_order');
        });
    });

});

// end Amin route
