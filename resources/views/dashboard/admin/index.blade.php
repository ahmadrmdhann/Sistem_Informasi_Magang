@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <div id="mainContent" 
        class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6 py-8">
            
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-user-shield text-white text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-xl text-white/90">Selamat Datang, Administrator!</p>
                        </div>
                    </div>
                    <p class="text-white/80 text-lg max-w-2xl">
                        Kelola sistem magang mahasiswa dengan kontrol penuh dan monitoring real-time.
                    </p>
                </div>
            </div>

            @if(isset($error))
                <div class="bg-gradient-to-r from-red-400 to-red-500 rounded-2xl p-6 mb-8 text-white shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-white text-xl mr-4"></i>
                        <p class="font-semibold">Error: {{ $error }}</p>
                    </div>
                </div>
            @endif

            <!-- Quick Links / Aksi Cepat Admin -->
            <div class="mb-8">
                <div class="bg-white rounded-3xl shadow-xl p-6 border border-gray-100">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-bolt text-white text-lg"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Aksi Cepat</h2>
                            <p class="text-gray-600 text-sm">Akses cepat ke fitur feedback sistem</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('admin.feedback.responses') }}"
                        class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl p-4 border border-blue-200 transition-all duration-300 transform hover:scale-102">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-list text-white text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Lihat Semua Respons</h4>
                                    <p class="text-gray-600 text-sm">Monitor respons feedback</p>
                                </div>
                                <i class="fas fa-arrow-right text-blue-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </a>
                        
                        <a href="{{ route('admin.feedback.create') }}"
                        class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl p-4 border border-green-200 transition-all duration-300 transform hover:scale-102">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-plus text-white text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 mb-1">Buat Form Baru</h4>
                                    <p class="text-gray-600 text-sm">Tambah form feedback</p>
                                </div>
                                <i class="fas fa-arrow-right text-green-500 group-hover:translate-x-1 transition-transform duration-300"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>            <!-- Statistik Ringkas (Cards) -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Statistik Sistem</h2>
                    <p class="text-gray-600">Overview data master dan aktifitas sistem</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Mahasiswa -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-graduate text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalMahasiswa }}</h3>
                                <p class="text-blue-500 text-xs">Mahasiswa</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Dosen -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalDosen }}</h3>
                                <p class="text-green-500 text-xs">Dosen</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Lowongan Aktif -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-briefcase text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Lowongan</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalLowonganAktif }}</h3>
                                <p class="text-yellow-500 text-xs">Aktif</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Mitra -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $totalMitra }}</h3>
                                <p class="text-purple-500 text-xs">Mitra</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            <!-- Statistik Status Pengajuan Magang -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Statistik Pengajuan Magang</h2>
                        <p class="text-gray-600">Monitor status pengajuan magang mahasiswa</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-clipboard-list text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-blue-700 mb-1">{{ $statPengajuan['total'] ?? 0 }}</div>
                            <div class="text-sm text-blue-600 font-medium">Total Pengajuan</div>
                        </div>
                        
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-hourglass-half text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-yellow-700 mb-1">{{ $statPengajuan['diajukan'] ?? 0 }}</div>
                            <div class="text-sm text-yellow-600 font-medium">Diajukan</div>
                        </div>
                        
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-green-700 mb-1">{{ $statPengajuan['diterima'] ?? 0 }}</div>
                            <div class="text-sm text-green-600 font-medium">Diterima</div>
                        </div>
                        
                        <div class="text-center group">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-times-circle text-white text-2xl"></i>
                            </div>
                            <div class="text-3xl font-bold text-red-700 mb-1">{{ $statPengajuan['ditolak'] ?? 0 }}</div>
                            <div class="text-sm text-red-600 font-medium">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>            <!-- Pengajuan Magang Terbaru -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pengajuan Magang Terbaru</h2>
                            <p class="text-gray-600">Monitor pengajuan magang mahasiswa terbaru</p>
                        </div>
                        <a href="{{ route('pmm.index') }}" 
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
                                @forelse($latestPengajuan as $pengajuan)
                                    <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-all duration-300">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-400 to-cyan-500 rounded-full flex items-center justify-center mr-3">
                                                    <span class="text-white font-semibold text-sm">
                                                        {{ substr($pengajuan->mahasiswa->user->nama ?? 'N', 0, 1) }}
                                                    </span>
                                                </div>
                                                <span class="font-medium text-gray-800">
                                                    {{ $pengajuan->mahasiswa->user->nama ?? '-' }}
                                                </span>
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
            </div>            <!-- Lowongan Populer -->
            <div class="mb-12">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Lowongan Paling Populer</h2>
                            <p class="text-gray-600">Lowongan dengan pendaftar terbanyak</p>
                        </div>
                        <a href="{{ route('lowongan.index') }}"
                           class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transform hover:scale-105 transition-all duration-300 shadow-lg">
                            Lihat Semua
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($popularLowongan as $index => $lowongan)
                            @if($lowongan->total_pendaftar > 0)
                                <div class="flex items-center p-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <div class="flex-shrink-0 mr-6 w-16 h-16 flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600 text-white font-bold rounded-2xl text-xl shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-grow">
                                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $lowongan->judul }}</h3>
                                        <p class="text-sm text-gray-600">{{ $lowongan->partner->nama ?? '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-lg">
                                            {{ $lowongan->total_pendaftar }} Pendaftar
                                        </span>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-chart-bar text-gray-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-500 font-medium">Belum ada pendaftar</p>
                                <p class="text-gray-400 text-sm">Data lowongan populer akan muncul di sini</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div><!-- Data Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Mitra Terbaru -->
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-building text-white text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Mitra Terbaru</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach(\App\Models\PartnerModel::orderByDesc('created_at')->take(5)->get() as $mitra)
                            <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-all duration-300">
                                <span class="font-medium text-gray-800">{{ $mitra->nama }}</span>
                                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">
                                    {{ $mitra->created_at->format('d M Y') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Lowongan Terbaru -->
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-briefcase text-white text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Lowongan Terbaru</h2>
                    </div>
                    <div class="space-y-3">
                        @foreach(\App\Models\LowonganModel::orderByDesc('created_at')->take(5)->get() as $lowongan)
                            <div class="flex justify-between items-center py-3 px-4 bg-gray-50 rounded-xl hover:bg-yellow-50 transition-all duration-300">
                                <span class="font-medium text-gray-800">{{ $lowongan->judul }}</span>
                                <span class="text-xs text-gray-500 bg-white px-2 py-1 rounded-full">
                                    {{ $lowongan->created_at->format('d M Y') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection