<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Settings Routes
    Route::prefix('settings')->name('settings.')->controller(UserController::class)->group(function () {
        Route::get('users/{user}/reset-password', 'resetPassword')->name('users.reset-password');
        Route::post('users/{user}/reset-password', 'postResetPassword')->name('users.post.reset-password');
        Route::resource('users', UserController::class);
    });


    Route::prefix('meetings')->name('meetings.')->controller(MeetingController::class)->group(function () {
    });

    Route::resource('meetings', MeetingController::class);


});



