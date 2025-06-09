@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-3 sm:p-6 transition-all duration-300 ml-0 sm:ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-100">
    <div class="container mx-auto px-2 sm:px-4">
        <div class="mb-4 sm:mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Rekomendasi Tempat Magang</h1>
            <p class="text-sm sm:text-base text-gray-600">Sistem pendukung keputusan menggunakan metode MOORA dan ELECTRE IV</p>
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
                        <button id="combinedTab" class="tab-button active px-6 py-4 text-sm font-medium transition focus:outline-none" onclick="showTab('combined')">
                            Rekomendasi Gabungan
                        </button>
                        <button id="mooraTab" class="tab-button px-6 py-4 text-sm font-medium transition focus:outline-none" onclick="showTab('moora')">
                            Metode MOORA
                        </button>
                        <button id="electreTab" class="tab-button px-6 py-4 text-sm font-medium transition focus:outline-none" onclick="showTab('electre')">
                            Metode ELECTRE IV
                        </button>
                    </div>
                </div>

                <!-- Combined Results -->
                <div id="combinedContent" class="tab-content p-6">
                    <h3 class="text-lg font-semibold mb-4">Top 3 Rekomendasi Terbaik (Gabungan MOORA & ELECTRE IV)</h3>
                    @if(count($recommendations) > 0)
                        <div class="space-y-4">
                            @foreach($recommendations as $index => $rec)
                            <div class="border rounded-lg p-4 hover:shadow-md transition-shadow
                                @if($index == 0) border-yellow-400 bg-yellow-50
                                @elseif($index == 1) border-gray-400 bg-gray-50
                                @elseif($index == 2) border-orange-400 bg-orange-50 @endif">

                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center">
                                        @if($index == 0)
                                            <div class="flex items-center mr-3">
                                                <i class="fas fa-trophy text-yellow-500 text-2xl mr-2"></i>
                                                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-sm font-bold">1st</span>
                                            </div>
                                        @elseif($index == 1)
                                            <div class="flex items-center mr-3">
                                                <i class="fas fa-medal text-gray-500 text-2xl mr-2"></i>
                                                <span class="bg-gray-500 text-white px-2 py-1 rounded-full text-sm font-bold">2nd</span>
                                            </div>
                                        @elseif($index == 2)
                                            <div class="flex items-center mr-3">
                                                <i class="fas fa-award text-orange-500 text-2xl mr-2"></i>
                                                <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-sm font-bold">3rd</span>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $rec['lowongan']->judul }}</h4>
                                            <p class="text-sm text-gray-600">{{ $rec['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600">Score Gabungan</div>
                                        <div class="text-lg font-bold text-blue-600">{{ number_format($rec['average_rank'], 2) }}</div>
                                        <div class="text-xs text-gray-500">
                                            @if($index == 0) Terbaik
                                            @elseif($index == 1) Sangat Baik
                                            @elseif($index == 2) Baik
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Jarak</p>
                                            <p class="text-sm font-medium">{{ number_format($rec['criteria']['distance'], 1) }} km</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-cogs text-green-500 mr-2"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Kecocokan Keahlian</p>
                                            <p class="text-sm font-medium">{{ $rec['criteria']['skill_match'] }}%</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-heart text-purple-500 mr-2"></i>
                                        <div>
                                            <p class="text-xs text-gray-500">Kecocokan Minat</p>
                                            <p class="text-sm font-medium">{{ $rec['criteria']['interest_match'] }}%</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-3 border-t">
                                    <div class="flex space-x-4 text-sm">
                                        <span class="text-blue-600">MOORA: Rank {{ $rec['moora_rank'] }}</span>
                                        <span class="text-green-600">ELECTRE: Rank {{ $rec['electre_rank'] }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                            {{ $rec['lowongan']->lokasi->nama ?? 'Lokasi tidak tersedia' }}
                                        </span>
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                            {{ $rec['lowongan']->keahlian->nama ?? 'Keahlian tidak tersedia' }}
                                        </span>
                                    </div>
                                </div>

                                @if($index == 0)
                                    <div class="mt-3 p-3 bg-yellow-100 rounded-lg border border-yellow-200">
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-600 mr-2"></i>
                                            <span class="text-sm font-medium text-yellow-800">Rekomendasi Teratas!</span>
                                        </div>
                                        <p class="text-xs text-yellow-700 mt-1">
                                            Lowongan ini paling sesuai dengan profil dan preferensi Anda berdasarkan analisis DSS.
                                        </p>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
                            <h4 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Rekomendasi</h4>
                            <p class="text-gray-500">Belum ada lowongan yang cocok dengan profil Anda saat ini.</p>
                        </div>
                    @endif
                </div>

                <!-- MOORA Results -->
                <div id="mooraContent" class="tab-content p-6 hidden">
                    <h3 class="text-lg font-semibold mb-4">Top 3 Hasil Metode MOORA</h3>
                    @if(count($mooraResults) > 0)
                        <div class="space-y-4">
                            @foreach($mooraResults as $index => $result)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center">
                                        <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-sm font-bold mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $result['lowongan']->judul }}</h4>
                                            <p class="text-sm text-gray-600">{{ $result['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600">Skor MOORA</div>
                                        <div class="text-lg font-bold text-blue-600">{{ number_format($result['score'], 4) }}</div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>Jarak: {{ number_format($result['criteria']['distance'], 1) }} km</div>
                                    <div>Keahlian: {{ $result['criteria']['skill_match'] }}%</div>
                                    <div>Minat: {{ $result['criteria']['interest_match'] }}%</div>
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
                    <h3 class="text-lg font-semibold mb-4">Top 3 Hasil Metode ELECTRE IV</h3>
                    @if(count($electreResults) > 0)
                        <div class="space-y-4">
                            @foreach($electreResults as $index => $result)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex items-center">
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-sm font-bold mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <h4 class="text-lg font-semibold">{{ $result['lowongan']->judul }}</h4>
                                            <p class="text-sm text-gray-600">{{ $result['lowongan']->partner->nama ?? 'Partner tidak tersedia' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-sm text-gray-600">Skor ELECTRE</div>
                                        <div class="text-lg font-bold text-green-600">{{ $result['score'] }}</div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>Jarak: {{ number_format($result['criteria']['distance'], 1) }} km</div>
                                    <div>Keahlian: {{ $result['criteria']['skill_match'] }}%</div>
                                    <div>Minat: {{ $result['criteria']['interest_match'] }}%</div>
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
document.addEventListener('DOMContentLoaded', function() {
    showTab('combined');
});
</script>

<style>
.border-gold { border-color: #fbbf24; }
.border-silver { border-color: #9ca3af; }
.border-bronze { border-color: #f97316; }
</style>
@endsection
