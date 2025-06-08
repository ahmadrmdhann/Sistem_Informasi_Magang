<?php

namespace App\Http\Controllers;

use App\Models\PengajuanMagangModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PengajuanMagangController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar lowongan beserta partner dan periode
        $lowongans = DB::table('m_lowongan')
            ->join('m_partner', 'm_lowongan.partner_id', '=', 'm_partner.partner_id')
            ->select('m_lowongan.*', 'm_partner.nama as partner_nama')
            ->get();

        $periodes = PeriodeModel::all();


        $mahasiswa = auth()->user()->mahasiswa;
        $pengajuans = PengajuanMagangModel::with(['mahasiswa', 'lowongan.partner', ])
        ->where('mahasiswa_id', $mahasiswa->mahasiswa_id)
        ->orderByDesc('created_at')
        ->get();
    
    
        return view('dashboard.mahasiswa.pengajuan', compact('lowongans', 'periodes', 'pengajuans'));
    }
}
