@extends('layouts.dashboard')

@section('title', 'Lowongan Magang')

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
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Daftar Lowongan Magang</h1>
                            <p class="text-xl text-white/90">Temukan dan ajukan magang ke perusahaan partner yang tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search Form --}}
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Cari Lowongan</h2>
                <form action="{{ route('mahasiswa.lowongan.index') }}" method="GET">
                    <div class="flex max-w-md">
                        <input type="text" name="q" value="{{ old('q', $q ?? '') }}"
                            class="w-full rounded-l-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400"
                            placeholder="Cari lowongan, partner, bidang...">
                        <button type="submit" class="bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white px-6 py-3 rounded-r-xl font-medium transition-all duration-300">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- Warning jika profile belum lengkap --}}
            @if ($profileIncomplete ?? false)
                <div class="bg-gradient-to-r from-amber-100 to-orange-100 border-l-4 border-amber-500 text-amber-800 p-6 mb-8 rounded-xl shadow-lg">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center mr-4 flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-white text-sm"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg mb-2">Profile belum lengkap!</h3>
                            @foreach($profileWarning ?? [] as $pw)
                                <p class="mb-1">• {{ $pw }}</p>
                            @endforeach
                            <a href="{{ route('mahasiswa.profile') }}" class="inline-flex items-center mt-3 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium transition-colors">
                                <i class="fas fa-user-edit mr-2"></i>Lengkapi Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">{{ session('error') }}</div>
        @endif

            <!-- Lowongan List -->
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Lowongan Tersedia</h2>
                        <p class="text-gray-600">Pilih lowongan yang sesuai dengan minat dan keahlian Anda</p>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($lowongans as $lowongan)
                        <div class="group bg-gradient-to-br from-indigo-50 to-blue-100 rounded-2xl p-6 border border-indigo-200 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-blue-600 rounded-xl flex items-center justify-center mr-4">
                                            <i class="fas fa-building text-white text-lg"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-indigo-700 group-hover:text-indigo-800 transition-colors">{{ $lowongan->judul }}</h3>
                                            <p class="text-gray-600 font-medium">{{ $lowongan->partner->nama ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>
                                            <span class="text-sm">{{ $lowongan->periode->nama ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>
                                            <span class="text-sm">{{ $lowongan->kabupaten->nama ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-cog text-cyan-500 mr-2"></i>
                                            <span class="text-sm">{{ $lowongan->keahlian->nama ?? '-' }}</span>
                                        </div>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-clock text-indigo-500 mr-2"></i>
                                            <span class="text-sm">{{ $lowongan->tanggal_mulai }} - {{ $lowongan->tanggal_akhir }}</span>
                                        </div>
                                    </div>
                                    <div class="bg-white/60 rounded-lg p-3 mb-4">
                                        <p class="text-gray-700 text-sm line-clamp-2">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($lowongan->deskripsi), 150) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-6 flex-shrink-0">
                                    @php
                                        $isApplied = in_array($lowongan->lowongan_id, $applieds ?? []);
                                    @endphp
                                    <form action="{{ route('mahasiswa.lowongan.apply', $lowongan->lowongan_id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin apply ke lowongan ini?')">
                                        @csrf
                                        @if ($isApplied)
                                            <button type="button"
                                                class="py-3 px-6 bg-gray-400 text-white font-medium rounded-xl text-sm shadow cursor-not-allowed flex items-center">
                                                <i class="fas fa-check mr-2"></i>Applied
                                            </button>
                                        @elseif ($profileIncomplete ?? false)
                                            <button type="button"
                                                class="py-3 px-6 bg-gray-300 text-gray-600 font-medium rounded-xl text-sm shadow cursor-not-allowed flex items-center">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>Lengkapi Profile
                                            </button>
                                        @else
                                            <button type="button"
                                                class="py-3 px-6 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-medium rounded-xl text-sm shadow transform hover:scale-105 transition-all duration-300 openApplyModalBtn flex items-center"
                                                data-id="{{ $lowongan->lowongan_id }}">
                                                <i class="fas fa-paper-plane mr-2"></i>Apply
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-search text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada lowongan tersedia</h3>
                            <p class="text-gray-500 max-w-md mx-auto">Saat ini belum ada lowongan yang sesuai dengan pencarian Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Apply --}}
    <div id="applyModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm relative">
            <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl font-bold"
                id="closeApplyModal">&times;</button>

            <h2 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Apply</h2>
            <p class="text-gray-700 mb-6">Apakah kamu yakin ingin apply ke lowongan ini? Pastikan CV sudah terlampir pada
                profile anda.</p>

            <form id="applyForm" method="POST">
                @csrf
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium text-sm">
                    Ya, Apply Sekarang
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("applyModal");
            const closeModalBtn = document.getElementById("closeApplyModal");
            const applyForm = document.getElementById("applyForm");

            document.querySelectorAll(".openApplyModalBtn").forEach(button => {
                button.addEventListener("click", () => {
                    const lowonganId = button.getAttribute("data-id");
                    applyForm.action = `/mahasiswa/lowongan/${lowonganId}/apply`;
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                });
            });

            closeModalBtn.addEventListener("click", () => {
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            });

            // Tutup modal jika klik di luar konten
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.classList.remove("flex");
                    modal.classList.add("hidden");
                }
            });
        });
    </script>
@endsection
