<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\LandingController::class, 'index']);

Route::controller(\App\Http\Controllers\AuthController::class)
    ->group(function() {
        Route::get('login', 'showLogin')->name('view.login');
    });

