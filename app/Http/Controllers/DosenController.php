<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use Illuminate\Http\Request;
use App\Models\KeahlianModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index()
    {
        return view('layouts.dashboard');
    }

    public function profile()
    {
        $dosen = DosenModel::where('user_id', Auth::id())->firstOrFail();
        $keahlian = KeahlianModel::all();
        return view('dashboard.dosen.profile.index', compact('keahlian', 'dosen'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'username' => 'required|string|max:50|unique:m_user,username,' . $user->user_id . ',user_id',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:m_user,email,' . $user->user_id . ',user_id',
            'nidn' => 'required|string|max:20|unique:m_dosen,nidn,' . $dosen->dosen_id . ',dosen_id',
            'bidang_minat' => 'nullable|exists:m_keahlian,keahlian_id',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nidn.required' => 'NIDN wajib diisi.',
            'nidn.unique' => 'NIDN sudah digunakan.',
            'bidang_minat.exists' => 'Bidang minat tidak valid.',
        ]);

        try {
            // Update user data
            $user->username = $request->username;
            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->save();

            // Update dosen data
            $dosen->nidn = $request->nidn;
            $dosen->bidang_minat = $request->bidang_minat; // Fixed: should be bidang_minat, not keahlian_id
            $dosen->save();

            return redirect()->route('dosen.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = Auth::user();

            // Check if current password is correct
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Password saat ini tidak benar.');
            }

            // Update password
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('dosen.profile')->with('success', 'Password berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah password: ' . $e->getMessage());
        }
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'foto_profil.required' => 'Foto profil wajib dipilih.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'foto_profil.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $user = Auth::user();
            $dosen = DosenModel::where('user_id', $user->user_id)->firstOrFail();

            // Create directory if it doesn't exist
            $uploadPath = public_path('images/profile');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Delete old photo if exists
            if ($dosen->foto_profil) {
                $oldPhotoPath = public_path($dosen->foto_profil);
                if (File::exists($oldPhotoPath)) {
                    File::delete($oldPhotoPath);
                }
            }

            $photo = $request->file('foto_profil');
            $photoExtension = $photo->getClientOriginalExtension();
            $photoName = 'profile_' . $user->user_id . '_' . time() . '.' . $photoExtension;

            // Move file to public directory
            $photo->move($uploadPath, $photoName);

            // Save relative path to database (for use with asset() helper)
            $photoPath = 'images/profile/' . $photoName;
            $dosen->foto_profil = $photoPath;
            $dosen->save();

            return redirect()->route('dosen.profile')->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui foto profil: ' . $e->getMessage());
        }
    }
}