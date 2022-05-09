<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\User\LandingController::class, 'showLanding']);

Route::get('/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'showDashboard']);

Route::controller(\App\Http\Controllers\User\AuthController::class)
    ->group(function() {
        Route::get('login', 'showLogin')->name('view.login');
    });

Route::controller(\App\Http\Controllers\User\CheckoutController::class)
    ->group(function() {
        Route::get('checkout', 'showCheckout')->name('view.checkout');
        Route::get('checkout/success', 'showCheckoutSuccess')->name('view.checkout-success');
    });

Route::prefix('admin')
    ->middleware(['auth'])
    ->group(function () {
        Route::controller(\App\Http\Controllers\Admin\DashboardController::class)
            ->prefix('dashboard')
            ->group(function() {
                Route::get('/', 'showDashboard')->name('dashboard');
            });
    });

require __DIR__.'/auth.php';
