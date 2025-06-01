<?php

namespace App\Http\Controllers;

use App\Models\PengajuanMagangModel;
use Illuminate\Http\Request;

class MagangMahasiswaController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanMagangModel::with(['mahasiswa', 'lowongan.partner'])->orderByDesc('created_at')->get();
        return view('dashboard.admin.pmm.index', compact('pengajuans'));
    }

    public function updateStatus(Request $request, $mahasiswa_id)
    {
        $request->validate([
            'status' => 'required|in:diajukan,diterima,ditolak',
        ]);

        $pengajuan = PengajuanMagangModel::findOrFail($mahasiswa_id);
        $pengajuan->status = $request->status;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
