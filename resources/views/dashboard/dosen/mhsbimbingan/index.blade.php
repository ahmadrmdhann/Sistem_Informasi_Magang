@extends('layouts.dashboard')

@section('title')
    <title>Mahasiswa Bimbingan</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mahasiswa Bimbingan</h1>
            <p class="text-gray-600 mt-1">Daftar mahasiswa yang sedang Anda bimbing dalam program magang</p>
        </div>

        @if($bimbingans->isEmpty())
            <div class="text-center text-gray-500 py-8">Belum ada mahasiswa bimbingan.</div>
        @else
            <div class="space-y-6">
                @foreach($bimbingans as $bimbingan)
                    <div
                        class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row md:items-center md:justify-between hover:shadow-lg transition">
                        <div>
                            <div class="text-xl font-semibold text-blue-700 mb-1">{{ $bimbingan->mahasiswa->user->nama ?? '-' }}</div>
                            <div class="text-gray-600 mb-1">
                                <span class="font-medium">NIM: {{ $bimbingan->mahasiswa->nim ?? '-' }}</span>
                                <span class="mx-2">|</span>
                                <span>Status: <span
                                        class="text-sm font-semibold text-gray-800">{{ ucfirst($bimbingan->status) }}</span></span>
                            </div>
                            <div class="text-gray-700 text-sm mb-1">
                                <span class="font-semibold">Lowongan:</span>
                                {{ $bimbingan->lowongan->judul ?? '-' }}
                            </div>
                            <div class="text-gray-700 text-sm mb-1">
                                <span class="font-semibold">Perusahaan:</span>
                                {{ $bimbingan->lowongan->partner->nama ?? '-' }}
                            </div>
                            <div class="text-gray-500 text-sm">
                                <span class="font-semibold">Tanggal Pengajuan:</span>
                                {{ \Carbon\Carbon::parse($bimbingan->tanggal_pengajuan)->format('d-m-Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection