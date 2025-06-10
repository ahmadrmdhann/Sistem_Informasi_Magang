@extends('layouts.dashboard')

@section('content')
    <div id="mainContent"
        class="p-3 sm:p-6 transition-all duration-300 ml-0 sm:ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-100">
        <div class="container mx-auto px-2 sm:px-4">
            <div class="mb-4 sm:mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Rekomendasi Tempat Magang</h1>
                <p class="text-sm sm:text-base text-gray-600">Sistem pendukung keputusan menggunakan metode MOORA dan
                    ELECTRE IV</p>
            </div>

            @if(isset($message))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    {{ $message }}
                </div>
            @else
                <!-- Profile Summary -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Profil Anda</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Lokasi Preferensi</p>
                                <p class="font-medium">{{ $mahasiswa->lokasiPreferensi->nama ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-cogs text-green-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Keahlian</p>
                                <p class="font-medium">{{ $mahasiswa->keahlian->nama ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                            <i class="fas fa-heart text-purple-500 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Minat</p>
                                <p class="font-medium">{{ $mahasiswa->minat->nama ?? 'Belum diisi' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="border-b">
                        <div class="flex">
                            <button id="combinedTab"
                                class="tab-button active px-6 py-4 text-sm font-medium transition focus:outline-none"
                                onclick="showTab('combined')">
                                Rekomendasi Gabungan
                            </button>
                            <button id="mooraTab" class="tab-button px-6 py-4 text-sm font-medium transition focus:outline-none"
                                onclick="showTab('moora')">
                                Metode MOORA
                            </button>
                            <button id="electreTab"
                                class="tab-button px-6 py-4 text-sm font-medium transition focus:outline-none"
                                onclick="showTab('electre')">
                                Metode ELECTRE IV
                            </button>
                        </div>
                    </div>

                    <!-- Combined Results -->
                    <div id="combinedContent" class="tab-content p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-gray-800">🏆 Top 3 Rekomendasi Terbaik</h3>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span>Gabungan MOORA & ELECTRE IV</span>
                            </div>
                        </div>

                        @if(count($recommendations) > 0)
                            <div class="space-y-6">
                                @foreach($recommendations as $index => $rec)
                                    @php
                                        $position = $index + 1; // 1st, 2nd, 3rd position
                                        $rankColors = [
                                            1 => ['bg' => 'bg-gradient-to-r from-yellow-50 to-yellow-100', 'border' => 'border-yellow-300', 'icon' => 'text-yellow-600', 'badge' => 'bg-yellow-500'],
                                            2 => ['bg' => 'bg-gradient-to-r from-gray-50 to-gray-100', 'border' => 'border-gray-300', 'icon' => 'text-gray-600', 'badge' => 'bg-gray-500'],
                                            3 => ['bg' => 'bg-gradient-to-r from-orange-50 to-orange-100', 'border' => 'border-orange-300', 'icon' => 'text-orange-600', 'badge' => 'bg-orange-500']
                                        ];
                                        $colors = $rankColors[$position] ?? $rankColors[3];
                                    @endphp

                                    <div
                                        class="relative {{ $colors['bg'] }} {{ $colors['border'] }} border-2 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                        <!-- Ranking Badge -->
                                        <div
                                            class="absolute -top-3 -left-3 {{ $colors['badge'] }} text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg shadow-lg">
                                            {{ $position }}
                                        </div>

                                        <!-- Main Content -->
                                        <div class="ml-6">
                                            <!-- Header -->
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-start">
                                                    @if($position == 1)
                                                        <i class="fas fa-trophy {{ $colors['icon'] }} text-3xl mr-4 mt-1"></i>
                                                    @elseif($position == 2)
                                                        <i class="fas fa-medal {{ $colors['icon'] }} text-3xl mr-4 mt-1"></i>
                                                    @else
                                                        <i class="fas fa-award {{ $colors['icon'] }} text-3xl mr-4 mt-1"></i>
                                                    @endif

                                                    <div>
                                                        <h4 class="text-xl font-bold text-gray-800 mb-1">{{ $rec['lowongan']->judul }}
                                                        </h4>
                                                        <p class="text-gray-600 mb-2">
                                                            {{ $rec['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                                        <div class="flex items-center space-x-4 text-sm">
                                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                                {{ $rec['lowongan']->kabupaten->nama ?? 'Lokasi tidak tersedia' }}
                                                            </span>
                                                            <span
                                                                class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                                                <i class="fas fa-tools mr-1"></i>
                                                                {{ $rec['lowongan']->keahlian->nama ?? 'Keahlian tidak tersedia' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Score Display -->
                                                <div class="text-right">
                                                    <div class="bg-white rounded-lg p-3 shadow-sm">
                                                        <div class="text-sm font-medium text-gray-600 mb-1">Skor Gabungan</div>
                                                        <div class="text-2xl font-bold {{ $colors['icon'] }}">
                                                            {{ number_format($rec['average_rank'], 2) }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 mt-1">
                                                            @if($position == 1)
                                                                <span class="text-yellow-600 font-semibold">⭐ Terbaik</span>
                                                            @elseif($position == 2)
                                                                <span class="text-gray-600 font-semibold">🥈 Sangat Baik</span>
                                                            @else
                                                                <span class="text-orange-600 font-semibold">🥉 Baik</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Criteria Grid -->
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                                    <div class="flex items-center">
                                                        <div class="bg-red-100 rounded-full p-2 mr-3">
                                                            <i class="fas fa-route text-red-600"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Jarak
                                                            </p>
                                                            <p class="text-lg font-bold text-gray-800">
                                                                {{ number_format($rec['criteria']['distance'], 1) }} km</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                                    <div class="flex items-center">
                                                        <div class="bg-green-100 rounded-full p-2 mr-3">
                                                            <i class="fas fa-cogs text-green-600"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                                Kecocokan Keahlian</p>
                                                            <p class="text-lg font-bold text-gray-800">
                                                                {{ $rec['criteria']['skill_match'] }}%</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-white rounded-lg p-4 shadow-sm">
                                                    <div class="flex items-center">
                                                        <div class="bg-purple-100 rounded-full p-2 mr-3">
                                                            <i class="fas fa-heart text-purple-600"></i>
                                                        </div>
                                                        <div>
                                                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">
                                                                Kecocokan Minat</p>
                                                            <p class="text-lg font-bold text-gray-800">
                                                                {{ $rec['criteria']['interest_match'] }}%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Method Rankings -->
                                            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                                                <div class="flex space-x-6">
                                                    <div class="text-center">
                                                        <div class="text-xs font-medium text-gray-500 mb-1">MOORA</div>
                                                        <div class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                            #{{ $rec['moora_rank'] }}
                                                        </div>
                                                    </div>
                                                    <div class="text-center">
                                                        <div class="text-xs font-medium text-gray-500 mb-1">ELECTRE</div>
                                                        <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                                            #{{ $rec['electre_rank'] }}
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($position == 1)
                                                    <div class="bg-yellow-100 border border-yellow-300 rounded-lg px-4 py-2">
                                                        <div class="flex items-center">
                                                            <i class="fas fa-star text-yellow-600 mr-2"></i>
                                                            <span class="text-sm font-bold text-yellow-800">Rekomendasi Teratas!</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Summary -->
                            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-lightbulb text-blue-600 text-xl mr-3 mt-1"></i>
                                    <div>
                                        <h4 class="font-semibold text-blue-900 mb-2">Cara Membaca Hasil:</h4>
                                        <ul class="text-sm text-blue-800 space-y-1">
                                            <li>• <strong>Skor Gabungan:</strong> Rata-rata ranking dari kedua metode (semakin
                                                rendah semakin baik)</li>
                                            <li>• <strong>MOORA:</strong> Multi-Objective Optimization by Ratio Analysis</li>
                                            <li>• <strong>ELECTRE:</strong> Elimination and Choice Translating Reality</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="mb-4">
                                    <i class="fas fa-search text-gray-300 text-6xl"></i>
                                </div>
                                <h4 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Rekomendasi</h4>
                                <p class="text-gray-500 max-w-md mx-auto">
                                    Belum ada lowongan yang cocok dengan profil Anda saat ini.
                                    Pastikan profil Anda sudah lengkap dan coba lagi nanti.
                                </p>
                            </div>
                        @endif
                    </div>

                    <!-- MOORA Results -->
                    <div id="mooraContent" class="tab-content p-6 hidden">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <span
                                class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">M</span>
                            Top 3 Hasil Metode MOORA
                        </h3>
                        @if(count($mooraResults) > 0)
                            <div class="space-y-4">
                                @foreach($mooraResults as $index => $result)
                                    @php
                                        $rank = $index + 1;
                                    @endphp
                                    <div class="border rounded-lg p-4 bg-blue-50">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center">
                                                <span class="bg-blue-500 text-white px-3 py-2 rounded-full text-sm font-bold mr-4">
                                                    {{ $rank }}
                                                </span>
                                                <div>
                                                    <h4 class="text-lg font-semibold">{{ $result['lowongan']->judul }}</h4>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $result['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right bg-white rounded-lg p-3 shadow-sm">
                                                <div class="text-sm text-gray-600">Skor MOORA</div>
                                                <div class="text-xl font-bold text-blue-600">{{ number_format($result['score'], 4) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4 text-sm bg-white rounded-lg p-3">
                                            <div><strong>Jarak:</strong> {{ number_format($result['criteria']['distance'], 1) }} km
                                            </div>
                                            <div><strong>Keahlian:</strong> {{ $result['criteria']['skill_match'] }}%</div>
                                            <div><strong>Minat:</strong> {{ $result['criteria']['interest_match'] }}%</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Tidak ada hasil MOORA yang tersedia.</p>
                            </div>
                        @endif
                    </div>

                    <!-- ELECTRE Results -->
                    <div id="electreContent" class="tab-content p-6 hidden">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <span
                                class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">E</span>
                            Top 3 Hasil Metode ELECTRE IV
                        </h3>
                        @if(count($electreResults) > 0)
                            <div class="space-y-4">
                                @foreach($electreResults as $index => $result)
                                    @php
                                        $rank = $index + 1;
                                    @endphp
                                    <div class="border rounded-lg p-4 bg-green-50">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center">
                                                <span class="bg-green-500 text-white px-3 py-2 rounded-full text-sm font-bold mr-4">
                                                    {{ $rank }}
                                                </span>
                                                <div>
                                                    <h4 class="text-lg font-semibold">{{ $result['lowongan']->judul }}</h4>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $result['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right bg-white rounded-lg p-3 shadow-sm">
                                                <div class="text-sm text-gray-600">Skor ELECTRE</div>
                                                <div class="text-xl font-bold text-green-600">{{ $result['score'] }}</div>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-3 gap-4 text-sm bg-white rounded-lg p-3">
                                            <div><strong>Jarak:</strong> {{ number_format($result['criteria']['distance'], 1) }} km
                                            </div>
                                            <div><strong>Keahlian:</strong> {{ $result['criteria']['skill_match'] }}%</div>
                                            <div><strong>Minat:</strong> {{ $result['criteria']['interest_match'] }}%</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">Tidak ada hasil ELECTRE yang tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            // Remove active class from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-500');
            });

            // Show selected tab content
            document.getElementById(tabName + 'Content').classList.remove('hidden');

            // Add active class to selected tab
            const activeTab = document.getElementById(tabName + 'Tab');
            activeTab.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-500');
        }

        // Initialize first tab as active
        document.addEventListener('DOMContentLoaded', function () {
            showTab('combined');
        });
    </script>

    <style>
        .border-gold {
            border-color: #fbbf24;
        }

        .border-silver {
            border-color: #9ca3af;
        }

        .border-bronze {
            border-color: #f97316;
        }
    </style>
@endsection