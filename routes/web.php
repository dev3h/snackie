<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// custom route
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index'])->name('customer.home');
// end customer route

// Admin route
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('', [AdminController::class, 'index']);
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
// end Amin route
