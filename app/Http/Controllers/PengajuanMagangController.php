<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanMagangController extends Controller
{
    public function index(Request $request)
    {
        // Ambil daftar lowongan beserta partner dan periode
        $lowongans = DB::table('m_lowongan')
        ->join('m_partner', 'm_lowongan.partner_id', '=', 'm_partner.partner_id')
        ->select('m_lowongan.*', 'm_partner.nama as partner_nama')
        ->get();

        $periodes = DB::table('m_periode')->get();

        // Ambil status pengajuan mahasiswa
        $pengajuans = DB::table('m_pengajuan_magang')
        ->join('m_lowongan', 'm_pengajuan_magang.lowongan_id', '=', 'm_lowongan.lowongan_id')
        ->join('m_partner', 'm_lowongan.partner_id', '=', 'm_partner.partner_id')
        ->select('m_pengajuan_magang.*', 'm_lowongan.judul as lowongan_judul', 'm_partner.nama as partner_nama')
        ->where('m_pengajuan_magang.mahasiswa_id', auth()->user()->id)
        ->orderByDesc('m_pengajuan_magang.created_at')
        ->get();

        return view('dashboard.mahasiswa.pengajuan', compact('lowongans', 'periodes', 'pengajuans'));
    }
}
