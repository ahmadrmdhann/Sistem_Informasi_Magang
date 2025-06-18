@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div id="mainContent" class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6 py-8">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-user-graduate text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Selamat Datang!</h1>
                            <p class="text-xl text-white/90">{{ Auth::user()->nama }}</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-lg max-w-2xl">
                        Mulai perjalanan magang Anda dan kembangkan pengalaman profesional yang berharga.
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('mahasiswa.feedback.index') }}" class="group">
                        <div class="bg-gradient-to-r from-indigo-100 to-blue-100 rounded-2xl p-6 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 border border-indigo-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mr-4 group-hover:scale-105 transition-transform duration-300">
                                        <i class="fas fa-star text-emerald-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Feedback Magang</h3>
                                        <p class="text-gray-600 text-sm">Berikan penilaian pengalaman magang</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform duration-300">
                                    <i class="fas fa-arrow-right text-gray-600 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('mahasiswa.kegiatan.index') }}" class="group">
                        <div class="bg-gradient-to-r from-cyan-100 to-blue-100 rounded-2xl p-6 shadow-md hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 border border-cyan-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4 group-hover:scale-105 transition-transform duration-300">
                                        <i class="fas fa-clipboard-list text-blue-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Kegiatan Magang</h3>
                                        <p class="text-gray-600 text-sm">Catat dan kelola log aktivitas harian</p>
                                    </div>
                                </div>
                                <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center group-hover:translate-x-1 transition-transform duration-300">
                                    <i class="fas fa-arrow-right text-gray-600 text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Statistik Dashboard -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Status Pengajuan Magang</h2>
                    <p class="text-gray-600">Monitor progress pengajuan dan aktivitas magang Anda</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-briefcase text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalPengajuan }}</h3>
                                <p class="text-indigo-500 text-xs">Pengajuan</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Pengajuan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $pengajuanDiterima }}</h3>
                                <p class="text-emerald-500 text-xs">Diterima</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Pengajuan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $pengajuanDiajukan }}</h3>
                                <p class="text-amber-500 text-xs">Diproses</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-rose-400 to-rose-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-times-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Pengajuan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $pengajuanDitolak }}</h3>
                                <p class="text-rose-500 text-xs">Ditolak</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-search text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Lowongan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalLowongan }}</h3>
                                <p class="text-blue-500 text-xs">Tersedia</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checklist Mahasiswa -->
            <div class="mb-12">
                <div class="bg-gradient-to-r from-indigo-500 to-blue-600 rounded-3xl p-8 shadow-xl">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-tasks text-white text-xl"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-white">Checklist Mahasiswa</h2>
                    </div>
                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-user-edit text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Profil & CV</h3>
                            </div>
                            <p class="text-white/80 text-sm">Lengkapi profil dan unggah CV</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-briefcase text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Ajukan Magang</h3>
                            </div>
                            <p class="text-white/80 text-sm">Ajukan magang ke lowongan yang sesuai</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-clipboard-list text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Log Kegiatan</h3>
                            </div>
                            <p class="text-white/80 text-sm">Catat kegiatan magang secara rutin</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                                    <i class="fas fa-star text-white"></i>
                                </div>
                                <h3 class="font-semibold text-white">Feedback</h3>
                            </div>
                            <p class="text-white/80 text-sm">Isi feedback setelah magang selesai</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Review Kegiatan -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Statistik Review Kegiatan</h2>
                        <p class="text-gray-600">Monitor status review kegiatan magang Anda</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-gray-400 to-gray-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-list-alt text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-gray-700 mb-1">{{ $reviewKegiatanStats['total'] ?? 0 }}</div>
                            <div class="text-sm text-gray-500 font-medium">Total Kegiatan</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-hourglass-half text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-amber-700 mb-1">{{ $reviewKegiatanStats['pending'] ?? 0 }}</div>
                            <div class="text-sm text-amber-600 font-medium">Pending Review</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-double text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-emerald-700 mb-1">{{ $reviewKegiatanStats['approved'] ?? 0 }}</div>
                            <div class="text-sm text-emerald-600 font-medium">Disetujui</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-edit text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-orange-700 mb-1">{{ $reviewKegiatanStats['needs_revision'] ?? 0 }}</div>
                            <div class="text-sm text-orange-600 font-medium">Perlu Revisi</div>
                        </div>
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-rose-400 to-rose-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-times text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-rose-700 mb-1">{{ $reviewKegiatanStats['rejected'] ?? 0 }}</div>
                            <div class="text-sm text-rose-600 font-medium">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekomendasi Lowongan -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Rekomendasi Lowongan</h2>
                            <p class="text-gray-600">Lowongan magang yang cocok untuk Anda berdasarkan profil</p>
                        </div>
                        <a href="{{ route('mahasiswa.rekomendasi') }}"
                            class="bg-gradient-to-r from-indigo-500 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-indigo-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($rekomendasiLowongan ?? [] as $index => $lowongan)
                            @if($index < 3)
                                @php
                                    // Handle both simple lowongan objects and recommendation objects
                                    $actualLowongan = is_object($lowongan) && isset($lowongan->lowongan_id) ? $lowongan : 
                                        (is_array($lowongan) && isset($lowongan['lowongan']) ? $lowongan['lowongan'] : $lowongan);

                                    if (is_array($lowongan) && isset($lowongan['criteria'])) {
                                        // Calculate from recommendation criteria if available
                                        $distance = $lowongan['criteria']['distance'] ?? 50;
                                        $skillMatch = $lowongan['criteria']['skill_match'] ?? 70;
                                        $interestMatch = $lowongan['criteria']['interest_match'] ?? 60;
                                        $compatibilityScore = ($skillMatch * 0.4 + $interestMatch * 0.3 + (100 - min($distance, 100)) * 0.3);
                                    } elseif (is_object($actualLowongan) && isset($actualLowongan->compatibility_score)) {
                                        $compatibilityScore = $actualLowongan->compatibility_score;
                                    }
                                @endphp
                                <div class="group bg-gradient-to-br from-indigo-50 to-blue-100 rounded-2xl p-6 border border-indigo-200 hover:shadow-lg transition-all duration-300">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-blue-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                            {{ $index + 1 }}
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h3 class="font-bold text-lg text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">
                                            {{ $actualLowongan->judul ?? 'Frontend Developer Intern' }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <i class="fas fa-building mr-2"></i>{{ $actualLowongan->partner->nama ?? 'PT Teknologi Maju' }}
                                        </p>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <i class="fas fa-map-marker-alt mr-2"></i>{{ $actualLowongan->kabupaten->nama ?? 'Jakarta Selatan' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-calendar mr-2"></i>
                                            {{ isset($actualLowongan->tanggal_mulai) ? \Carbon\Carbon::parse($actualLowongan->tanggal_mulai)->format('d M Y') : '1 Jul 2024' }} - 
                                            {{ isset($actualLowongan->tanggal_akhir) ? \Carbon\Carbon::parse($actualLowongan->tanggal_akhir)->format('d M Y') : '31 Dec 2024' }}
                                        </p>
                                    </div>

                                    <div class="mb-4">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">
                                                {{ $actualLowongan->keahlian->nama ?? 'Web Development' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">
                                            <i class="fas fa-users mr-1"></i>{{ $actualLowongan->kuota ?? 5 }} posisi
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-lightbulb text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Rekomendasi</h3>
                                <p class="text-gray-500 max-w-md mx-auto mb-6">
                                    Lengkapi profil Anda untuk mendapatkan rekomendasi lowongan yang sesuai dengan keahlian dan minat.
                                </p>
                                <a href="{{ route('mahasiswa.profile') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-lg font-medium hover:from-indigo-600 hover:to-blue-700 transition-all duration-300">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    Lengkapi Profil
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Riwayat Pengajuan Magang -->
            <div class="mb-8">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Pengajuan Magang</h2>
                            <p class="text-gray-600">Track semua pengajuan magang yang pernah Anda buat</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-gray-100">
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Lowongan</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Mitra</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Tanggal</th>
                                    <th class="py-4 px-6 text-left font-semibold text-gray-700">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayatPengajuan as $pengajuan)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
                                        <td class="py-4 px-6 font-medium text-gray-800">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                        <td class="py-4 px-6 text-gray-700">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                        <td class="py-4 px-6 text-gray-700">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-4 px-6">
                                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                                {{ $pengajuan->status === 'diajukan' ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                                                    ($pengajuan->status === 'diterima' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' :
                                                        'bg-rose-100 text-rose-700 border border-rose-200') }}">
                                                {{ ucfirst($pengajuan->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 px-6 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-inbox text-gray-400 text-2xl"></i>
                                                </div>
                                                <p class="text-gray-500 font-medium">Belum ada pengajuan magang</p>
                                                <p class="text-gray-400 text-sm">Pengajuan Anda akan muncul di sini</p>
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
