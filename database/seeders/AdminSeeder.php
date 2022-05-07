<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password123'),
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('users')->insert($userData);
    }
}
