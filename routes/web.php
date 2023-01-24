<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// custom route
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index'])->name('customer.home');
// end customer route

// Admin route
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('', [AdminController::class, 'index'])->name('index');
    Route::post('', [AdminController::class, 'login'])->name('login');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminController::class, 'show_dashboard'])->name('dashboard');
});

// Category Product route
Route::group(['prefix' => 'admin/categories-product', 'as' => 'category_product.'], function () {
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
Route::group(['prefix' => 'admin/brand-product', 'as' => 'brand_product.'], function () {
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
Route::group(['prefix' => 'admin/product', 'as' => 'product.'], function () {
    Route::get('', [ProductController::class, 'index'])->name('index');

    Route::get('/inactive/{product_id}', [ProductController::class, 'inactive'])->name('inactive');
    Route::get('/active/{product_id}', [ProductController::class, 'active'])->name('active');

    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/create', [ProductController::class, 'store'])->name('store');

    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/edit/{product}', [ProductController::class, 'update'])->name('update');

    Route::delete('/destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');

});

// end Amin route
