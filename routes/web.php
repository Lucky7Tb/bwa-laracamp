<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index']);

Route::controller(\App\Http\Controllers\AuthController::class)
    ->group(function() {
        Route::get('login', 'showLogin')->name('view.login');
    });

Route::controller(\App\Http\Controllers\DashboardController::class)
    ->prefix('dashboard')
    ->group(function() {
        Route::get('/', 'showDashboard')->name('view.dashboard');
    });

Route::controller(\App\Http\Controllers\CheckoutController::class)
    ->group(function() {
        Route::get('checkout', 'showCheckout')->name('view.checkout');
        Route::get('checkout/success', 'showCheckoutSuccess')->name('view.checkout-success');
    });
