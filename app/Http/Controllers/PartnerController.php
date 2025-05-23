<?php


namespace App\Http\Controllers;

use App\Models\PartnerModel;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = PartnerModel::all();
        return view('dashboard.admin.partner.index', compact('partners'));
    }

    public function create()
    {
        return view('dashboard.admin.partner.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'kontak'  => 'nullable|string|max:50',
            'bidang_industri' => 'nullable|string|max:100',
            'alamat'  => 'nullable|string|max:255',
        ]);

        PartnerModel::create($request->only(['nama', 'kontak', 'bidang_industri', 'alamat']));


        return redirect()->route('partner.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $partner = PartnerModel::findOrFail($id);
        return view('dashboard.admin.partner.edit', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'kontak'  => 'nullable|string|max:50',
            'bidang_industri' => 'nullable|string|max:100',
            'alamat'  => 'nullable|string|max:255',
        ]);

        $partner = PartnerModel::findOrFail($id);
        $partner->update($request->all());

        return redirect()->route('partner.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $partner = PartnerModel::findOrFail($id);
        $partner->delete();

        return redirect()->route('partner.index')->with('success', 'Mitra berhasil dihapus.');
    }
}