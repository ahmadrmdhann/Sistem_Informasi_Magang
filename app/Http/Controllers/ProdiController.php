<?php

namespace App\Http\Controllers;

use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdiController extends Controller
{
    /**
     * Menampilkan daftar prodi
     */
    public function index()
    {
        $prodis = ProdiModel::orderBy('prodi_nama', 'asc')->get();
        return view('dashboard.admin.prodi.index', compact('prodis'));
    }

    /**
     * Menampilkan form untuk membuat prodi baru
     */
    public function create()
    {
        return view('dashboard.admin.prodi.create');
    }

    /**
     * Menyimpan prodi baru ke database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prodi_nama' => 'required|string|max:255',
            'prodi_kode' => 'required|string|max:20|unique:m_prodi,prodi_kode',
        ]);

        if ($validator->fails()) {
            return redirect()->route('prodi.create')
                ->withErrors($validator)
                ->withInput();
        }

        ProdiModel::create([
            'prodi_nama' => $request->prodi_nama,
            'prodi_kode' => $request->prodi_kode,
        ]);

        return redirect()->route('prodi.index')
            ->with('success', 'Program Studi berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit prodi
     */
    public function edit($id)
    {
        $prodi = ProdiModel::findOrFail($id);
        return view('dashboard.admin.prodi.edit', compact('prodi'));
    }

    /**
     * Mengupdate data prodi di database
     */
    public function update(Request $request, $id)
    {
        $prodi = ProdiModel::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'prodi_nama' => 'required|string|max:255',
            'prodi_kode' => 'required|string|max:20|unique:m_prodi,prodi_kode,' . $id . ',prodi_id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('prodi.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $prodi->update([
            'prodi_nama' => $request->prodi_nama,
            'prodi_kode' => $request->prodi_kode,
        ]);

        return redirect()->route('prodi.index')
            ->with('success', 'Program Studi berhasil diperbarui.');
    }

    /**
     * Menghapus prodi dari database
     */
    public function destroy($id)
    {
        $prodi = ProdiModel::findOrFail($id);
        $prodi->delete();

        return redirect()->route('prodi.index')
            ->with('success', 'Program Studi berhasil dihapus.');
    }
}