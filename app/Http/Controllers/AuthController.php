<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Usermodel as User;
use App\Models\LevelModel as Level;
use App\Models\UserModel;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        return view('auth.login'); // Tampilkan halaman login
    }

    // Proses login
    public function postlogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Login berhasil
            return redirect('/')->with('success', 'Login berhasil!');
        }

        // Login gagal
        return redirect('login')->withErrors([
            'loginError' => 'Username atau password salah.',
        ]);
    }

    // Menampilkan halaman registrasi
    public function register()
    {
        return view('auth.register'); // Tampilkan halaman registrasi
    }

    // Proses registrasi
    public function postregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|min:3|max:100',
            'username' => 'required|string|min:3|max:20|unique:m_user,username',
            'email' => 'required|email|unique:m_user,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('register')->withErrors($validator)->withInput();
        }

        // Buat user baru
        UserModel::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'level_id' => 2,
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
