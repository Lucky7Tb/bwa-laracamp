<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\CheckoutRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\AfterCheckout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Discount;
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
        $user->phone_number = $checkoutData['phone_number'];
        $user->address = $checkoutData['address'];
        $user->save();

        $checkout = new Checkout();
        $checkout->user_id = $user->id;
        $checkout->camp_id = $camp->id;

        if (isset($checkoutData['code'])) {
            $discount = Discount::whereCode($checkoutData['code'])->first();
            $checkout->discount_id = $discount->id;
            $checkout->discount_percentage = $discount->percentage;
        }

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

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantity' => 1,
            'name' => 'Payment for '. $checkout->camp->title.' Camp' 
        ];

        $discountPrice = 0;
        if ($checkout->discount) {
            $discountPrice = $price * $checkout->discount_percentage / 100;
            $item_details[] = [
                'id' => $checkout->discount->code,
                'price' => $discountPrice * -1,
                'quantity' => 1,
                'name' => 'Discount checkout '. $checkout->discount->name.' '.$checkout->discount_percentage.'%' 
            ];
        }

        $total = $price - $discountPrice;
        $transactionDetails = [
            'order_id' => $orderId,
            'gross_ammount' => $total
        ];

        $userData[] = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'address' => $checkout->user->address,
            'city' => '',
            'postal_code' => '',
            'phone' => $checkout->user->phone_number,
            'country_code' => 'IDN'
        ];

        $customerDetails = [
            'first_name' => $checkout->user->name,
            'last_name' => '',
            'email' => $checkout->user->email,
            'phone' => $checkout->user->phone_number,
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
            $checkout->total = $total;
            $checkout->save();

            return $paymentUrl;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function midtransCallback(Request $request)
    {
        $notif = $request->method() === 'POST' ? new Midtrans\Notification() : Midtrans\Transaction::status($request->order_id);

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $checkoutId = explode('-', $notif->order_id)[0];
        $checkout = Checkout::find($checkoutId);

        switch ($transaction_status) {
            case 'capture':
                if ($fraud == 'challenge') {
                    // TODO Set payment status in merchant's database to 'challenge'
                    $checkout->payment_status = 'pending';
                } else {
                    // TODO Set payment status in merchant's database to 'success'
                    $checkout->payment_status = 'paid';
                }
                break;
            case 'cancel':
                if ($fraud == 'challenge') {
                    // TODO Set payment status in merchant's database to 'failure'
                    $checkout->payment_status = 'failed';
                } else {
                    // TODO Set payment status in merchant's database to 'failure'
                    $checkout->payment_status = 'failed';
                }
                break;
            case 'deny':
                $checkout->payment_status = 'failed';
                break;
            case 'settlement':
                $checkout->payment_status = 'paid';
                break;
            case 'pending':
                $checkout->payment_status = 'pending';
                break;
            case 'expired':
                $checkout->payment_status = 'failed';
                break;
        }

        $checkout->save();
        return view('user.checkout-success');
    }
}
