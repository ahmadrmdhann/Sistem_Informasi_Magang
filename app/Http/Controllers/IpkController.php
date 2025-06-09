<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MahasiswaModel;

class IpkController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $mahasiswas = MahasiswaModel::with(['user'])
            ->when($q, function($query) use ($q) {
                $query->where('nim', 'like', "%$q%")
                      ->orWhereHas('user', function($q2) use ($q) {
                          $q2->where('nama', 'like', "%$q%");
                      });
            })
            ->orderBy('nim')
            ->get();

        return view('dashboard.admin.ipk.index', compact('mahasiswas', 'q'));
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = MahasiswaModel::findOrFail($id);

        $request->validate([
            'ipk' => 'required|numeric|min:0|max:4',
        ], [
            'ipk.required' => 'IPK wajib diisi.',
            'ipk.numeric' => 'IPK harus berupa angka.',
            'ipk.min' => 'IPK minimal 0.',
            'ipk.max' => 'IPK maksimal 4.',
        ]);

        $mahasiswa->ipk = $request->ipk;
        $mahasiswa->save();

        // Jika request AJAX (modal), response JSON
        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('ipk.index')->with('success', 'IPK berhasil diupdate.');
    }
}