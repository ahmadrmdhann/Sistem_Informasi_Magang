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
        // Eager load relationships to avoid N+1 queries
        // Assuming UserModel's primary key is 'id' and MahasiswaModel.user_id refers to it.
        $mahasiswa = MahasiswaModel::with(['user', 'prodi'])->where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            // Flash a warning message instead of redirecting
            session()->flash('warning', 'Profil mahasiswa tidak lengkap. Beberapa informasi mungkin tidak dapat ditampilkan. Harap lengkapi profil Anda melalui halaman profil untuk pengalaman terbaik.');
            // $mahasiswa will be null, the view needs to handle this.
        }

        // Mengambil riwayat feedback yang diberikan oleh mahasiswa ini
        // FeedbackModel.mahasiswa_id refers to UserModel.id as per FeedbackModel's relation and comments.
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
            // Tambahkan validasi untuk skor baru jika sudah ada di form
            'skor_pengembangan_hard_skills' => 'required|integer|min:1|max:10',
            'skor_pengembangan_soft_skills' => 'required|integer|min:1|max:10',
            'pelajaran_terbaik' => 'required|string|max:1000',
            'kritik_saran_perusahaan' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        // This check ensures the user is a valid student (Mahasiswa)
        // Even if $mahasiswa was null in create(), we re-fetch or check based on $user for storing.
        // However, the form might be disabled or limited if profile was incomplete.
        // For now, we assume if they can submit, their user_id is valid for feedback.
        // If m_mahasiswa entry is strictly required to *submit* feedback, this check is important.
        $mahasiswaDetails = MahasiswaModel::where('user_id', $user->id)->first();

        if (!$mahasiswaDetails) {
            // This case should ideally be prevented by disabling the form if profile is incomplete.
            // Or, if feedback can be submitted with just user_id, this check might be adjusted.
            return redirect()->back()->with('error', 'Tidak dapat menyimpan umpan balik karena profil mahasiswa tidak lengkap.');
        }

        FeedbackModel::create([
            'mahasiswa_id' => $user->id, // Store the user_id from Auth
            'evaluator' => 'mahasiswa',
            'skor_kesesuaian_tugas' => $request->skor_kesesuaian_tugas,
            'skor_kualitas_bimbingan' => $request->skor_kualitas_bimbingan,
            'skor_beban_kerja' => $request->skor_beban_kerja,
            'skor_suasana_kerja' => $request->skor_suasana_kerja,
            'skor_pengembangan_hard_skills' => $request->skor_pengembangan_hard_skills,
            'skor_pengembangan_soft_skills' => $request->skor_pengembangan_soft_skills,
            'pelajaran_terbaik' => $request->pelajaran_terbaik,
            'kritik_saran_perusahaan' => $request->kritik_saran_perusahaan,
            'tanggal' => now(),
        ]);

        return redirect()->route('mahasiswa.feedback.create', ['#riwayat'])->with('success', 'Umpan balik berhasil dikirim. Terima kasih atas masukan Anda!');
    }
}
