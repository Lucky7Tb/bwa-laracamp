<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checkout;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $checkouts = Checkout::with([
                'camp:id,title,price',
                'user:id,name'
            ])
            ->get();
        return view('admin.dashboard', compact('checkouts'));
    }
}
