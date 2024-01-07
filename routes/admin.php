<?php

use App\Http\Controllers\Backend\Admin\AuthController;
use App\Http\Controllers\Backend\Admin\DashboardController;
use App\Http\Controllers\Backend\Admin\SchoolController;
use App\Http\Controllers\Backend\Admin\StatisticsController;
use App\Http\Controllers\Backend\Admin\SubscriptionController;
use App\Http\Controllers\Backend\Admin\UploadFilesController;
use App\Http\Controllers\Backend\LanguageController;
use Illuminate\Support\Facades\Route;

//Admin auth routes
Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

Route::middleware(['auth:admin'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //Subscription
    Route::controller(SubscriptionController::class)->group(function() {
        Route::get('/subscriptions', 'index')->name('subscriptions.index');
        Route::get('/subscriptions/all', 'subscriptions')->name('subscriptions.all');
        Route::get('/subscriptions/payments_history/{school?}', 'paymentsHistory')->name('subscriptions.payment_history');
        Route::get('/subscriptions/stats/{statsBy}', 'getSubscriptionStats')->name('subscriptions.stats');
    });

    //Login as school
    Route::controller(SchoolController::class)->group(function() {
        Route::get('login-as/school/{school}', 'loginAs')->name('school.login_as');
        Route::post('login-as/school/{school}', 'processloginAs');
    });

    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    //Upload
    Route::post('/upload', [UploadFilesController::class, 'upload'])->name('upload');

    //include Shared auth routes
    require __DIR__.'/panel_shared_auth_routes.php';
});
