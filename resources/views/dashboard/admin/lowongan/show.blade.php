@extends('layouts.dashboard')

@section('title')
    <title>Detail Lowongan Magang</title>
@endsection

@section('content')
    <div id="mainContent"
        class="p-6 w-auto pt-[109px] md:pt-[61px] min-h-screen bg-gray-50 transition-all duration-300 ml-64">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Detail Lowongan</h2>
            <a href="{{ route('lowongan.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="min-w-full">
                <tr>
                    <th class="py-2 px-4 text-left w-1/4">Judul</th>
                    <td class="py-2 px-4">{{ $lowongan->judul }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Partner</th>
                    <td class="py-2 px-4">{{ $lowongan->partner->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Deskripsi</th>
                    <td class="py-2 px-4">{{ $lowongan->deskripsi }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Persyaratan</th>
                    <td class="py-2 px-4">{{ $lowongan->persyaratan }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Lokasi</th>
                    <td class="py-2 px-4">{{ $lowongan->lokasi }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Bidang Keahlian</th>
                    <td class="py-2 px-4">{{ $lowongan->bidang_keahlian }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Periode</th>
                    <td class="py-2 px-4">{{ $lowongan->periode->nama_periode ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Tanggal Mulai</th>
                    <td class="py-2 px-4">{{ $lowongan->tanggal_mulai }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Tanggal Akhir</th>
                    <td class="py-2 px-4">{{ $lowongan->tanggal_akhir }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection