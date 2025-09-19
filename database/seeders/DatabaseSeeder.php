<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder untuk tabel users
        $this->call([
            UserSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class
        ]);
        // kalau nanti Anda punya seeder lain (misalnya ProductsTableSeeder),
        // tinggal tambahkan di array ini:
        // $this->call([
        //     UsersTableSeeder::class,
        //     ProductsTableSeeder::class,
        //     OrdersTableSeeder::class,
        // ]);
    }
}