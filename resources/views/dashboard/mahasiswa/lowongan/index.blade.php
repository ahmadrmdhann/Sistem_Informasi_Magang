@extends('layouts.dashboard')

@section('title')
    <title>Lowongan Magang</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Lowongan Magang</h1>
            <p class="text-gray-600 mt-1">Temukan dan ajukan magang ke perusahaan partner yang tersedia</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">{{ session('error') }}</div>
        @endif

        <div class="space-y-6">
            @forelse($lowongans as $lowongan)
                <div
                    class="bg-white rounded-xl shadow p-6 flex flex-col md:flex-row md:items-center md:justify-between hover:shadow-lg transition">
                    <div>
                        <div class="text-xl font-semibold text-blue-700 mb-1">{{ $lowongan->judul }}</div>
                        <div class="text-gray-600 mb-1">
                            <span class="font-medium">{{ $lowongan->partner->nama ?? '-' }}</span>
                            <span class="mx-2">|</span>
                            <span>{{ $lowongan->periode->nama_periode ?? '-' }}</span>
                        </div>
                        <div class="text-gray-500 text-sm mb-2">
                            Lokasi: {{ $lowongan->lokasi }} &bull; Bidang: {{ $lowongan->bidang_keahlian }}
                        </div>
                        <div class="text-gray-700 text-sm mb-2">
                            <span class="font-semibold">Periode:</span>
                            {{ $lowongan->tanggal_mulai }} s/d {{ $lowongan->tanggal_akhir }}
                        </div>
                        <div class="text-gray-500 text-xs line-clamp-2 mb-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($lowongan->deskripsi), 120) }}
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 md:ml-6 flex-shrink-0">
                        <form action="{{ route('mahasiswa.lowongan.apply', $lowongan->lowongan_id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin apply ke lowongan ini?')">
                            @csrf
                            <button type="button"
                                class="py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm shadow openApplyModalBtn"
                                data-id="{{ $lowongan->lowongan_id }}">
                                <i class="fas fa-paper-plane mr-2"></i>Apply
                            </button>

                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8">Tidak ada lowongan tersedia.</div>
            @endforelse
        </div>
    </div>
    <!-- Modal Konfirmasi Apply -->
    <div id="applyModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm relative">
            <button type="button" class="absolute top-2 right-2 text-gray-500 hover:text-black text-xl font-bold"
                id="closeApplyModal">&times;</button>

            <h2 class="text-lg font-semibold mb-4 text-gray-800">Konfirmasi Apply</h2>
            <p class="text-gray-700 mb-6">Apakah kamu yakin ingin apply ke lowongan ini? Pastikan CV sudah terlampir pada profile anda.</p>

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
                    applyForm.action = `/Sistem_Informasi_Magang/public/mahasiswa/lowongan/${lowonganId}/apply`;
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                });
            });

            closeModalBtn.addEventListener("click", () => {
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            });

            // Optional: Tutup modal jika klik di luar konten
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.classList.remove("flex");
                    modal.classList.add("hidden");
                }
            });
        });
    </script>

@endsection