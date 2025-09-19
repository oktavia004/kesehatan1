<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Alat Diagnostik
            [
                'product_code' => 'TD001',
                'product_name' => 'Tensimeter',
                'price'        => 250000,
                'stock'        => 10,
                'category_id'  => 1,
                'image_url'    => 'img/products/tensimeter.jpg',
                'description'  => 'Alat untuk mengukur tekanan darah secara manual maupun digital.'
            ],
            [
                'product_code' => 'TD002',
                'product_name' => 'Stetoskop',
                'price'        => 150000,
                'stock'        => 15,
                'category_id'  => 1,
                'image_url'    => 'img/products/stetoskop.jpg',
                'description'  => 'Alat medis yang digunakan untuk mendengarkan detak jantung atau pernapasan.'
            ],

            // Alat Bedah
            [
                'product_code' => 'AB001',
                'product_name' => 'Pisau Bedah',
                'price'        => 50000,
                'stock'        => 50,
                'category_id'  => 2,
                'image_url'    => 'img/products/pisau_bedah.jpg',
                'description'  => 'Pisau kecil yang digunakan dalam prosedur pembedahan.'
            ],
            [
                'product_code' => 'AB002',
                'product_name' => 'Pinset Bedah',
                'price'        => 30000,
                'stock'        => 40,
                'category_id'  => 2,
                'image_url'    => 'img/products/pinset_bedah.jpg',
                'description'  => 'Pinset steril yang dipakai untuk menjepit jaringan saat operasi.'
            ],

            // Obat
            [
                'product_code' => 'OB001',
                'product_name' => 'Paracetamol',
                'price'        => 10000,
                'stock'        => 100,
                'category_id'  => 3,
                'image_url'    => 'img/products/paracetamol.jpg',
                'description'  => 'Obat pereda nyeri dan penurun panas.'
            ],
            [
                'product_code' => 'OB002',
                'product_name' => 'Amoxicillin',
                'price'        => 25000,
                'stock'        => 80,
                'category_id'  => 3,
                'image_url'    => 'img/products/amoxicillin.jpg',
                'description'  => 'Antibiotik yang digunakan untuk mengobati infeksi bakteri.'
            ],

            // Alat Perawatan
            [
                'product_code' => 'AP001',
                'product_name' => 'Kursi Roda',
                'price'        => 1500000,
                'stock'        => 5,
                'category_id'  => 4,
                'image_url'    => 'img/products/kursi_roda.jpg',
                'description'  => 'Kursi yang dilengkapi roda untuk membantu mobilitas pasien.'
            ],
            [
                'product_code' => 'AP002',
                'product_name' => 'Tongkat Jalan',
                'price'        => 120000,
                'stock'        => 12,
                'category_id'  => 4,
                'image_url'    => 'img/products/tongkat_jalan.jpg',
                'description'  => 'Tongkat penyangga untuk membantu berjalan.'
            ],

            // Alat Pelindung Diri
            [
                'product_code' => 'PD001',
                'product_name' => 'Masker Medis',
                'price'        => 2000,
                'stock'        => 200,
                'category_id'  => 5,
                'image_url'    => 'img/products/masker_medis.jpg',
                'description'  => 'Masker sekali pakai untuk melindungi pernapasan dari virus dan bakteri.'
            ],
            [
                'product_code' => 'PD002',
                'product_name' => 'Hand Sanitizer',
                'price'        => 15000,
                'stock'        => 150,
                'category_id'  => 5,
                'image_url'    => 'img/products/hand_sanitizer.jpg',
                'description'  => 'Cairan antiseptik untuk membersihkan tangan tanpa air.'
            ],
            [
                'product_code' => 'PD003',
                'product_name' => 'Sarung Tangan Latex',
                'price'        => 5000,
                'stock'        => 180,
                'category_id'  => 5,
                'image_url'    => 'img/products/sarung_tangan_latex.jpg',
                'description'  => 'Sarung tangan sekali pakai berbahan latex untuk melindungi tangan.'
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->updateOrInsert(
                ['product_code' => $product['product_code']], // Key untuk cek data
                $product // Data yang akan diupdate/insert
            );
        }
    }
}
