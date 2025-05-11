<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\LowonganMagang;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::with('lowonganMagang')->get();
        return view('perusahaan.index', compact('perusahaan'));
    }

    public function create()
    {
        return view('perusahaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email' => 'required|email|unique:m_perusahaan,email',
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        Perusahaan::create($data);

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::with('lowonganMagang')->findOrFail($id);
        return view('perusahaan.show', compact('perusahaan'));
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $perusahaan = Perusahaan::findOrFail($id);

        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email' => 'required|email|unique:m_perusahaan,email,' . $perusahaan->id,
            'telepon' => 'nullable|string|max:15',
            'alamat' => 'nullable|string',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $perusahaan->update($data);

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaan.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}