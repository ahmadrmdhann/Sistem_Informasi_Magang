<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LowonganModel;
use App\Models\PengajuanMagangModel;

class MahasiswaBimbingan extends Controller{
    public function index(){
        $user = Auth::user();
        $dosen = $user->dosen;

        $bimbingans = PengajuanMagangModel::with('lowongan', 'mahasiswa', 'dosen')->get();
        return view('dashboard.dosen.mhsbimbingan.index', compact('bimbingans'));
    }
}