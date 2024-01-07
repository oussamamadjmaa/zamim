<?php

use App\Http\Controllers\Backend\LanguageController;
use App\Http\Controllers\Backend\NotificationsController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\StatsController;
use Illuminate\Support\Facades\Route;

 //
 Route::get('/stats/{type}/{period}', [StatsController::class, 'stats'])->name('stats');

//Notifications
Route::prefix('/notifications')->controller(NotificationsController::class)->group(function() {
    Route::get('/', 'index')->name('notifications.index');
    Route::get('/stats', 'stats')->name('notifications.stats');
    Route::get('/r/{notification}', 'redirect')->name('notifications.redirect');
});

//Profile
Route::controller(ProfileController::class)->group(function() {
    Route::get('profile', 'index')->name('profile.index');
    Route::put('profile', 'update');
});


//Language
Route::get('/lang/{lang}', [LanguageController::class, 'switch'])->name('lang');
