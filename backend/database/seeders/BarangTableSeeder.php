<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('barangs')->insert([
            [
                'uuid' => Str::uuid(),
                'user_id' => 2,
                'vendor_id' => 11,
                'ppn' => 11,
                'name' => 'Indomie Goreng',
                'qty_kecil' => 50,
                'qty_sedang' => 50,
                'qty_besar' => 250,
                'satuan_kecil' => 'pcs',
                'satuan_sedang' => 'box',
                'satuan_besar' => 'krt',
                'fp' => 'ppn',
                'type' => 'makanan/minuman',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'uuid' => Str::uuid(),
                'user_id' => 2,
                'vendor_id' => 11,
                'ppn' => 11,
                'name' => 'Oli Mesin',
                'qty_kecil' => 12,
                'qty_sedang' => 12,
                'qty_besar' => 144,
                'satuan_kecil' => 'pcs',
                'satuan_sedang' => 'rtg',
                'satuan_besar' => 'krt',
                'fp' => 'non_ppn',
                'type' => 'otomotif',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
