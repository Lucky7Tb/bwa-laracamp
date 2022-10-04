<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\User\LandingController::class, 'showLanding']);

Route::controller(\App\Http\Controllers\User\AuthController::class)
    ->middleware(['guest'])
    ->group(function() {
        Route::get('login', 'showLogin')->name('view.login');
        Route::get('auth/google/redirect', 'loginWithGoogle')->name('action.login-with-google');
        Route::get('auth/google/callback', 'loginGoogleCallback')->name('action.login-callback');
        Route::post('logout', 'logout')->name('action.logout');
    });

Route::middleware(['auth'])
    ->group(function() {

        // User Route
        Route::middleware(['is.user'])  
            ->name('user.')
            ->group(function(){
                Route::get('dashboard', \App\Http\Controllers\User\DashboardController::class)
                ->name('view.dashboard');

                Route::controller(\App\Http\Controllers\User\CheckoutController::class)
                    ->prefix('checkout')
                    ->group(function() {
                        Route::get('/{camp:slug}', 'showCheckout')->name('view.checkout');
                        Route::post('/{camp}', 'doCheckout')->name('action.checkout');
                    });
            });

        // Admin route
        Route::prefix('admin')
            ->middleware(['is.admin'])
            ->name('admin.')
            ->group(function () {
                Route::get('dashboard', \App\Http\Controllers\Admin\DashboardController::class)
                ->name('view.dashboard');
            });
    });

require __DIR__.'/auth.php';
