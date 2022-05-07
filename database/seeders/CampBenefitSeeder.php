<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CampBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campBenefitData = [
            [
                'camp_id' => 1,
                'name' => 'Pro Techstack Kit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => 'iMac Pro 2021 & Display',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => '1-1 Mentoring Program',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => 'Final Project Certificate',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => 'Offline Course Videos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => 'Future Job Opportinity',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => 'Premium Design Kit',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 1,
                'name' => 'Website Builder',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 2,
                'name' => '1-1 Mentoring Program',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 2,
                'name' => 'Final Project Certificate',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 2,
                'name' => 'Offline Course Videos',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'camp_id' => 2,
                'name' => 'Premium Design Kit',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('camp_benefits')->insert($campBenefitData);
    }
}
