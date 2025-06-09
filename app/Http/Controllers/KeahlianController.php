<?php

namespace App\Http\Controllers;

use App\Models\KeahlianModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeahlianController extends Controller
{
    /**
     * Menampilkan daftar keahlian
     */
    public function index()
    {
        $keahlians = KeahlianModel::orderBy('nama', 'asc')->get();
        return view('dashboard.admin.keahlian.index', compact('keahlians'));
    }

    /**
     * Menampilkan form untuk membuat keahlian baru
     */
    public function create()
    {
        return view('dashboard.admin.keahlian.create');
    }

    /**
     * Menyimpan keahlian baru ke database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:m_keahlian,nama',
        ]);

        if ($validator->fails()) {
            return redirect()->route('keahlian.create')
                ->withErrors($validator)
                ->withInput();
        }

        KeahlianModel::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('keahlian.index')
            ->with('success', 'Keahlian berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit keahlian
     */
    public function edit($id)
    {
        $keahlian = KeahlianModel::findOrFail($id);
        return view('dashboard.admin.keahlian.edit', compact('keahlian'));
    }

    /**
     * Mengupdate data keahlian di database
     */
    public function update(Request $request, $id)
    {
        $keahlian = KeahlianModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:m_keahlian,nama,' . $id . ',keahlian_id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('keahlian.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $keahlian->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('keahlian.index')
            ->with('success', 'Keahlian berhasil diperbarui.');
    }

    /**
     * Menghapus keahlian dari database
     */
    public function destroy($id)
    {
        $keahlian = KeahlianModel::findOrFail($id);
        $keahlian->delete();

        return redirect()->route('keahlian.index')
            ->with('success', 'Keahlian berhasil dihapus.');
    }
}
