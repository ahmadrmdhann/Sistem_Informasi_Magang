<?php

namespace App\Http\Controllers;

use App\Models\DosenModel;
use App\Models\PengajuanMagangModel;
use Illuminate\Http\Request;

class MagangMahasiswaController extends Controller
{
    public function index()
    {
        $pengajuans = PengajuanMagangModel::with([
            'mahasiswa.prodi',
            'mahasiswa.keahlian',
            'mahasiswa.minat',
            'mahasiswa.lokasiPreferensi',
            'lowongan.partner',
            'dosen'
        ])->orderByDesc('created_at')->get();

        $dosens = DosenModel::with('user')->get();

        return view('dashboard.admin.pmm.index', compact('pengajuans', 'dosens'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validation = [
            'status' => 'required|in:diajukan,diterima,ditolak',
        ];

        // Only require dosen_id if status is 'diterima'
        if ($request->status === 'diterima') {
            $validation['dosen_id'] = 'required|exists:m_dosen,dosen_id';
        }

        $request->validate($validation);

        $pengajuan = PengajuanMagangModel::findOrFail($id);

        // Jika status berubah menjadi diterima dan sebelumnya bukan diterima
        if ($request->status === 'diterima' && $pengajuan->status !== 'diterima') {
            $lowongan = $pengajuan->lowongan;
            if ($lowongan && $lowongan->kuota > 0) {
                $lowongan->kuota = $lowongan->kuota - 1;
                $lowongan->save();
            }
        }

        $pengajuan->status = $request->status;

        // Only assign dosen_id if status is 'diterima'
        if ($request->status === 'diterima') {
            $pengajuan->dosen_id = $request->dosen_id;
        } else {
            $pengajuan->dosen_id = null;
        }

        $pengajuan->save();

        return redirect()->back()->with('success', 'Status dan dosen berhasil diperbarui.');
    }
}
