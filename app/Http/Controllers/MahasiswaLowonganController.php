<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LowonganModel;
use App\Models\PengajuanMagangModel;
use App\Services\NotificationService;
use Carbon\Carbon;

class MahasiswaLowonganController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // ----------- CEK KELENGKAPAN PROFIL ---------
        $profileIncomplete = false;
        $profileWarning = [];
        if (!$mahasiswa) {
            $profileIncomplete = true;
            $profileWarning[] = "Data mahasiswa belum ditemukan.";
        } else {
            if (!$mahasiswa->cv_file) $profileWarning[] = "CV belum diunggah.";
            if (!$mahasiswa->keahlian_id) $profileWarning[] = "Keahlian belum dipilih.";
            if (!$mahasiswa->prodi_id) $profileWarning[] = "Prodi belum dipilih.";
            $profileIncomplete = count($profileWarning) > 0;
        }

        // ----------- SEARCH LOWONGAN ------------
        $q = $request->input('q');
        $today = Carbon::today()->toDateString();
        $lowongans = LowonganModel::with(['partner', 'periode', 'kabupaten', 'keahlian'])
            ->where('kuota', '>', 0)
            ->where('tanggal_akhir', '>=', $today) // Tambahkan filter tanggal akhir
            ->when($q, function ($query) use ($q) {
                $query->where('judul', 'like', "%$q%")
                    ->orWhereHas('partner', function($q2) use ($q) {
                        $q2->where('nama', 'like', "%$q%");
                    })
                    ->orWhereHas('keahlian', function($q3) use ($q) {
                        $q3->where('nama', 'like', "%$q%");
                    });
            })
            ->latest()
            ->get();

        // ----------- DATA APPLIED --------------
        $applieds = [];
        if ($mahasiswa) {
            $applieds = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)
                ->pluck('lowongan_id')
                ->toArray();
        }

        return view('dashboard.mahasiswa.lowongan.index', compact(
            'lowongans', 'applieds', 'profileIncomplete', 'profileWarning', 'q'
        ));
    }

    public function apply(Request $request, $lowongan_id)
    {
        // Ambil user yang login
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Akun Anda tidak terhubung ke data mahasiswa.');
        }

        // Cegah apply jika profil belum lengkap
        if (!$mahasiswa->cv_file || !$mahasiswa->keahlian_id || !$mahasiswa->prodi_id) {
            return redirect()->back()->with('error', 'Lengkapi profile (CV, keahlian, prodi) sebelum apply.');
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
            $pengajuan = PengajuanMagangModel::create([
                'mahasiswa_id'      => $mahasiswa_id,
                'lowongan_id'       => $lowongan_id,
                'tanggal_pengajuan' => now(),
                'status'            => 'diajukan',
            ]);

            // Send notification to admin about new pengajuan
            NotificationService::notifyAdminNewPengajuan($pengajuan);

            return redirect()->back()->with('success', 'Pengajuan magang berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pengajuan. ' . $e->getMessage());
        }
    }
}
