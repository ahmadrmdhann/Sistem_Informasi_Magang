<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\PengajuanMagangModel;
use Illuminate\Http\Request;

class MagangMahasiswaController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanMagangModel::with(['mahasiswa', 'lowongan.partner', 'dosen'])->orderByDesc('created_at')->get();
        $dosens = DosenModel::with('user')->get();
        return view('dashboard.admin.pmm.index', compact('pengajuans', 'dosens'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:diajukan,diterima,ditolak',
        'dosen_id' => 'required|exists:m_dosen,dosen_id',
    ]);

    $pengajuan = PengajuanMagangModel::findOrFail($id);
    $pengajuan->status = $request->status;
    $pengajuan->dosen_id = $request->dosen_id;
    $pengajuan->save();

    return redirect()->back()->with('success', 'Status dan dosen berhasil diperbarui.');
}

    

}
