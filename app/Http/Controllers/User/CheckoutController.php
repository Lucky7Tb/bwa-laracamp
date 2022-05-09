<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout()
    {
        return view('user.checkout');
    }

    public function showCheckoutSuccess()
    {
        return view('user.checkout-success');
    }
}
