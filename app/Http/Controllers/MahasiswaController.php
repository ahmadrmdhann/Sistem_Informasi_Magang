<?php

namespace App\Http\Controllers;

use App\Models\KeahlianMahasiswaModel;
use App\Models\KeahlianModel;
use App\Models\MahasiswaModel;
use App\Models\MinatMahasiswaModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('layouts.dashboard');
    }

    public function profile()
    {
        $mahasiswa = MahasiswaModel::where('user_id', Auth::id())->firstOrFail();
        $prodis = ProdiModel::all();
        $keahlian = KeahlianModel::all();
        return view('dashboard.mahasiswa.profile.index', compact('mahasiswa', 'prodis', 'keahlian'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $user->id,
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'nim' => 'required|string|max:20|unique:m_mahasiswa,nim,' . $mahasiswa->id . ',id',
            'prodi_id' => 'required|exists:m_prodi,prodi_id',
            'keahlian_id' => 'nullable|exists:m_keahlian,keahlian_id',
            'minat_id' => 'nullable|exists:m_keahlian,keahlian_id',
            // tambahkan validasi file jika ada upload file
            // 'sertifikat' => 'nullable|file|mimes:pdf|max:2048',
            // 'cv_file' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Update tabel users
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->save();

        // Update tabel mahasiswa
        $mahasiswa->nim = $request->nim;
        $mahasiswa->prodi_id = $request->prodi_id;
        $mahasiswa->keahlian_id = $request->keahlian_id;
        $mahasiswa->minat_id = $request->minat_id;
        $mahasiswa->save();

        return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('mahasiswa.profile')->with('success', 'Password berhasil diperbarui.');
    }
}
