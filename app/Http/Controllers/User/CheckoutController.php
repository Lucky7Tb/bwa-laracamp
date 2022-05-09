<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Camp;

class CheckoutController extends Controller
{
    public function showCheckout(Camp $camp)
    {
        return view('user.checkout');
    }

    public function showCheckoutSuccess()
    {
        return view('user.checkout-success');
    }
}
