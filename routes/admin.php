<?php

use App\Http\Controllers\Backend\Admin\AuthController;
use Illuminate\Support\Facades\Route;

//Admin auth routes
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

Route::get('/', function () {
    return request()->user();
    return auth()->guard()->getName();
})->middleware('auth:admin');
