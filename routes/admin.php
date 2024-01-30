<?php

use App\Http\Controllers\Backend\Admin\AuthController;
use App\Http\Controllers\Backend\Admin\DashboardController;
use App\Http\Controllers\Backend\Admin\SchoolController;
use App\Http\Controllers\Backend\Admin\SemesterController;
use App\Http\Controllers\Backend\Admin\StatisticsController;
use App\Http\Controllers\Backend\Admin\SubscriptionController;
use App\Http\Controllers\Backend\Admin\UploadFilesController;
use App\Http\Controllers\Backend\LanguageController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        Route::get('/subscriptions/payments_history', 'paymentsHistory')->name('subscriptions.payment_history');
        Route::get('/subscriptions/payments_history/subscriber/{school}', 'paymentsHistory')->name('subscriptions.payment_history');
        Route::get('/subscriptions/payments_history/{subscriptionPayment}', 'show')->name('subscription-payments.show');
        Route::put('/subscriptions/payments_history/{subscriptionPayment}/{action}', 'doAction');
        Route::get('/subscriptions/stats/{statsBy}', 'getSubscriptionStats')->name('subscriptions.stats');
    });

    //Login as school
    Route::controller(SchoolController::class)->group(function() {
        Route::get('login-as/school/{school}', 'loginAs')->name('school.login_as');
        Route::post('login-as/school/{school}', 'processloginAs');
    });

     //Semesters
     Route::apiResource('/semesters', SemesterController::class);


    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    //Upload
    Route::post('/upload', [UploadFilesController::class, 'upload'])->name('upload');

    //include Shared auth routes
    require __DIR__.'/panel_shared_auth_routes.php';
});

Route::fallback(function () { return throw new NotFoundHttpException(); })->name('fallback');
