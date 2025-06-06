<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PengajuanMagangModel;

class MahasiswaBimbingan extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pastikan user punya relasi dosen
        if (!$user->dosen) {
            abort(403, 'Akun ini bukan dosen.');
        }

        $dosenId = $user->dosen->dosen_id;

        $bimbingans = PengajuanMagangModel::with(['lowongan', 'mahasiswa', 'dosen'])
            ->where('dosen_id', $dosenId)
            ->get();

        return view('dashboard.dosen.mhsbimbingan.index', compact('bimbingans'));
    }
}
