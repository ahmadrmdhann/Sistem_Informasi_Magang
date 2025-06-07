<?php

namespace App\Http\Controllers;

use App\Models\FeedbackModel;
use App\Models\MahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Show the form for creating a new feedback.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        $user = Auth::user();
        $mahasiswa = MahasiswaModel::with(['user', 'prodi'])->where('user_id', $user->id)->first();

        // View akan menangani jika $mahasiswa null atau profil tidak lengkap
        // Pesan peringatan bisa ditampilkan langsung di view jika $mahasiswa tidak lengkap

        $riwayatFeedback = FeedbackModel::where('mahasiswa_id', $user->id)
            ->where('evaluator', 'mahasiswa')
            ->orderBy('tanggal', 'desc')
            ->paginate(5);

        return view('dashboard.mahasiswa.feedback.create', compact('mahasiswa', 'riwayatFeedback'));
    }

    /**
     * Store a newly created feedback in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'skor_kesesuaian_tugas' => 'required|integer|min:1|max:10',
            'skor_kualitas_bimbingan' => 'required|integer|min:1|max:10',
            'skor_beban_kerja' => 'required|integer|min:1|max:10',
            'skor_suasana_kerja' => 'required|integer|min:1|max:10',
            'skor_pengembangan_hard_skills' => 'required|integer|min:1|max:10',
            'skor_pengembangan_soft_skills' => 'required|integer|min:1|max:10',
            'pelajaran_terbaik' => 'required|string|max:2000',
            'kritik_saran_perusahaan' => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        // Pastikan user memiliki entri di m_mahasiswa
        $mahasiswaExists = MahasiswaModel::where('user_id', $user->id)->exists();

        if (!$mahasiswaExists) {
            return redirect()->back()->with('error', 'Profil mahasiswa tidak ditemukan. Tidak dapat menyimpan umpan balik.');
        }

        FeedbackModel::create([
            'mahasiswa_id' => $user->id, // Sesuai dengan relasi di FeedbackModel dan migrasi
            'evaluator' => 'mahasiswa',
            'tanggal' => now(),
            'skor_kesesuaian_tugas' => $request->skor_kesesuaian_tugas,
            'skor_kualitas_bimbingan' => $request->skor_kualitas_bimbingan,
            'skor_beban_kerja' => $request->skor_beban_kerja,
            'skor_suasana_kerja' => $request->skor_suasana_kerja,
            'skor_pengembangan_hard_skills' => $request->skor_pengembangan_hard_skills,
            'skor_pengembangan_soft_skills' => $request->skor_pengembangan_soft_skills,
            'pelajaran_terbaik' => $request->pelajaran_terbaik,
            'kritik_saran_perusahaan' => $request->kritik_saran_perusahaan,
            // 'komentar' tidak diisi karena sudah ada field spesifik untuk feedback kualitatif
        ]);

        return redirect()->route('mahasiswa.feedback.create', ['#riwayat'])->with('success', 'Umpan balik berhasil dikirim. Terima kasih atas masukan Anda!');
    }
}
