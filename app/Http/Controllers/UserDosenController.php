<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosenModel;
use App\Models\KeahlianModel;
use App\Models\UserModel;

class UserDosenController extends Controller
{
    /**
     * Display a listing of the dosen.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        $dataDosen = DosenModel::with(['user', 'bidang'])->get();
        

        $bidangKeahlian = KeahlianModel::all();
        

        $users = UserModel::where('level_id', 2)

        ->get();

        return view('dashboard.admin.dosen.index', [
            'dataDosen' => $dataDosen,
            'users' => $users,
            'bidangKeahlian' => $bidangKeahlian
        ]);
    }

    /**
     * Store a newly created dosen in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'user_id' => 'required|exists:m_user,user_id|unique:m_dosen,user_id',
            'nidn' => 'required|string|unique:m_dosen,nidn',
            'bidang_minat' => 'required|exists:m_keahlian,keahlian_id',
        ], [
            'user_id.required' => 'User harus dipilih',
            'user_id.exists' => 'User tidak ditemukan',
            'user_id.unique' => 'User sudah terdaftar sebagai dosen',
            'nidn.required' => 'NIDN harus diisi',
            'nidn.unique' => 'NIDN sudah terdaftar',
            'bidang_minat.required' => 'Bidang keahlian harus dipilih',
            'bidang_minat.exists' => 'Bidang keahlian tidak valid',
        ]);

        try {
            // Create new dosen record
            DosenModel::create([
                'user_id' => $validated['user_id'],
                'nidn' => $validated['nidn'],
                'bidang_minat' => $validated['bidang_minat'],
            ]);

            return redirect()->route('dosen.index')
                ->with('success', 'Data dosen berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('dosen.index')
                ->with('error', 'Terjadi kesalahan saat menambahkan data dosen');
        }
    }

    /**
     * Update the specified dosen in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'user_id' => 'required|exists:m_user,user_id|unique:m_dosen,user_id,' . $id . ',dosen_id',
            'nidn' => 'required|string|unique:m_dosen,nidn,' . $id . ',dosen_id',
            'bidang_minat' => 'required|exists:m_keahlian,keahlian_id',
        ], [
            'user_id.required' => 'User harus dipilih',
            'user_id.exists' => 'User tidak ditemukan',
            'user_id.unique' => 'User sudah terdaftar sebagai dosen',
            'nidn.required' => 'NIDN harus diisi',
            'nidn.unique' => 'NIDN sudah terdaftar',
            'bidang_minat.required' => 'Bidang keahlian harus dipilih',
            'bidang_minat.exists' => 'Bidang keahlian tidak valid',
        ]);

        try {
            $dosen = DosenModel::findOrFail($id);
            $dosen->update($validated);

            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data dosen berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('admin.dosen.index')
                ->with('error', 'Terjadi kesalahan saat memperbarui data dosen');
        }
    }

    /**
     * Remove the specified dosen from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dosen = DosenModel::findOrFail($id);
            $dosen->delete();

            return redirect()->route('admin.dosen.index')
                ->with('success', 'Data dosen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.dosen.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data dosen');
        }
    }
}