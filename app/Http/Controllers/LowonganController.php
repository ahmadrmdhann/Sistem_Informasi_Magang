<?php

namespace App\Http\Controllers;

use App\Models\KeahlianModel;
use App\Models\LokasiModel;
use App\Models\LowonganModel;
use App\Models\PartnerModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = LowonganModel::with(['partner', 'lokasi', 'keahlian', 'periode'])->get();
        $partners = PartnerModel::all();
        $periodes = PeriodeModel::all();
        $kabupatens = LokasiModel::all();
        $keahlians = KeahlianModel::all();
        return view('dashboard.admin.lowongan.index', compact('lowongans', 'partners', 'periodes', 'kabupatens', 'keahlians'));
    }

    public function create()
    {
        $partners = PartnerModel::all();
        $periodes = PeriodeModel::all();
        $lokasis = LokasiModel::all();
        $keahlians = KeahlianModel::alll();
        return view('dashboard.admin.lowongan.create', compact('partners', 'periodes', 'lokasis', 'keahlians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'partner_id'      => 'required|exists:m_partner,partner_id',
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'persyaratan'     => 'required|string',
            'lokasi'          => 'required|exists:m_kota_kabupaten,kabupaten_id',
            'keahlian'        => 'required|exists:m_keahlian,keahlian_id',
            'periode_id'      => 'required|exists:m_periode,periode_id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_akhir'   => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        LowonganModel::create($request->all());

        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $lowongan = LowonganModel::with(['partner', 'periode'])->findOrFail($id);
        return view('dashboard.admin.lowongan.show', compact('lowongan'));
    }

    public function edit($id)
    {
        $lowongan = LowonganModel::findOrFail($id);
        $partners = PartnerModel::all();
        $periodes = PeriodeModel::all();
        $keahlians = KeahlianModel::all();

        return view('dashboard.admin.lowongan.edit', compact('lowongan', 'partners', 'periodes', 'keahlians'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'partner_id'      => 'required|exists:m_partner,partner_id',
            'judul'           => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'persyaratan'     => 'required|string',
            'lokasi'          => 'required|exists:m_kota_kabupaten,kabupaten_id',
            'bidang_keahlian' => 'required|exists:m_keahlian,keahlian_id',
            'periode_id'      => 'required|exists:m_periode,periode_id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_akhir'   => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $lowongan = LowonganModel::findOrFail($id);
        $lowongan->update($request->all());

        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lowongan = LowonganModel::findOrFail($id);
        $lowongan->delete();

        return redirect()->route('lowongan.index')->with('success', 'Lowongan berhasil dihapus.');
    }
}
