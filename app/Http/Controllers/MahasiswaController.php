<?php

namespace App\Http\Controllers;

use App\Models\KeahlianModel;
use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use App\Models\KotaKabupatenModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        $kotaKabupaten = KotaKabupatenModel::orderBy('nama', 'asc')->get();
        return view('dashboard.mahasiswa.profile.index', compact('mahasiswa', 'prodis', 'keahlian', 'kotaKabupaten'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

        $request->validate([
            'username' => 'required|string|max:50|unique:m_user,username,' . $user->user_id . ',user_id',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:m_user,email,' . $user->user_id . ',user_id',
            'nim' => 'required|string|max:20|unique:m_mahasiswa,nim,' . $mahasiswa->mahasiswa_id . ',mahasiswa_id',
            'prodi_id' => 'required|exists:m_prodi,prodi_id',
            'keahlian_id' => 'nullable|exists:m_keahlian,keahlian_id',
            'minat_id' => 'nullable|exists:m_keahlian,keahlian_id',
            'no_telepon' => 'nullable|string|max:15',
            'tentang_saya' => 'nullable|string|max:1000',
            'lokasi_preferensi' => 'nullable|exists:m_kota_kabupaten,kabupaten_id',
            'cv_file' => 'nullable|file|mimes:pdf|max:2048',
            'sertifikat' => 'nullable|string|max:1000',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'prodi_id.required' => 'Jurusan wajib dipilih.',
            'cv_file.mimes' => 'File CV harus berformat PDF.',
            'cv_file.max' => 'Ukuran file CV maksimal 2MB.',
            'lokasi_preferensi.exists' => 'Lokasi preferensi yang dipilih tidak valid.',
        ]);

        try {
            DB::beginTransaction();

            // Handle CV file upload
            if ($request->hasFile('cv_file')) {
                // Create CV directory if it doesn't exist
                $cvUploadPath = public_path('files/cv');
                if (!File::exists($cvUploadPath)) {
                    File::makeDirectory($cvUploadPath, 0755, true);
                }

                // Delete old CV file if exists
                if ($mahasiswa->cv_file) {
                    $oldCvPath = public_path($mahasiswa->cv_file);
                    if (File::exists($oldCvPath)) {
                        File::delete($oldCvPath);
                    }
                }

                $cvFile = $request->file('cv_file');
                $cvFileName = 'cv_' . $user->user_id . '_' . time() . '.pdf';
                $cvFile->move($cvUploadPath, $cvFileName);

                // Save relative path to database
                $mahasiswa->cv_file = 'files/cv/' . $cvFileName;
            }

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
            $mahasiswa->no_telepon = $request->no_telepon;
            $mahasiswa->tentang_saya = $request->tentang_saya;
            $mahasiswa->lokasi_preferensi = $request->lokasi_preferensi;
            $mahasiswa->sertifikat = $request->sertifikat;
            $mahasiswa->save();

            DB::commit();

            return redirect()->route('mahasiswa.profile')->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        try {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('mahasiswa.profile')->with('success', 'Password berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui password.');
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
            $mahasiswa = MahasiswaModel::where('user_id', $user->user_id)->firstOrFail();

            // Create directory if it doesn't exist
            $uploadPath = public_path('images/profile');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Delete old photo if exists
            if ($mahasiswa->foto_profil) {
                $oldPhotoPath = public_path($mahasiswa->foto_profil);
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
            $mahasiswa->foto_profil = $photoPath;
            $mahasiswa->save();

            return redirect()->route('mahasiswa.profile')->with('success', 'Foto profil berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui foto profil: ' . $e->getMessage());
        }
    }
}
