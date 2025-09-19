<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('product_categories')->insert([
            ['category_id' => 1, 'category_name' => 'Alat Diagnostik'],
            ['category_id' => 2, 'category_name' => 'Alat Bedah'],
            ['category_id' => 3, 'category_name' => 'Obat'],
            ['category_id' => 4, 'category_name' => 'Alat Perawatan'],
            ['category_id' => 5, 'category_name' => 'Alat Pelindung Diri'],
        ]);
    }
}
