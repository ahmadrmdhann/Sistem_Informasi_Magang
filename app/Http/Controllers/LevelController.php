<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    /**
     * Menampilkan daftar level
     */
    public function index()
    {
        $levels = LevelModel::orderBy('level_nama', 'asc')->get();
        return view('dashboard.admin.level.index', compact('levels'));
    }

    /**
     * Menampilkan form untuk membuat level baru
     */
    public function create()
    {
        return view('dashboard.admin.level.create');
    }

    /**
     * Menyimpan level baru ke database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'level_nama' => 'required|string|max:255|unique:m_level,level_nama',
        ]);

        if ($validator->fails()) {
            return redirect()->route('level.create')
                ->withErrors($validator)
                ->withInput();
        }

        LevelModel::create([
            'level_nama' => $request->level_nama,
        ]);

        return redirect()->route('level.index')
            ->with('success', 'Level berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit level
     */
    public function edit($id)
    {
        $level = LevelModel::findOrFail($id);
        return view('dashboard.admin.level.edit', compact('level'));
    }

    /**
     * Mengupdate data level di database
     */
    public function update(Request $request, $id)
    {
        $level = LevelModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'level_nama' => 'required|string|max:255|unique:m_level,level_nama,' . $id . ',id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('level.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $level->update([
            'level_nama' => $request->level_nama,
        ]);

        return redirect()->route('level.index')
            ->with('success', 'Level berhasil diperbarui.');
    }

    /**
     * Menghapus level dari database
     */
    public function destroy($id)
    {
        $level = LevelModel::findOrFail($id);
        $level->delete();

        return redirect()->route('level.index')
            ->with('success', 'Level berhasil dihapus.');
    }
}