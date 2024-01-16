<?php

use App\Http\Controllers\Backend\Portal\Auth\LoginController;
use App\Http\Controllers\Backend\Portal\HomeController;
use App\Http\Controllers\Backend\LanguageController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/login/verification', 'showVerificationForm')->name('login.verification');
    Route::post('/login/verify', 'verifyCode')->name('login.verify');
    Route::post('logout', 'logout')->name('logout');
});


Route::middleware(['auth', 'portal-auth'])->group(function() {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //include Shared auth routes
    require __DIR__.'/panel_shared_auth_routes.php';

    //Language
    Route::get('/lang/{lang}', [LanguageController::class, 'switch'])->name('lang');
});

Route::fallback(function () { return throw new NotFoundHttpException(); })->name('fallback');
