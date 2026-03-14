<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([

            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'user',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Guide',
                'email' => 'guide@gmail.com',
                'password' => Hash::make('123456'),
                'role' => 'guide',
                'created_at' => now(),
                'updated_at' => now()
            ]

        ]);
    }
}