<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\CheckoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\AfterCheckout;
use App\Models\Checkout;
use App\Models\Camp;

class CheckoutController extends Controller
{
    public function showCheckout(Camp $camp)
    {
        if ($camp->isRegistered) {
            return redirect(route('view.dashboard'))->with('error.message', 'You already registered');
        }
        return view('user.checkout', compact('camp'));
    }

    public function doCheckout(CheckoutRequest $request, Camp $camp)
    {
        $checkoutData = $request->validated();

        $user = Auth::user();
        $user->name = $checkoutData['name'];
        $user->email = $checkoutData['email'];
        $user->occupation = $checkoutData['occupation'];
        $user->save();

        $checkout = new Checkout();
        $checkout->user_id = $user->id;
        $checkout->camp_id = $camp->id;
        $checkout->card_number = $checkoutData['card_number'];
        $checkout->expired = date('Y-m-t', strtotime($checkoutData['expired']));
        $checkout->cvc = $checkoutData['cvc'];
        $checkout->save();

        Mail::to($user->email)->send(new AfterCheckout($checkout));

        return view('user.checkout-success');
    }
}
