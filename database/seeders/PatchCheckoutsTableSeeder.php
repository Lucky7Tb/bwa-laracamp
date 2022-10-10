<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Checkout;

class PatchCheckoutsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $checkouts = Checkout::whereTotal(0)->get();
        foreach ($checkouts as $checkout) {
            $checkout->update([
                'total' => $checkout->camp->price
            ]);
        }
    }
}
