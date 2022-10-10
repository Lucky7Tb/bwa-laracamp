<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DiscountRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discount::select(['id', 'name', 'code', 'description', 'percentage'])->paginate(10);
        return view('admin.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $request)
    {
        $discountData = $request->validated();

        Discount::create($discountData);

        return redirect(route('admin.discount.index'))->with('success.message', 'Success create discount');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        return view('admin.discount.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        $discountData = $request->validated();
        $discount->name = $discountData['name'];
        $discount->code = $discountData['code'];
        $discount->description = $discountData['description'];
        $discount->percentage = $discountData['percentage'];
        $discount->save();
        return redirect(route('admin.discount.index'))->with('success.message', 'Success update discount');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect(route('admin.discount.index'))->with('success.message', 'Success delete discount');
    }
}
