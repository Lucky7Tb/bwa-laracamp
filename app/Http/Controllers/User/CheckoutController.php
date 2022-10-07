<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\CheckoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\AfterCheckout;
use Illuminate\Support\Str;
use App\Models\Checkout;
use App\Models\Camp;
use Midtrans;

class CheckoutController extends Controller
{

    public function __construct()
    {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function showCheckout(Camp $camp)
    {
        if ($camp->isRegistered) {
            return redirect(route('user.view.dashboard'))->with('error.message', 'You already registered');
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

        $this->getSnapRedirect($checkout);

        Mail::to($user->email)->send(new AfterCheckout($checkout));

        return view('user.checkout-success');
    }

    /**
     * Midtrans handler 
     *
    */
    public function getSnapRedirect(Checkout $checkout)
    {
        $orderId = $checkout->id .'-'.Str::random(5);
        $price = $checkout->camp->price;
        $checkout->midtrans_booking_code = $orderId;

        $transactionDetails = [
            'order_id' => $orderId,
            'gross_ammount' => $price
        ];

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => 'Payment for '. $checkout->camp->title.' Camp' 
        ];

        $userData[] = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'address' => $checkout->user->address,
            'city' => '',
            'postal_code' => '',
            'phone' => $checkout->user->phone,
            'country_code' => 'IDN'
        ];

        $customerDetails = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'email' => $checkout->user->email,
            'phone' => $checkout->user->phone,
            'billing_address' => $userData,
            'shipping_address' => $userData
        ];

        $midtransParams = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customerDetails,
            'item_details' => $item_details
        ];

        try {
            $paymentUrl = \Midtrans\Snap::createTransaction($midtransParams)->redirect_url; 
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();

            return $paymentUrl;
        } catch (\Exception $e) {
            return false;
        }
    }
}
