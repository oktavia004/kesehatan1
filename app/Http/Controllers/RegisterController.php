<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register'); // tampilkan form register
    }

    public function store(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:6',
            'email'    => 'required|email|unique:users,email',
            'gender'   => 'required|in:Male,Female',
        ]);

        // ✅ Insert ke database tanpa created_at/updated_at
        DB::table('users')->insert([
            'username'      => $request->username,
            'password'      => Hash::make($request->password), // hash password
            'email'         => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'gender'        => $request->gender,
            'address'       => $request->address,
            'city'          => $request->city,
            'contact_no'    => $request->contact_no,
            'paypal_id'     => $request->paypal_id,
            'role'          => 'customer', // 👈 otomatis jadi customer
        ]);

        // ✅ Redirect ke login dengan pesan sukses
        return redirect()->route('login.show')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
