<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Camp;

class LandingController extends Controller
{
    public function showLanding()
    {
        $camps = Camp::select('id', 'title', 'slug', 'price')
            ->with([
                'campBenefits:camp_id,name'
            ])
            ->get();

        return view('user.landing', compact('camps'));
    }
}
