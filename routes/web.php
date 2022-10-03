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
        Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'showDashboard'])
            ->middleware(['is.user'])
            ->name('view.dashboard');


        Route::controller(\App\Http\Controllers\User\CheckoutController::class)
            ->middleware(['is.user'])
            ->prefix('checkout')
            ->group(function() {
                Route::get('/{camp:slug}', 'showCheckout')->name('view.checkout');
                Route::get('/{checkout}/invoice', 'showInvoice')->name('view.checkout.invoice');
                Route::post('/{camp}', 'doCheckout')->name('action.checkout');
            });

        Route::prefix('admin')
            ->middleware(['is.admin'])
            ->group(function () {
                Route::controller(\App\Http\Controllers\Admin\DashboardController::class)
                    ->prefix('dashboard')
                    ->group(function() {
                        Route::get('/', 'showDashboard')->name('dashboard');
                    });
            });
    });

require __DIR__.'/auth.php';
