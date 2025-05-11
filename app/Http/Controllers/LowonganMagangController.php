<?php

namespace App\Http\Controllers;

use App\Models\LowonganMagang;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class LowonganMagangController extends Controller
{
    public function index()
    {
        $lowonganMagang = LowonganMagang::with('perusahaan')->get();
        return view('lowongan.index', compact('lowonganMagang'));
    }

    public function create()
    {
        $perusahaan = Perusahaan::all();
        return view('lowongan.create', compact('perusahaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'perusahaan_id' => 'required|exists:m_perusahaan,id',
            'judul_lowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'sisa_kuota' => 'required|integer|min:0|max:' . $request->kuota,
            'batas_pendaftaran' => 'required|date',
            'status' => 'required|boolean',
        ]);

        LowonganMagang::create($request->all());

        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang berhasil ditambahkan.');
    }

    public function show($id)
    {
        $lowongan = LowonganMagang::with('perusahaan')->findOrFail($id);

        if (request()->ajax()) {
            return view('lowongan.show', compact('lowongan'));
        }

        return view('lowongan.show', compact('lowongan')); // Untuk akses langsung tanpa modal
    }

    public function edit($id)
    {
        $lowongan = LowonganMagang::findOrFail($id);
        $perusahaan = Perusahaan::all();
        return view('lowongan.edit', compact('lowongan', 'perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = LowonganMagang::findOrFail($id);

        $request->validate([
            'perusahaan_id' => 'required|exists:m_perusahaan,id',
            'judul_lowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kuota' => 'required|integer|min:1',
            'sisa_kuota' => 'required|integer|min:0|max:' . $request->kuota,
            'batas_pendaftaran' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $lowongan->update($request->all());

        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lowongan = LowonganMagang::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('lowongan.index')->with('success', 'Lowongan magang berhasil dihapus.');
    }
}