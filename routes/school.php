<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Backend\School\DashboardController;
use App\Http\Controllers\Backend\School\StudentController;
use App\Http\Controllers\Backend\School\TeacherController;

Auth::routes();
Route::post('register/redirect-aps-payment', [RegisterController::class, 'redirectApsPayment'])->name('redirect-aps-payment');


Route::middleware('auth:school')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //Students
    Route::apiResource('/students', StudentController::class);

    //Teachers
    Route::apiResource('/teachers', TeacherController::class);
});
