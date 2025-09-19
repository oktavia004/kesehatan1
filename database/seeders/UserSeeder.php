<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'email' => 'admin@gmail.com',
                'date_of_birth' => '1990-01-01',
                'gender' => 'Male',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Jakarta',
                'contact_no' => '08123456789',
                'paypal_id' => 'admin-paypal@example.com',
                'role' => 'admin', // Admin role
            ],
            [
                'username' => 'okta',
                'password' => Hash::make('okta12345'),
                'email' => 'user1@example.com',
                'date_of_birth' => '2000-05-20',
                'gender' => 'Female',
                'address' => 'Jl. Mawar No. 2',
                'city' => 'Surabaya',
                'contact_no' => '08234567890',
                'paypal_id' => 'okta-paypal@example.com',
                'role' => 'customer', // Customer role
            ],
            [
                'username' => 'visit',
                'password' => Hash::make('visit12345'),
                'email' => 'user2@example.com',
                'date_of_birth' => '1998-08-15',
                'gender' => 'Male',
                'address' => 'Jl. Melati No. 3',
                'city' => 'Bandung',
                'contact_no' => '08345678901',
                'paypal_id' => 'visit-paypal@example.com',
                'role' => 'visitor', // Visitor role
            ],
        ]);
    }
}
