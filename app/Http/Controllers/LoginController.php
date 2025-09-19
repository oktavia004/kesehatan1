<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function process(Request $request)
    {
        // cari user berdasarkan username
        $user = DB::table('users')->where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // simpan session
            Session::put('user_id', $user->user_id);
            Session::put('username', $user->username);
            Session::put('role', $user->role); // 👈 simpan role juga

            // redirect sesuai role
if ($user->role === 'admin') {
    return redirect()->route('admin.dashboard');
} elseif ($user->role === 'customer') {
    return redirect()->route('dashboard');
} else {
       return redirect()->route('home'); // visitor
}
        }

        return back()->withErrors(['loginError' => 'Username atau Password salah!']);
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login.show');
    }
}