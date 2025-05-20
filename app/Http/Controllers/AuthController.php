<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {

            return redirect()->intended('/dashboard')->with('success', 'Login successful');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postregister(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:m_user,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $levelId = 2;
        $status = 'active';

        DB::table('m_user')->insert([
            'username' => $request->username,
            'level_id' => $levelId,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
