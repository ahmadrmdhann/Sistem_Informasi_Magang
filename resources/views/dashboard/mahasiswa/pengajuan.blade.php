@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Status Pengajuan Magang</h1>
            <p class="text-gray-600 mt-1">Lihat dan pantau status pengajuan magang Anda</p>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden p-5">
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Berikut adalah status pengajuan magang Anda. Silakan periksa secara berkala untuk melihat pembaruan.
                        </p>
                    </div>
                </div>
            </div>

            @if ($pengajuans->isEmpty())
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
                    <p class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Belum ada pengajuan magang.
                    </p>
                </div>
            @else
                <div class="overflow-x-auto bg-white rounded">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengajuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pengajuans as $index => $pengajuan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $pengajuan->lowongan->partner->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $pengajuan->lowongan->judul ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @switch($pengajuan->status)
                                            @case('diterima')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i> Diterima
                                                </span>
                                                @break
                                            @case('ditolak')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i> Ditolak
                                                </span>
                                                @break
                                            @default
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
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
@endsection