@extends('layouts.dashboard')

@section('title', 'Status Pengajuan Magang')

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
                            <i class="fas fa-file-alt text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Status Pengajuan Magang</h1>
                            <p class="text-xl text-white/90">Lihat dan pantau status pengajuan magang Anda</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 mb-8 rounded-xl">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-blue-400 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-info-circle text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-blue-700 font-medium">
                                Berikut adalah status pengajuan magang Anda. Silakan periksa secara berkala untuk melihat pembaruan.
                            </p>
                        </div>
                    </div>
                </div>

                @if ($pengajuans->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada pengajuan magang</h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">Anda belum mengajukan magang ke perusahaan partner manapun.</p>
                        <a href="{{ route('mahasiswa.lowongan.index') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-xl font-medium hover:from-indigo-600 hover:to-blue-700 transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>
                            Cari Lowongan
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto bg-white rounded-xl">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($pengajuans as $index => $pengajuan)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-building text-white text-xs"></i>
                                                </div>
                                                <span class="font-medium">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            <span class="font-medium">{{ $pengajuan->lowongan->judul ?? '-' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @switch($pengajuan->status)
                                                @case('diterima')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                                        <i class="fas fa-check-circle mr-1"></i> Diterima
                                                    </span>
                                                    @break
                                                @case('ditolak')
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700 border border-rose-200">
                                                        <i class="fas fa-times-circle mr-1"></i> Ditolak
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                                        <i class="fas fa-clock mr-1"></i> Dalam Proses
                                                    </span>
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection