<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use App\Models\LowonganModel;
use App\Models\PartnerModel;
use App\Models\PengajuanMagangModel;
use App\Models\PeriodeModel;
use App\Models\ProdiModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $totalMahasiswa = MahasiswaModel::count() ?? 0;
            $totalDosen = DosenModel::count() ?? 0;
            $totalLowonganAktif = LowonganModel::where('tanggal_akhir', '>=', now())->count() ?? 0;
            $totalMitra = PartnerModel::count() ?? 0;
            $statusDiajukan = PengajuanMagangModel::where('status', 'diajukan')->count();
            $statusDiterima = PengajuanMagangModel::where('status', 'diterima')->count();
            $statusDitolak = PengajuanMagangModel::where('status', 'ditolak')->count();
            $prodiLabels = ProdiModel::pluck('prodi_nama')->toArray();
            $prodiData = [];
            foreach ($prodiLabels as $prodi) {
                $prodiData[] = MahasiswaModel::whereHas('prodi', function($q) use ($prodi) {
                    $q->where('prodi_nama', $prodi);
                })->count();
            }
            $latestPengajuan = PengajuanMagangModel::with(['mahasiswa.user', 'lowongan.partner'])
                ->orderByDesc('created_at')->take(5)->get();
            $popularLowongan = LowonganModel::with('partner')
                ->withCount('pengajuanMagang')
                ->orderByDesc('pengajuan_magang_count')
                ->take(5)->get()
                ->map(function($l) {
                    $l->total_pendaftar = $l->pengajuan_magang_count;
                    return $l;
                });
            $calendarEvents = PeriodeModel::all()->map(function($p) {
                return [
                    'title' => $p->nama,
                    'start' => $p->tanggal_mulai,
                    'end' => $p->tanggal_selesai // gunakan tanggal_selesai sesuai field database
                ];
            });
            $locationData = [];
            // Statistik Review Kegiatan untuk Admin
            $reviewKegiatanStats = [
                'total' => \App\Models\ActivityLogModel::count(),
                'pending' => \App\Models\ActivityLogModel::where('status', 'pending')->count(),
                'approved' => \App\Models\ActivityLogModel::where('status', 'approved')->count(),
                'needs_revision' => \App\Models\ActivityLogModel::where('status', 'needs_revision')->count(),
                'rejected' => \App\Models\ActivityLogModel::where('status', 'rejected')->count(),
            ];
            // Statistik Status Pengajuan Magang
            $statPengajuan = [
                'diajukan' => \App\Models\PengajuanMagangModel::where('status', 'diajukan')->count(),
                'diterima' => \App\Models\PengajuanMagangModel::where('status', 'diterima')->count(),
                'ditolak' => \App\Models\PengajuanMagangModel::where('status', 'ditolak')->count(),
                'total' => \App\Models\PengajuanMagangModel::count(),
            ];
            return view('dashboard.admin.index', compact(
                'totalMahasiswa', 'totalDosen', 'totalLowonganAktif', 'totalMitra',
                'latestPengajuan', 'statusDiajukan', 'statusDiterima', 'statusDitolak',
                'prodiLabels', 'prodiData', 'popularLowongan', 'calendarEvents', 'locationData',
                'reviewKegiatanStats', 'statPengajuan'
            ));
        } catch (\Exception $e) {
            return view('dashboard.admin.index', [
                'error' => $e->getMessage(),
                'totalMahasiswa' => 0,
                'totalDosen' => 0,
                'totalLowonganAktif' => 0,
                'totalMitra' => 0,
                'statusDiajukan' => 0,
                'statusDiterima' => 0,
                'statusDitolak' => 0,
                'prodiLabels' => [],
                'prodiData' => [],
                'latestPengajuan' => collect([]),
                'popularLowongan' => collect([]),
                'calendarEvents' => [],
                'locationData' => [],
                'reviewKegiatanStats' => [
                    'total' => 0,
                    'pending' => 0,
                    'approved' => 0,
                    'needs_revision' => 0,
                    'rejected' => 0,
                ],
                'statPengajuan' => [
                    'diajukan' => 0,
                    'diterima' => 0,
                    'ditolak' => 0,
                    'total' => 0,
                ],
            ]);
        }
    }
}
