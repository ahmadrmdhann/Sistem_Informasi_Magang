@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet">
    <style>
        #locationMap { height: 300px; }
    </style>
@endpush

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-6">
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

        <!-- Grafik Distribusi Mahasiswa Magang -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Distribusi Status Pengajuan -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-lg font-bold mb-4">Status Pengajuan Magang</h2>
                <canvas id="statusChart" height="200"></canvas>
            </div>

            <!-- Distribusi Mahasiswa per Prodi
            <div class="bg-white rounded-lg shadow-md p-4">
                <h2 class="text-lg font-bold mb-4">Mahasiswa per Program Studi</h2>
                <canvas id="prodiChart" height="200"></canvas>
            </div>
        </div> -->

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
                                <td colspan="5" class="py-4 px-4 text-center text-gray-500">Tidak ada pengajuan terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Lowongan Populer -->
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

        <!-- Kalender Periode Magang -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Kalender Periode Magang</h2>
                <a href="{{ route('periode.index') }}" class="text-blue-500 hover:text-blue-700 text-sm">Kelola Periode</a>
            </div>
            <div id="periodCalendar" class="h-64"></div>
        </div>

        <!-- Distribusi Lokasi Magang
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold">Distribusi Lokasi Magang</h2>
            </div>
            <div id="locationMap"></div>
        </div> -->
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.min.js"></script>

    <script>
        // Status Pengajuan Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Diajukan', 'Diterima', 'Ditolak'],
                datasets: [{
                    data: [{{ $statusDiajukan }}, {{ $statusDiterima }}, {{ $statusDitolak }}],
                    backgroundColor: ['#FBBF24', '#34D399', '#F87171'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Prodi Chart
        const prodiCtx = document.getElementById('prodiChart').getContext('2d');
        const prodiChart = new Chart(prodiCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($prodiLabels) !!},
                datasets: [{
                    label: 'Jumlah Mahasiswa',
                    data: {!! json_encode($prodiData) !!},
                    backgroundColor: '#60A5FA',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Calendar setup
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('periodCalendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {!! json_encode($calendarEvents) !!},
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                }
            });
            calendar.render();
        });

        // Map setup
        const map = L.map('locationMap').setView([-2.5, 118], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        // Add markers for each location
        const locations = {!! json_encode($locationData) !!};
        locations.forEach(location => {
            L.marker([location.lat, location.lng])
                .addTo(map)
                .bindPopup(`<b>${location.name}</b><br>${location.count} mahasiswa`);
        });
    </script>
@endpush