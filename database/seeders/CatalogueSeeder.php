<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 10; $i++) { 
            DB::table('products')->insert([
                'name' => Str::random(10),
                'image' => 'assets/default.png',
                'price' => 100,
                'description' => Str::random(100),
                'available' => 1,
            ]);
            DB::table('services')->insert([
                'name' => Str::random(10),
                'image' => 'assets/default.png',
                'price' => 100,
                'description' => Str::random(100),
                'available' => 1,
            ]);
        }
    }
}
