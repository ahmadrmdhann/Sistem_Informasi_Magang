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
        
        // Get user model
        $userModel = app(\App\Models\UserModel::class);
        
        // Get counts by level
        $mahasiswa_count = $userModel->whereHas('level', function($query) {
            $query->where('level_kode', 'MHS');
        })->count();
        
        $dosen_count = $userModel->whereHas('level', function($query) {
            $query->where('level_kode', 'DSN');
        })->count();

        return view('dashboard.admin.prodi.index', compact('prodis', 'mahasiswa_count', 'dosen_count'));
    }

    /**
     * Menampilkan form untuk membuat prodi baru
     */
    public function create()
    {
        return view('dashboard.admin.prodi.create');
    }

    /**
     * Menampilkan data prodi (untuk AJAX show)
     */
    public function show($id)
    {
        $prodi = ProdiModel::findOrFail($id);
        if (request()->ajax()) {
            return response()->json($prodi);
        }
        return view('dashboard.admin.prodi.show', compact('prodi'));
    }

    /**
     * Menyimpan prodi baru ke database (AJAX support)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prodi_nama' => 'required|string|max:255',
            'prodi_kode' => 'required|string|max:20|unique:m_prodi,prodi_kode',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->route('prodi.create')
                ->withErrors($validator)
                ->withInput();
        }

        $prodi = ProdiModel::create([
            'prodi_nama' => $request->prodi_nama,
            'prodi_kode' => $request->prodi_kode,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Program Studi berhasil ditambahkan.', 'data' => $prodi]);
        }
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
     * Mengupdate data prodi di database (AJAX support)
     */
    public function update(Request $request, string $id)
    {
        $prodi = ProdiModel::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'prodi_nama' => 'required|string|max:255',
            'prodi_kode' => 'required|string|max:20|unique:m_prodi,prodi_kode,' . $id . ',prodi_id',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->route('prodi.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $prodi->update([
            'prodi_nama' => $request->prodi_nama,
            'prodi_kode' => $request->prodi_kode,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => 'Program Studi berhasil diperbarui.', 'data' => $prodi]);
        }
        return redirect()->route('prodi.index')
            ->with('success', 'Program Studi berhasil diperbarui.');
    }

    /**
     * Menghapus prodi dari database (AJAX support)
     */
    public function destroy($id)
    {
        $prodi = ProdiModel::findOrFail($id);
        $prodi->delete();

        if (request()->ajax()) {
            return response()->json(['success' => 'Program Studi berhasil dihapus.']);
        }
        return redirect()->route('prodi.index')
            ->with('success', 'Program Studi berhasil dihapus.');
    }
}