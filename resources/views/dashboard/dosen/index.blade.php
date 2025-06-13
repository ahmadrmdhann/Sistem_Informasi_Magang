@extends('layouts.dashboard')

@section('title', 'Dashboard Dosen')

@section('content')
    <div id="mainContent" class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6 py-8">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Selamat Datang!</h1>
                            <p class="text-xl text-white/90">{{ Auth::user()->nama }}</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-lg max-w-2xl">
                        Kelola dan pantau progress magang mahasiswa bimbingan Anda dengan mudah dan efisien.
                    </p>
                </div>
            </div>

            <!-- Notifikasi Cepat -->
            @if(isset($pengajuanBaru) && $pengajuanBaru > 0)
                <div class="bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl p-6 mb-8 shadow-lg transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-bell text-white text-xl animate-pulse"></i>
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-white text-lg">{{ $pengajuanBaru }} Pengajuan Baru!</p>
                            <p class="text-white/90">Ada pengajuan magang mahasiswa bimbingan yang perlu ditinjau</p>
                        </div>
                        <div class="ml-4">
                            <button class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300 backdrop-blur-sm">
                                Lihat Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Statistik Ringkas (Cards) -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Statistik Dashboard</h2>
                    <p class="text-gray-600">Overview pengajuan dan bimbingan mahasiswa</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-graduate text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Mahasiswa</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalMahasiswaBimbingan }}</h3>
                                <p class="text-blue-500 text-xs">Bimbingan Aktif</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Pengajuan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $pengajuanDiterima }}</h3>
                                <p class="text-green-500 text-xs">Diterima</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Pengajuan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $pengajuanDiajukan }}</h3>
                                <p class="text-yellow-500 text-xs">Dalam Proses</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-times-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Pengajuan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $pengajuanDitolak }}</h3>
                                <p class="text-red-500 text-xs">Ditolak</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Kegiatan Statistics -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Statistik Review Kegiatan</h2>
                        <p class="text-gray-600">Monitor progress review kegiatan mahasiswa bimbingan</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-gray-400 to-gray-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-list-alt text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-gray-700 mb-1">{{ $reviewKegiatanStats['total'] }}</div>
                            <div class="text-sm text-gray-500 font-medium">Total Kegiatan</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-hourglass-half text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-yellow-700 mb-1">{{ $reviewKegiatanStats['pending'] }}</div>
                            <div class="text-sm text-yellow-600 font-medium">Pending Review</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-double text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-green-700 mb-1">{{ $reviewKegiatanStats['approved'] }}</div>
                            <div class="text-sm text-green-600 font-medium">Disetujui</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-edit text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-orange-700 mb-1">{{ $reviewKegiatanStats['needs_revision'] }}</div>
                            <div class="text-sm text-orange-600 font-medium">Perlu Revisi</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-times text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-red-700 mb-1">{{ $reviewKegiatanStats['rejected'] }}</div>
                            <div class="text-sm text-red-600 font-medium">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- To-Do List Dosen -->
            <div class="mb-12">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl p-8 shadow-xl">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Checklist Dosen</h2>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-check text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Review Pengajuan</h3>
                            </div>
                            <p class="text-white/80 text-sm">Review pengajuan magang mahasiswa bimbingan</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Log Kegiatan</h3>
                            </div>
                            <p class="text-white/80 text-sm">Review log kegiatan mahasiswa</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Feedback</h3>
                            </div>
                            <p class="text-white/80 text-sm">Berikan feedback/penilaian magang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengajuan Magang Mahasiswa Bimbingan Terbaru -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pengajuan Magang Terbaru</h2>
                            <p class="text-gray-600">Daftar pengajuan magang mahasiswa bimbingan terbaru</p>
                        </div>
                        <a href="{{ route("dosen.mhsbimbingan.index") }}"
                            class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Mahasiswa</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Lowongan</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Mitra</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Tanggal</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanTerbaru as $pengajuan)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-semibold text-sm">{{ substr($pengajuan->mahasiswa->user->nama ?? 'N', 0, 1) }}</span>
                                                </div>
                                                <span class="font-medium text-gray-800">{{ $pengajuan->mahasiswa->user->nama ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-700">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                        <td class="py-4 px-6 text-gray-700">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                        <td class="py-4 px-6 text-gray-700">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                                    {{ $pengajuan->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' :
                                            ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-700 border border-green-200' :
                                                'bg-red-100 text-red-700 border border-red-200') }}">
                                                {{ ucfirst($pengajuan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 px-6 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                                </div>
                                                <p class="text-gray-500 font-medium">Tidak ada pengajuan terbaru</p>
                                                <p class="text-gray-400 text-sm">Pengajuan baru akan muncul di sini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Review Kegiatan Mahasiswa Bimbingan Terbaru -->
            <div class="mb-8">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Review Kegiatan Terbaru</h2>
                            <p class="text-gray-600">Monitor dan review aktivitas mahasiswa bimbingan</p>
                        </div>
                        <a href="{{ route('dosen.review-kegiatan.index') }}" 
                            class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Mahasiswa</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Lowongan</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Mitra</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Tanggal</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Status Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviewKegiatanTerbaru as $review)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-teal-500 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-semibold text-sm">{{ substr($review->mahasiswa->user->nama ?? 'N', 0, 1) }}</span>
                                                </div>
                                                <span class="font-medium text-gray-800">{{ $review->mahasiswa->user->nama ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-700">{{ $review->pengajuan->lowongan->judul ?? '-' }}</td>
                                        <td class="py-4 px-6 text-gray-700">{{ $review->pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                        <td class="py-4 px-6 text-gray-700">{{ \Carbon\Carbon::parse($review->activity_date)->format('d/m/Y') }}</td>
                                        <td class="py-4 px-6">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                                {{ $review->status === 'approved' ? 'bg-green-100 text-green-700 border border-green-200' :
                                                    ($review->status === 'needs_revision' ? 'bg-orange-100 text-orange-700 border border-orange-200' :
                                                    ($review->status === 'rejected' ? 'bg-red-100 text-red-700 border border-red-200' :
                                                    'bg-yellow-100 text-yellow-700 border border-yellow-200')) }}">
                                                {{ $review->status === 'approved' ? 'Disetujui' :
                                                    ($review->status === 'needs_revision' ? 'Perlu Revisi' :
                                                    ($review->status === 'rejected' ? 'Ditolak' : 'Pending')) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 px-6 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-clipboard-check text-gray-400 text-2xl"></i>
                                                </div>
                                                <p class="text-gray-500 font-medium">Belum ada review kegiatan terbaru</p>
                                                <p class="text-gray-400 text-sm">Review kegiatan mahasiswa akan muncul di sini</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
