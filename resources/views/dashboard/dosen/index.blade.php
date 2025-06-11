@extends('layouts.dashboard')

@section('title', 'Dashboard Dosen')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6">Selamat Datang, {{ Auth::user()->nama }}</h1>

            <!-- Notifikasi Cepat -->
            @if(isset($pengajuanBaru) && $pengajuanBaru > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-bell text-yellow-500 text-2xl mr-4"></i>
                    <div>
                        <p class="font-semibold text-yellow-800">Ada {{ $pengajuanBaru }} pengajuan magang mahasiswa bimbingan
                            yang perlu ditinjau!</p>
                        <p class="text-sm text-yellow-700">Segera cek pengajuan magang mahasiswa bimbingan Anda.</p>
                    </div>
                </div>
            @endif

            <!-- Statistik Ringkas (Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <i class="fas fa-user-graduate text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Mahasiswa Bimbingan</p>
                            <h3 class="font-bold text-2xl">{{ $totalMahasiswaBimbingan }}</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <i class="fas fa-check-circle text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Pengajuan Diterima</p>
                            <h3 class="font-bold text-2xl">{{ $pengajuanDiterima }}</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <i class="fas fa-clock text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Pengajuan Diproses</p>
                            <h3 class="font-bold text-2xl">{{ $pengajuanDiajukan }}</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 mr-4">
                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Pengajuan Ditolak</p>
                            <h3 class="font-bold text-2xl">{{ $pengajuanDitolak }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Kegiatan Statistics -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <h2 class="text-lg font-bold mb-4">Statistik Review Kegiatan Mahasiswa</h2>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="text-center p-3 bg-gray-50 rounded-lg">
                        <div class="text-2xl font-bold text-gray-700">{{ $reviewKegiatanStats['total'] }}</div>
                        <div class="text-sm text-gray-500">Total Kegiatan</div>
                    </div>
                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-700">{{ $reviewKegiatanStats['pending'] }}</div>
                        <div class="text-sm text-yellow-600">Pending Review</div>
                    </div>
                    <div class="text-center p-3 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-700">{{ $reviewKegiatanStats['approved'] }}</div>
                        <div class="text-sm text-green-600">Disetujui</div>
                    </div>
                    <div class="text-center p-3 bg-orange-50 rounded-lg">
                        <div class="text-2xl font-bold text-orange-700">{{ $reviewKegiatanStats['needs_revision'] }}</div>
                        <div class="text-sm text-orange-600">Perlu Revisi</div>
                    </div>
                    <div class="text-center p-3 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-700">{{ $reviewKegiatanStats['rejected'] }}</div>
                        <div class="text-sm text-red-600">Ditolak</div>
                    </div>
                </div>
            </div>

            <!-- Pengajuan Magang Mahasiswa Bimbingan Terbaru -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Pengajuan Magang Mahasiswa Bimbingan Terbaru</h2>
                    <a href="{{ route("dosen.mhsbimbingan.index") }}"
                        class="text-blue-600 hover:underline text-base font-semibold">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden shadow">
                        <thead class="bg-gray-100 border-b-2 border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Mahasiswa</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Lowongan</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Mitra</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Tanggal</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengajuanTerbaru as $pengajuan)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">{{ $pengajuan->mahasiswa->user->nama ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $pengajuan->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' :
                                ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-700' :
                                    'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 px-4 text-center text-gray-500">Tidak ada pengajuan terbaru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Review Kegiatan Mahasiswa Bimbingan Terbaru -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Review Kegiatan Mahasiswa Bimbingan Terbaru</h2>
                    <a href="{{ route('dosen.review-kegiatan.index') }}" class="text-blue-600 hover:underline text-base font-semibold">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden shadow">
                        <thead class="bg-gray-100 border-b-2 border-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Mahasiswa</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Lowongan</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Mitra</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Tanggal</th>
                                <th class="py-3 px-4 text-left font-semibold text-gray-700">Status Review</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviewKegiatanTerbaru as $review)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-3 px-4">{{ $review->mahasiswa->user->nama ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $review->pengajuan->lowongan->judul ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $review->pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($review->activity_date)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $review->status === 'approved' ? 'bg-green-100 text-green-700' :
                                                ($review->status === 'needs_revision' ? 'bg-orange-100 text-orange-700' :
                                                ($review->status === 'rejected' ? 'bg-red-100 text-red-700' :
                                                'bg-yellow-100 text-yellow-700')) }}">
                                            {{ $review->status === 'approved' ? 'Disetujui' :
                                                ($review->status === 'needs_revision' ? 'Perlu Revisi' :
                                                ($review->status === 'rejected' ? 'Ditolak' : 'Pending')) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Belum ada review kegiatan terbaru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- To-Do List Dosen -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-bold mb-4">Checklist Dosen</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li class="flex items-center"><i class="fas fa-user-check text-blue-400 mr-2"></i> Review pengajuan magang mahasiswa bimbingan</li>
                    <li class="flex items-center"><i class="fas fa-tasks text-green-400 mr-2"></i> Review log kegiatan mahasiswa</li>
                    <li class="flex items-center"><i class="fas fa-star text-yellow-400 mr-2"></i> Berikan feedback/penilaian magang</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
