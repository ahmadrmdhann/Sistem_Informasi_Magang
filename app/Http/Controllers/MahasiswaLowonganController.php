<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LowonganModel;
use App\Models\PengajuanMagangModel;

class MahasiswaLowonganController extends Controller
{
    public function index()
    {
        $lowongans = LowonganModel::with(['partner', 'periode'])->latest()->get();
        return view('dashboard.mahasiswa.lowongan.index', compact('lowongans'));
    }

    public function apply(Request $request, $lowongan_id)
    {
        // Ambil user yang login
        $user = Auth::user();
       
        // Ambil relasi mahasiswa dari user
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Akun Anda tidak terhubung ke data mahasiswa.');
        }

        $mahasiswa_id = $mahasiswa->mahasiswa_id;

        // Cek apakah lowongan ada
        $lowongan = LowonganModel::find($lowongan_id);
        if (!$lowongan) {
            return redirect()->back()->with('error', 'Lowongan magang tidak ditemukan.');
        }

        // Cek apakah sudah pernah apply
        $sudahApply = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa_id)
            ->where('lowongan_id', $lowongan_id)
            ->exists();

        if ($sudahApply) {
            return redirect()->back()->with('error', 'Kamu sudah pernah mengajukan ke lowongan ini.');
        }
        
        // Simpan pengajuan
        try {
            PengajuanMagangModel::create([
                'mahasiswa_id'      => $mahasiswa_id,
                'lowongan_id'       => $lowongan_id,
                'tanggal_pengajuan' => now(),
                'status'            => 'diajukan',
            ]);

            return redirect()->back()->with('success', 'Pengajuan magang berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan. ' . $e->getMessage());
        }
    }
}
