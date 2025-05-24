<?php

namespace App\Http\Controllers;

use App\Models\PartnerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    /**
     * Menampilkan daftar partner
     */
    public function index()
    {
        $partners = PartnerModel::orderBy('nama', 'asc')->get();
        return view('dashboard.partner.index', compact('partners'));
    }

    /**
     * Menampilkan form untuk membuat partner baru
     */
    public function create()
    {
        return view('dashboard.partner.create');
    }

    /**
     * Menyimpan partner baru ke database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:m_partner,nama',
            'email' => 'required|email|max:255|unique:m_partner,email',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('partner.create')
                ->withErrors($validator)
                ->withInput();
        }

        PartnerModel::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('partner.index')
            ->with('success', 'Partner berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit partner
     */
    public function edit($id)
    {
        $partner = PartnerModel::findOrFail($id);
        return view('dashboard.partner.edit', compact('partner'));
    }

    /**
     * Mengupdate data partner di database
     */
    public function update(Request $request, $id)
    {
        $partner = PartnerModel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:m_partner,nama,' . $id . ',partner_id',
            'email' => 'required|email|max:255|unique:m_partner,email,' . $id . ',partner_id',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('partner.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $partner->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('partner.index')
            ->with('success', 'Partner berhasil diperbarui.');
    }

    /**
     * Menghapus partner dari database
     */
    public function destroy($id)
    {
        $partner = PartnerModel::findOrFail($id);
        $partner->delete();

        return redirect()->route('partner.index')
            ->with('success', 'Partner berhasil dihapus.');
    }
}
