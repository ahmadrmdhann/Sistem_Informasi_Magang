<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periodes = PeriodeModel::all();
        return view('dashboard.admin.periode.index', compact('periodes'));
    }

    public function create()
    {
        return view('dashboard.admin.periode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        PeriodeModel::create($request->only(['nama', 'tanggal_mulai', 'tanggal_selesai']));

        return redirect()->route('periode.index')->with('success', 'Periode berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $periode = PeriodeModel::findOrFail($id);
        return view('dashboard.admin.periode.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $periode = PeriodeModel::findOrFail($id);
        $periode->update($request->only(['nama', 'tanggal_mulai', 'tanggal_selesai']));

        return redirect()->route('periode.index')->with('success', 'Periode berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $periode = PeriodeModel::findOrFail($id);
        $periode->delete();

        return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus.');
    }
}