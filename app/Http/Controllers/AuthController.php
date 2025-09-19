<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    // 🟢 Tampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // 🟢 Proses login DENGAN USER_ID
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => ['required', 'string'], // ✅ Gunakan user_id bukan email
            'password' => ['required'],
        ]);

        // Cari user berdasarkan user_id
        $user = User::where('user_id', $credentials['user_id'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Login manual dengan session
            Session::put('user_id', $user->user_id);
            Session::put('username', $user->username);
            Session::put('role', $user->role); // Simpan role juga di session

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'customer') {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('visitor.page');
            }
        }

        return back()->withErrors([
            'user_id' => 'User ID atau password salah.',
        ])->withInput($request->only('user_id'));
    }

    // 🟢 Tampilkan halaman register
    public function showRegister()
    {
        return view('register');
    }

    // 🟢 Proses register (PERLU DIPERBAIKI juga untuk generate user_id)
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'user_id' => ['required', 'string', 'unique:users,user_id'], // ✅ Tambahkan user_id
            'password' => ['required', 'min:6', 'confirmed'],
            'gender' => ['required'],
        ]);

        // Buat user baru
        $user = User::create([
            'user_id' => $data['user_id'], // ✅ Simpan user_id
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'gender' => $data['gender'],
            'role' => 'customer', // default customer
            'email' => $data['user_id'] . '@example.com', // Default email atau biarkan null
        ]);

        // Login manual setelah register
        Session::put('user_id', $user->user_id);
        Session::put('username', $user->username);
        Session::put('role', $user->role);

        return redirect()->route('dashboard');
    }

    // 🟢 Logout user
    public function logout(Request $request)
    {
        // Hapus session manual
        Session::forget('user_id');
        Session::forget('username');
        Session::forget('role');
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show');
    }
}