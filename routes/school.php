<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\School\ActivityController;
use App\Http\Controllers\Backend\School\DashboardController;
use App\Http\Controllers\Backend\School\RadioController;
use App\Http\Controllers\Backend\School\StudentController;
use App\Http\Controllers\Backend\School\SubscriptionController;
use App\Http\Controllers\Backend\School\SubscriptionPaymentCallbackController;
use App\Http\Controllers\Backend\School\TeacherController;
use App\Http\Controllers\Backend\School\UploadFilesController;
use App\Http\Controllers\Frontend\ChoosePlanController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Auth::routes();
Route::get('login/{loginCode}', [LoginController::class, 'loginAs'])->name('login_as');

//
Route::get('/choose-plan', [ChoosePlanController::class, 'index'])->name('choose-plan');

Route::post('/subscription/payment_callback/{provider}', [SubscriptionPaymentCallbackController::class, 'callback'])->name('subscription.payment_callback');


Route::middleware(['auth:school', 'school-subscription'])->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //Students
    Route::post('students/import', [StudentController::class, 'import']);
    Route::apiResource('/students', StudentController::class);


    //Teachers
    Route::post('teachers/import', [TeacherController::class, 'import']);
    Route::apiResource('/teachers', TeacherController::class);

    //Radios
    Route::put('/radios/{radio}/rating', [RadioController::class, 'storeRating'])->name('radios.rating');
    Route::apiResource('/radios', RadioController::class)->except(['store', 'destroy']);

    //Activities
    Route::apiResource('/activities', ActivityController::class);


    //Subscription
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::get('/subscription/payment_history', [SubscriptionController::class, 'paymentHistory'])->name('subscription.payment_history');
    Route::get('/subscription/choose-plan', [SubscriptionController::class, 'choosePlan'])->name('subscription.choose-plan');
    Route::get('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/checkout', [SubscriptionController::class, 'processCheckout'])->name('subscription.checkout');
    Route::get('/subscription/payment/status/{subscriptionPayment}', [SubscriptionController::class, 'paymentStatus'])->name('subscription.payment.status');

    //include Shared auth routes
    require __DIR__.'/panel_shared_auth_routes.php';

    //Upload
    Route::post('/upload', [UploadFilesController::class, 'upload'])->name('upload');
});

Route::fallback(function () { return throw new NotFoundHttpException(); })->name('fallback');
