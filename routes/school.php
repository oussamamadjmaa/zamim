<?php

use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    return request()->user();
    return auth()->guard()->getName();
})->name('home')->middleware('auth:school');


Auth::routes();

Route::post('register/redirect-aps-payment', [RegisterController::class, 'redirectApsPayment'])->name('redirect-aps-payment');
