<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// test api route
Route::get('/test', [TestController::class, 'index']);
