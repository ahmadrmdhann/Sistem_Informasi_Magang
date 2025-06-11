@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="container mx-auto px-4 py-6">
            
        <!-- Notifikasi Cepat -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-lg mb-6 flex items-center">
                <i class="fas fa-bell text-yellow-500 text-2xl mr-4"></i>
                <div>
                    <p class="font-semibold text-yellow-800">Ada {{ $statusDiajukan }} pengajuan magang baru yang perlu ditinjau!</p>
                    <p class="text-sm text-yellow-700">Segera cek pengajuan magang mahasiswa untuk proses lebih lanjut.</p>
                </div>
            </div>
        
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <p>Error: {{ $error }}</p>
                </div>
            @endif

            <!-- Statistik Ringkas (Cards) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Total Mahasiswa -->
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 mr-4">
                            <i class="fas fa-user-graduate text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Mahasiswa</p>
                            <h3 class="font-bold text-2xl">{{ $totalMahasiswa }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Dosen -->
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 mr-4">
                            <i class="fas fa-chalkboard-teacher text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Dosen</p>
                            <h3 class="font-bold text-2xl">{{ $totalDosen }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Lowongan Aktif -->
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 mr-4">
                            <i class="fas fa-briefcase text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Lowongan Aktif</p>
                            <h3 class="font-bold text-2xl">{{ $totalLowonganAktif }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Total Mitra -->
                <div class="bg-white rounded-lg shadow-md p-4 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 mr-4">
                            <i class="fas fa-building text-purple-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm">Total Mitra</p>
                            <h3 class="font-bold text-2xl">{{ $totalMitra }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengajuan Magang Terbaru -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Pengajuan Magang Terbaru</h2>
                    <a href="{{ route('pmm.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left">Mahasiswa</th>
                                <th class="py-2 px-4 text-left">Lowongan</th>
                                <th class="py-2 px-4 text-left">Mitra</th>
                                <th class="py-2 px-4 text-left">Tanggal</th>
                                <th class="py-2 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPengajuan as $pengajuan)
                                                <tr class="border-t hover:bg-gray-50">
                                                    <td class="py-2 px-4">{{ $pengajuan->mahasiswa->user->nama ?? '-' }}</td>
                                                    <td class="py-2 px-4">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                                    <td class="py-2 px-4">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                                    <td class="py-2 px-4">
                                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                                    </td>
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
                                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Tidak ada pengajuan terbaru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Lowongan Populer -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Lowongan Paling Banyak Dilamar</h2>
                    <a href="{{ route('lowongan.index') }}"
                        class="text-blue-600 hover:underline text-base font-semibold">Lihat Semua Lowongan</a>
                </div>
                <div class="space-y-5">
                    @forelse($popularLowongan as $index => $lowongan)
                        <div
                            class="flex items-center p-5 {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} rounded-xl shadow-sm hover:shadow-md transition-all">
                            <div
                                class="flex-shrink-0 mr-6 w-14 h-14 flex items-center justify-center bg-blue-100 text-blue-700 font-bold rounded-full text-xl shadow">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-grow">
                                <h3 class="font-semibold text-lg text-gray-900">{{ $lowongan->judul }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $lowongan->partner->nama ?? '-' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="bg-blue-100 text-blue-700 text-base font-bold px-5 py-1.5 rounded-full shadow-sm">
                                    {{ $lowongan->total_pendaftar }} Pendaftar
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">Belum ada data lowongan</p>
                    @endforelse
                </div>
            </div>

            <!-- Tabel Data Terbaru -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 divide-y-2 divide-gray-200">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h2 class="text-lg font-bold mb-4">Mitra Terbaru</h2>
                    <ul>
                        @foreach(\App\Models\PartnerModel::orderByDesc('created_at')->take(5)->get() as $mitra)
                            <li class="py-2 border-b last:border-b-0 flex justify-between items-center transition hover:bg-blue-50">
                                <span>{{ $mitra->nama }}</span>
                                <span class="text-xs text-gray-500">{{ $mitra->created_at->format('d M Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white rounded-lg shadow-md p-4">
                    <h2 class="text-lg font-bold mb-4">Lowongan Terbaru</h2>
                    <ul>
                        @foreach(\App\Models\LowonganModel::orderByDesc('created_at')->take(5)->get() as $lowongan)
                            <li class="py-2 border-b last:border-b-0 flex justify-between items-center transition hover:bg-blue-50">
                                <span>{{ $lowongan->judul }}</span>
                                <span class="text-xs text-gray-500">{{ $lowongan->created_at->format('d M Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection