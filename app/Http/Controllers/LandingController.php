<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $camps = Camp::select('id', 'title', 'slug', 'price')
            ->with([
                'campBenefits:camp_id,name'
            ])
            ->get();

        return view('landing', compact('camps'));
    }
}
