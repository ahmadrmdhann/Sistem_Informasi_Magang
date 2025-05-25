<?php

namespace App\Http\Controllers;
use App\Models\MagangMahasiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LowonganModel;

class MagangMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar lowongan beserta partner dan periode
        $lowongans = LowonganModel::with('partner')->get();

        // Ambil status pengajuan mahasiswa
        $pengajuans = MagangMahasiswaModel::with(['lowongan.partner', 'periode'])
            ->where('mahasiswa_id', auth()->user()->id)
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.mahasiswa.pengajuan', compact('lowongans', 'pengajuans'));
    }
}