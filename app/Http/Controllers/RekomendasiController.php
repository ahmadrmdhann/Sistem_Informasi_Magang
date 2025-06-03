<?php

namespace App\Http\Controllers;

use App\Models\LokasiModel;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function index()
    {
        return view('dashboard.mahasiswa.rekomendasi.index');
    }
}
