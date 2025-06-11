@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-6">
            @if($pengajuanDiterima > 0)
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-2xl mr-4"></i>
                    <div>
                        <p class="font-semibold text-green-800">Selamat! Ada {{ $pengajuanDiterima }} pengajuan magang kamu
                            diterima.</p>
                        <p class="text-sm text-green-700">Silakan cek detail penempatan magang kamu.</p>
                    </div>
                </div>
            @endif
            @if($pengajuanDitolak > 0)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-times-circle text-red-500 text-2xl mr-4"></i>
                    <div>
                        <p class="font-semibold text-red-800">Maaf, ada {{ $pengajuanDitolak }} pengajuan magang kamu yang
                            ditolak.</p>
                    </div>
                </div>
            @endif
            @if($pengajuanDiajukan > 0)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6 flex items-center">
                    <i class="fas fa-clock text-yellow-500 text-2xl mr-4"></i>
                    <div>
                        <p class="font-semibold text-yellow-800">Pengajuan magang kamu sedang diproses ({{ $pengajuanDiajukan }}).</p>
                        <p class="text-sm text-yellow-700">Tunggu konfirmasi dari admin terkait status pengajuanmu.</p>
                    </div>
                </div>
            @endif

            <h1 class="text-2xl font-bold mb-6">Selamat Datang, {{ Auth::user()->nama }}</h1>
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <p>Error: {{ $error }}</p>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500 transition hover:shadow-lg hover:bg-blue-50">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <i class="fas fa-briefcase text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Pengajuan Magang</p>
                            <h3 class="font-bold text-2xl">{{ $totalPengajuan }}</h3>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500 transition hover:shadow-lg hover:bg-green-50">
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
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500 transition hover:shadow-lg hover:bg-yellow-50">
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
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-red-500 transition hover:shadow-lg hover:bg-red-50">
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
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-indigo-500 transition hover:shadow-lg hover:bg-indigo-50">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 mr-4">
                            <i class="fas fa-briefcase text-indigo-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Lowongan Tersedia</p>
                            <h3 class="font-bold text-2xl">{{ $totalLowongan }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <h2 class="text-lg font-bold mb-4">Riwayat Pengajuan Magang</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left">Lowongan</th>
                                <th class="py-2 px-4 text-left">Mitra</th>
                                <th class="py-2 px-4 text-left">Tanggal</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPengajuan as $pengajuan)
                                                <tr class="border-t hover:bg-gray-50">
                                                    <td class="py-2 px-4">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                                    <td class="py-2 px-4">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                                    <td class="py-2 px-4">
                                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                                    <td class="py-2 px-4">
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
                                    <td colspan="4" class="py-4 px-4 text-center text-gray-500">Belum ada pengajuan magang</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Lowongan Paling Banyak Dilamar -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Lowongan Paling Banyak Dilamar</h2>
                </div>
                <div class="space-y-4">
                    @forelse($popularLowongan as $index => $lowongan)
                    @if($lowongan->total_pendaftar > 0)
                        <div class="flex items-center p-4 {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} rounded-lg transition hover:bg-blue-50">
                            <div
                                class="flex-shrink-0 mr-4 w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-700 font-bold rounded-full text-lg">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-semibold text-lg">{{ $lowongan->judul }}</h3>
                                <p class="text-sm text-gray-500">{{ $lowongan->partner->nama ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-700 text-sm font-semibold px-4 py-1 rounded-full">
                                    {{ $lowongan->total_pendaftar }} Pendaftar
                                </span>
                            </div>
                        </div>
                    @endif
                    @empty
                        <p class="text-center text-gray-500 py-4">Belum ada data lowongan</p>
                    @endforelse
                </div>
            </div>

            <!-- To-Do List / Checklist -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-bold mb-4">Checklist Mahasiswa</h2>
                <ul class="list-disc pl-6 space-y-2 text-gray-700">
                    <li class="flex items-center"><i class="fas fa-user-edit text-blue-400 mr-2"></i> Lengkapi profil dan unggah CV</li>
                    <li class="flex items-center"><i class="fas fa-briefcase text-green-400 mr-2"></i> Ajukan magang ke lowongan yang sesuai</li>
                    <li class="flex items-center"><i class="fas fa-tasks text-yellow-400 mr-2"></i> Catat kegiatan magang secara rutin</li>
                    <li class="flex items-center"><i class="fas fa-star text-purple-400 mr-2"></i> Isi feedback/penilaian setelah magang selesai</li>
                </ul>
            </div>

            <!-- Rekomendasi Lowongan -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-bold mb-4">Rekomendasi Lowongan Untukmu</h2>
                <ul class="space-y-3">
                    @forelse($rekomendasiLowongan ?? [] as $lowongan)
                        <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                            <div>
                                <span class="font-semibold text-blue-700">{{ is_object($lowongan) && isset($lowongan->judul) ? $lowongan->judul : '-' }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ $lowongan->partner->nama ?? '-' }}</span>
                            </div>
                            <a href="{{ route('mahasiswa.lowongan.index', $lowongan->lowongan_id) }}" class="text-blue-600 hover:underline text-base font-semibold">Lihat Detail</a>
                        </li>
                    @empty
                        <li class="text-gray-400">Belum ada rekomendasi lowongan</li>
                    @endforelse
                </ul>
            </div>
@endsection