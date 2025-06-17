@extends('layouts.dashboard')

@section('title', 'Mahasiswa Bimbingan')

@section('content')
    <div id="mainContent" class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-gray-50 via-slate-50 to-blue-50">
        <div class="container mx-auto px-6 py-8">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-slate-600 via-gray-600 to-slate-700 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Mahasiswa Bimbingan</h1>
                            <p class="text-xl text-white/90">Daftar mahasiswa yang sedang Anda bimbing dalam program magang</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                @if($bimbingans->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-gray-400 text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum ada mahasiswa bimbingan</h3>
                        <p class="text-gray-500 max-w-md mx-auto">Mahasiswa yang Anda bimbing akan muncul di sini setelah pengajuan mereka diterima.</p>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($bimbingans as $bimbingan)
                            <div class="group bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-slate-400 to-slate-600 rounded-xl flex items-center justify-center mr-4">
                                                <span class="text-white font-bold text-lg">{{ substr($bimbingan->mahasiswa->user->nama ?? 'N', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h3 class="text-xl font-bold text-slate-700 group-hover:text-slate-800 transition-colors">{{ $bimbingan->mahasiswa->user->nama ?? '-' }}</h3>
                                                <p class="text-gray-600 font-medium">NIM: {{ $bimbingan->mahasiswa->nim ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-graduation-cap text-slate-500 mr-2"></i>
                                                <span class="text-sm">{{ $bimbingan->mahasiswa->prodi->prodi_nama ?? '-' }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-calendar-alt text-slate-500 mr-2"></i>
                                                <span class="text-sm">{{ \Carbon\Carbon::parse($bimbingan->tanggal_pengajuan)->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-briefcase text-slate-500 mr-2"></i>
                                                <span class="text-sm">{{ $bimbingan->lowongan->judul ?? '-' }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-600">
                                                <i class="fas fa-building text-slate-500 mr-2"></i>
                                                <span class="text-sm">{{ $bimbingan->lowongan->partner->nama ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="bg-white/60 rounded-lg p-3">
                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-600 font-medium">Status:</span>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                    {{ $bimbingan->status === 'diterima' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' :
                                                       ($bimbingan->status === 'diajukan' ? 'bg-amber-100 text-amber-700 border border-amber-200' :
                                                        'bg-rose-100 text-rose-700 border border-rose-200') }}">
                                                    {{ ucfirst($bimbingan->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
