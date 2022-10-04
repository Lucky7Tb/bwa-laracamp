<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\Checkout\Paid;
use Illuminate\Support\Facades\Mail;
use App\Models\Checkout;

class CheckoutController extends Controller
{
    public function __invoke(Checkout $checkout)
    {
        $checkout->is_paid = true;
        $checkout->save();
        Mail::to($checkout->user->email)->send(new Paid($checkout));
        return redirect(route('admin.view.dashboard'))->with('success.message', 'Success make user transaction with id: '. $checkout->id . ' to paid');
    }
}
