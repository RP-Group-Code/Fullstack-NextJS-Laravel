<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'uuid' => Str::uuid(),
                'password' => Hash::make("password"),
                'email' => 'demo2@example.com',
                'name' => 'demo2',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
