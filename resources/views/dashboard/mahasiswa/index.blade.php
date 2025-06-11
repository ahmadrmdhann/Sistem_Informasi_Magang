@extends('layouts.dashboard')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Dashboard Mahasiswa</h1>
        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <p>Error: {{ $error }}</p>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
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
            <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-indigo-500">
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
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
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
                <a href="{{ route('lowongan.index') }}" class="text-blue-600 hover:underline text-base font-medium">Lihat Semua Lowongan</a>
            </div>
            <div class="space-y-4">
                @forelse($popularLowongan as $index => $lowongan)
                    <div class="flex items-center p-4 {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} rounded-lg">
                        <div class="flex-shrink-0 mr-4 w-12 h-12 flex items-center justify-center bg-blue-100 text-blue-700 font-bold rounded-full text-lg">
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
                @empty
                    <p class="text-center text-gray-500 py-4">Belum ada data lowongan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection