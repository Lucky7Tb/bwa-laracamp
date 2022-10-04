<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checkout;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $checkouts = Checkout::where('user_id', auth()->user()->id)
            ->with([
                'camp:id,title,price'
            ])
            ->get();
        return view('user.dashboard', compact('checkouts'));
    }
}
