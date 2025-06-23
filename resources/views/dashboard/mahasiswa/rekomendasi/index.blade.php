@extends('layouts.dashboard')

@section('title', 'Rekomendasi Tempat Magang')

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
                            <i class="fas fa-lightbulb text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Rekomendasi Tempat Magang</h1>
                            <p class="text-xl text-white/90">Sistem pendukung keputusan menggunakan metode MOORA dan ELECTRE IV</p>
                        </div>
                    </div>
                </div>
            </div>

            @if(isset($message))
                <div class="bg-gradient-to-r from-amber-100 to-orange-100 border-l-4 border-amber-500 text-amber-800 p-6 mb-8 rounded-xl shadow-lg">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="font-medium">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Profile Incomplete Warning -->
                @if($profileIncomplete)
                    <div class="bg-gradient-to-r from-red-100 to-red-200 border-l-4 border-red-500 text-red-800 p-6 mb-8 rounded-xl shadow-lg">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium mb-2">Profil Anda belum lengkap untuk melakukan apply lowongan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach($profileWarning as $warning)
                                        <li class="text-sm">{{ $warning }}</li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('mahasiswa.profile') }}" class="inline-block mt-3 bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-200">
                                    Lengkapi Profil
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Profile Summary -->
                <div class="mb-12">
                    <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Profil Anda</h2>
                            <p class="text-gray-600">Informasi yang digunakan untuk memberikan rekomendasi</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm font-medium">Lokasi</p>
                                        <h3 class="font-bold text-lg text-gray-800">{{ $mahasiswa->lokasiPreferensi->nama ?? 'Belum diisi' }}</h3>
                                        <p class="text-blue-500 text-xs">Preferensi</p>
                                    </div>
                                </div>
                            </div>
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-cogs text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm font-medium">Keahlian</p>
                                        <h3 class="font-bold text-lg text-gray-800">{{ $mahasiswa->keahlian->nama ?? 'Belum diisi' }}</h3>
                                        <p class="text-emerald-500 text-xs">Utama</p>
                                    </div>
                                </div>
                            </div>
                            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-heart text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-gray-500 text-sm font-medium">Minat</p>
                                        <h3 class="font-bold text-lg text-gray-800">{{ $mahasiswa->minat->nama ?? 'Belum diisi' }}</h3>
                                        <p class="text-purple-500 text-xs">Bidang</p>
                                    </div>
                                </div>
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
                                        $position = $index + 1;
                                        $rankColors = [
                                            1 => ['bg' => 'bg-gradient-to-r from-yellow-50 to-yellow-100', 'border' => 'border-yellow-300', 'icon' => 'text-yellow-600', 'badge' => 'bg-yellow-500'],
                                            2 => ['bg' => 'bg-gradient-to-r from-gray-50 to-gray-100', 'border' => 'border-gray-300', 'icon' => 'text-gray-600', 'badge' => 'bg-gray-500'],
                                            3 => ['bg' => 'bg-gradient-to-r from-orange-50 to-orange-100', 'border' => 'border-orange-300', 'icon' => 'text-orange-600', 'badge' => 'bg-orange-500']
                                        ];
                                        $colors = $rankColors[$position] ?? $rankColors[3];
                                        $isApplied = in_array($rec['lowongan']->lowongan_id, $applieds);
                                        $isExpired = \Carbon\Carbon::parse($rec['lowongan']->tanggal_akhir)->lt(\Carbon\Carbon::today());
                                    @endphp

                                    <div class="relative {{ $colors['bg'] }} {{ $colors['border'] }} border-2 rounded-xl p-6 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                                        <!-- Ranking Badge -->
                                        <div class="absolute -top-3 -left-3 {{ $colors['badge'] }} text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg shadow-lg">
                                            {{ $position }}
                                        </div>

                                        <!-- Main Content -->
                                        <div class="ml-6">
                                            <!-- Header -->
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-start flex-1">
                                                    @if($position == 1)
                                                        <i class="fas fa-trophy {{ $colors['icon'] }} text-3xl mr-4 mt-1"></i>
                                                    @elseif($position == 2)
                                                        <i class="fas fa-medal {{ $colors['icon'] }} text-3xl mr-4 mt-1"></i>
                                                    @else
                                                        <i class="fas fa-award {{ $colors['icon'] }} text-3xl mr-4 mt-1"></i>
                                                    @endif

                                                    <div class="flex-1">
                                                        <h4 class="text-xl font-bold text-gray-800 mb-1">{{ $rec['lowongan']->judul }}</h4>
                                                        <p class="text-gray-600 mb-2">{{ $rec['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                                        <div class="flex flex-wrap items-center gap-3 text-sm mb-4">
                                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-medium">
                                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                                {{ $rec['lowongan']->kabupaten->nama ?? 'Lokasi tidak tersedia' }}
                                                            </span>
                                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                                                <i class="fas fa-tools mr-1"></i>
                                                                {{ $rec['lowongan']->keahlian->nama ?? 'Keahlian tidak tersedia' }}
                                                            </span>
                                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-medium">
                                                                <i class="fas fa-calendar mr-1"></i>
                                                                Berakhir: {{ \Carbon\Carbon::parse($rec['lowongan']->tanggal_akhir)->format('d M Y') }}
                                                            </span>
                                                            <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full font-medium">
                                                                <i class="fas fa-users mr-1"></i>
                                                                Kuota: {{ $rec['lowongan']->kuota }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Score Display -->
                                                <div class="text-right ml-4">
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

                                            <!-- Method Rankings and Apply Button -->
                                            <div class="flex justify-between items-end pt-4 border-t border-gray-200">
                                                <div class="flex items-center space-x-6">
                                                    <div class="flex space-x-4">
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
                                                        <div class="bg-yellow-100 border border-yellow-300 rounded-lg px-3 py-2">
                                                            <div class="flex items-center">
                                                                <i class="fas fa-star text-yellow-600 mr-2"></i>
                                                                <span class="text-sm font-bold text-yellow-800">Rekomendasi Teratas!</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Apply Button - Moved to bottom right -->
                                                <div class="flex items-center gap-2">
                                                    @if($isExpired)
                                                        <button disabled class="flex items-center px-6 py-3 bg-gray-400 text-white rounded-lg font-semibold cursor-not-allowed opacity-70 transition-all duration-200">
                                                            <i class="fas fa-clock mr-2"></i>
                                                            <span>Berakhir</span>
                                                        </button>
                                                    @elseif($isApplied)
                                                        <button disabled class="flex items-center px-6 py-3 bg-green-500 text-white rounded-lg font-semibold cursor-default shadow-md">
                                                            <i class="fas fa-check-circle mr-2"></i>
                                                            <span>Sudah Dilamar</span>
                                                        </button>
                                                    @elseif($profileIncomplete)
                                                        <button disabled class="flex items-center px-6 py-3 bg-red-400 text-white rounded-lg font-semibold cursor-not-allowed opacity-70" title="Lengkapi profil terlebih dahulu">
                                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                                            <span>Lengkapi Profil</span>
                                                        </button>
                                                    @else
                                                        <form action="{{ route('mahasiswa.lowongan.apply', $rec['lowongan']->lowongan_id) }}" method="POST" class="inline apply-form">
                                                            @csrf
                                                            <button type="submit" class="apply-btn flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300">
                                                                <i class="fas fa-paper-plane mr-2 transition-transform duration-200"></i>
                                                                <span class="btn-text">Lamar Sekarang</span>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
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
                            <span class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">M</span>
                            Top 3 Hasil Metode MOORA
                        </h3>
                        @if(count($mooraResults) > 0)
                            <div class="space-y-4">
                                @foreach($mooraResults as $index => $result)
                                    @php
                                        $rank = $index + 1;
                                        $isApplied = in_array($result['lowongan']->lowongan_id, $applieds);
                                        $isExpired = \Carbon\Carbon::parse($result['lowongan']->tanggal_akhir)->lt(\Carbon\Carbon::today());
                                    @endphp
                                    <div class="border rounded-lg p-4 bg-blue-50">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center flex-1">
                                                <span class="bg-blue-500 text-white px-3 py-2 rounded-full text-sm font-bold mr-4">
                                                    {{ $rank }}
                                                </span>
                                                <div class="flex-1">
                                                    <h4 class="text-lg font-semibold">{{ $result['lowongan']->judul }}</h4>
                                                    <p class="text-sm text-gray-600 mb-2">{{ $result['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right bg-white rounded-lg p-3 shadow-sm ml-4">
                                                <div class="text-sm text-gray-600">Skor MOORA</div>
                                                <div class="text-xl font-bold text-blue-600">{{ number_format($result['score'], 4) }}</div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-4 text-sm bg-white rounded-lg p-3 mb-3">
                                            <div><strong>Jarak:</strong> {{ number_format($result['criteria']['distance'], 1) }} km</div>
                                            <div><strong>Keahlian:</strong> {{ $result['criteria']['skill_match'] }}%</div>
                                            <div><strong>Minat:</strong> {{ $result['criteria']['interest_match'] }}%</div>
                                        </div>

                                        <!-- Apply Button moved to bottom right for MOORA -->
                                        <div class="flex justify-end">
                                            @if($isExpired)
                                                <button disabled class="flex items-center px-4 py-2 bg-gray-400 text-white rounded-lg text-sm font-medium cursor-not-allowed opacity-70">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Berakhir
                                                </button>
                                            @elseif($isApplied)
                                                <button disabled class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium cursor-default">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Dilamar
                                                </button>
                                            @elseif($profileIncomplete)
                                                <button disabled class="flex items-center px-4 py-2 bg-red-400 text-white rounded-lg text-sm font-medium cursor-not-allowed opacity-70">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Profil
                                                </button>
                                            @else
                                                <form action="{{ route('mahasiswa.lowongan.apply', $result['lowongan']->lowongan_id) }}" method="POST" class="inline apply-form">
                                                    @csrf
                                                    <button type="submit" class="apply-btn flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                                        <i class="fas fa-paper-plane mr-1"></i>
                                                        <span class="btn-text">Lamar</span>
                                                    </button>
                                                </form>
                                            @endif
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
                            <span class="bg-green-500 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">E</span>
                            Top 3 Hasil Metode ELECTRE IV
                        </h3>
                        @if(count($electreResults) > 0)
                            <div class="space-y-4">
                                @foreach($electreResults as $index => $result)
                                    @php
                                        $rank = $index + 1;
                                        $isApplied = in_array($result['lowongan']->lowongan_id, $applieds);
                                        $isExpired = \Carbon\Carbon::parse($result['lowongan']->tanggal_akhir)->lt(\Carbon\Carbon::today());
                                    @endphp
                                    <div class="border rounded-lg p-4 bg-green-50">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center flex-1">
                                                <span class="bg-green-500 text-white px-3 py-2 rounded-full text-sm font-bold mr-4">
                                                    {{ $rank }}
                                                </span>
                                                <div class="flex-1">
                                                    <h4 class="text-lg font-semibold">{{ $result['lowongan']->judul }}</h4>
                                                    <p class="text-sm text-gray-600 mb-2">{{ $result['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right bg-white rounded-lg p-3 shadow-sm ml-4">
                                                <div class="text-sm text-gray-600">Skor ELECTRE</div>
                                                <div class="text-xl font-bold text-green-600">{{ $result['score'] }}</div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-4 text-sm bg-white rounded-lg p-3 mb-3">
                                            <div><strong>Jarak:</strong> {{ number_format($result['criteria']['distance'], 1) }} km</div>
                                            <div><strong>Keahlian:</strong> {{ $result['criteria']['skill_match'] }}%</div>
                                            <div><strong>Minat:</strong> {{ $result['criteria']['interest_match'] }}%</div>
                                        </div>

                                        <!-- Apply Button moved to bottom right for ELECTRE -->
                                        <div class="flex justify-end">
                                            @if($isExpired)
                                                <button disabled class="flex items-center px-4 py-2 bg-gray-400 text-white rounded-lg text-sm font-medium cursor-not-allowed opacity-70">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    Berakhir
                                                </button>
                                            @elseif($isApplied)
                                                <button disabled class="flex items-center px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium cursor-default">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Dilamar
                                                </button>
                                            @elseif($profileIncomplete)
                                                <button disabled class="flex items-center px-4 py-2 bg-red-400 text-white rounded-lg text-sm font-medium cursor-not-allowed opacity-70">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Profil
                                                </button>
                                            @else
                                                <form action="{{ route('mahasiswa.lowongan.apply', $result['lowongan']->lowongan_id) }}" method="POST" class="inline apply-form">
                                                    @csrf
                                                    <button type="submit" class="apply-btn flex items-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                                        <i class="fas fa-paper-plane mr-1"></i>
                                                        <span class="btn-text">Lamar</span>
                                                    </button>
                                                </form>
                                            @endif
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

            // Enhanced apply form submission handling
            document.querySelectorAll('.apply-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('.apply-btn');
                    const icon = button.querySelector('i');
                    const text = button.querySelector('.btn-text');

                    // Disable button
                    button.disabled = true;
                    button.classList.add('opacity-70', 'cursor-not-allowed');
                    button.classList.remove('hover:scale-105', 'hover:shadow-lg');

                    // Update button content
                    icon.className = 'fas fa-spinner fa-spin mr-2';
                    text.textContent = 'Mengirim...';

                    // Change button color to indicate processing
                    button.classList.remove('bg-gradient-to-r', 'from-blue-600', 'to-indigo-600', 'hover:from-blue-700', 'hover:to-indigo-700', 'bg-blue-600', 'hover:bg-blue-700', 'bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-yellow-500');
                });
            });

            // Add pulse animation to active apply buttons
            document.querySelectorAll('.apply-btn:not(:disabled)').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.querySelector('i').classList.add('animate-pulse');
                });

                button.addEventListener('mouseleave', function() {
                    this.querySelector('i').classList.remove('animate-pulse');
                });
            });
        });
    </script>

    <style>
        /* Enhanced button animations */
        .apply-btn {
            position: relative;
            overflow: hidden;
        }

        .apply-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .apply-btn:hover::before {
            left: 100%;
        }

        /* Status indicator animations */
        @keyframes statusPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .status-indicator {
            animation: statusPulse 2s infinite;
        }

        /* Improved focus states */
        .apply-btn:focus {
            transform: scale(1.02);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
        }

        /* Loading state enhancement */
        .apply-btn:disabled {
            transform: none !important;
        }

        /* Button text animation */
        .btn-text {
            transition: all 0.2s ease;
        }

        .apply-btn:hover .btn-text {
            letter-spacing: 0.5px;
        }

        /* Color classes for different states */
        .border-gold {
            border-color: #fbbf24;
        }

        .border-silver {
            border-color: #9ca3af;
        }

        .border-bronze {
            border-color: #f97316;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .apply-btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }

            .apply-btn span {
                display: none;
            }

            .apply-btn i {
                margin: 0;
            }
        }
    </style>
@endsection
