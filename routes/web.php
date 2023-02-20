<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\CheckLoginAminPageMiddleware;
use App\Http\Middleware\CheckLoginCustomerPageMiddleware;
use Illuminate\Support\Facades\Route;

// customer route

// customer auth route
Route::group(['as' => 'customer.'], function () {
    Route::get('/login', [CustomerAuthController::class, 'login'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'processLogin'])->name('process_login');

    Route::get('/register', [CustomerAuthController::class, 'register'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'processRegister'])->name('process_register');
});

Route::group(['as' => 'customer.'], function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::get('/trang-chu', [HomeController::class, 'index'])->name('home');

    // get products by category selected
    Route::get('/danh-muc-san-pham/{category_product_id}', [CategoryProductController::class, 'showProductsByCategoryId'])->name('category_product_selected');
    // get products by brand selected
    Route::get('/thuong-hieu-san-pham/{brand_product_id}', [BrandProductController::class, 'showProductsByBrandId'])->name('brand_product_selected');

    Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'detailProduct'])->name('product_detail');

    // customer is signed in
    Route::group([
        'middleware' => CheckLoginCustomerPageMiddleware::class,
    ], function () {
        // cart
        Route::get('/gio-hang', [CartController::class, 'index'])->name('cart');
        Route::post('/save-cart', [CartController::class, 'store'])->name('save_cart');
        Route::get('/delete-item-cart/{rowId}', [CartController::class, 'delete'])->name('delete__item_cart');
        Route::post('/update_cart_qty', [CartController::class, 'update'])->name('update_qty_cart');

        // checkout
        Route::get('/thong-tin-thanh-toan', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/thong-tin-thanh-toan', [CheckoutController::class, 'process_checkout'])->name('process_checkout');
        Route::get('/thanh-toan', [CheckoutController::class, 'payment'])->name('payment');
        Route::post('/dat-hang', [CheckoutController::class, 'order'])->name('order');
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

        // Category Product route
        Route::group(['prefix' => '/categories-product', 'as' => 'category_product.'], function () {
            Route::get('', [CategoryProductController::class, 'index'])->name('index');

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

// Order route
        Route::group(['prefix' => '/order', 'as' => 'order.'], function () {
            Route::get('', [CheckoutController::class, 'index'])->name('index');

            Route::get('/show/{order}', [CheckoutController::class, 'show'])->name('show');

            Route::delete('/destroy/{order}', [CheckoutController::class, 'destroy'])->name('destroy');

        });

    });

});

// end Amin route
