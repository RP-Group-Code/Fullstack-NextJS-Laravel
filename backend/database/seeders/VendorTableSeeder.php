<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('vendors')->insert([
            [
                'name' => 'PT. Maju Terus',
                'user_id' => 2,
                'uuid' => Str::uuid(),
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'kontak' => '0215551234',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'CV. Berkah Jaya',
                'user_id' => 2,
                'uuid' => Str::uuid(),
                'alamat' => 'Jl. Kemerdekaan No. 45, Bandung',
                'kontak' => '0226789012',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
