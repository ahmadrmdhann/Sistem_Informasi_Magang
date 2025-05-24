@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pengajuan Magang</h1>
            <p class="text-gray-600 mt-1">Ajukan permohonan magang ke perusahaan partner atau lihat status pengajuan Anda</p>
        </div>

        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex flex-wrap" aria-label="Tabs">
                    <button id="tabForm"
                        class="tab-btn text-sm font-medium px-5 py-3.5 border-b-2 -mb-px text-blue-600 border-blue-600 active">
                        <i class="fas fa-file-signature mr-2"></i>Ajukan Magang
                    </button>
                    <button id="tabStatus"
                        class="tab-btn text-sm font-medium px-5 py-3.5 border-b-2 -mb-px text-gray-500 border-transparent hover:text-blue-600 hover:border-blue-600">
                        <i class="fas fa-list-check mr-2"></i>Status Pengajuan
                    </button>
                </nav>
            </div>

            <div class="p-0">
                {{-- Form Pengajuan --}}
                <div id="formPengajuan" class="tab-content p-5">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Pastikan data yang Anda masukkan sudah benar sebelum mengirimkan pengajuan magang.
                                </p>
                            </div>
                        </div>
                    </div>

                    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="lowongan_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Pilih Lowongan/Perusahaan <span class="text-red-500">*</span>
                                </label>
                                <select id="lowongan_id" name="lowongan_id"
                                    class="py-2.5 px-3 block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                    <option value="">-- Pilih Lowongan --</option>
                                    @foreach($lowongans as $lowongan)
                                        <option value="{{ $lowongan->lowongan_id }}">
                                            {{ $lowongan->partner_nama }} - {{ $lowongan->judul }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Periode Magang <span class="text-red-500">*</span>
                                </label>
                                <select id="periode_id" name="periode_id"
                                    class="py-2.5 px-3 block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                    <option value="">-- Pilih Periode --</option>
                                    @foreach($periodes as $periode)
                                        <option value="{{ $periode->periode_id }}">
                                            {{ $periode->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="motivasi" class="block text-sm font-medium text-gray-700 mb-1">
                                Surat Motivasi <span class="text-red-500">*</span>
                            </label>
                            <textarea id="motivasi" name="motivasi"
                                class="py-2.5 px-3 block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Tuliskan motivasi dan alasan Anda memilih perusahaan ini untuk magang" rows="4"
                                required></textarea>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Dokumen Pendukung
                            </label>
                            
                            <div class="space-y-3">
                                <div class="flex items-center p-3 border border-gray-200 rounded-lg bg-white">
                                    <div class="flex-shrink-0 text-gray-400">
                                        <i class="fas fa-file-pdf"></i>
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <p class="text-sm font-medium text-gray-800">CV</p>
                                    </div>
                                    <input type="file" name="cv" class="file-input">
                                    <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Upload
                                    </button>
                                </div>

                                <div class="flex items-center p-3 border border-gray-200 rounded-lg bg-white">
                                    <div class="flex-shrink-0 text-gray-400">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <p class="text-sm font-medium text-gray-800">Surat Pengantar</p>
                                    </div>
                                    <input type="file" name="surat_pengantar" class="file-input">
                                    <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Upload
                                    </button>
                                </div>

                                <div class="flex items-center p-3 border border-gray-200 rounded-lg bg-white">
                                    <div class="flex-shrink-0 text-gray-400">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="ml-3 flex-grow">
                                        <p class="text-sm font-medium text-gray-800">Transkrip Nilai</p>
                                    </div>
                                    <input type="file" name="transkrip" class="file-input">
                                    <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <button type="button" class="py-2.5 px-4 text-gray-700 border border-gray-300 font-medium rounded-lg text-sm">
                                Batal
                            </button>
                            <button type="submit" class="py-2.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm">
                                <i class="fas fa-paper-plane mr-2"></i>Ajukan Magang
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Status Pengajuan --}}
                <div id="statusPengajuan" class="tab-content p-5 hidden">
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Berikut adalah status pengajuan magang Anda. Silakan periksa secara berkala untuk melihat pembaruan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="min-w-full inline-block align-middle">
                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 bg-white">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perusahaan</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posisi</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Pengajuan</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($pengajuans as $pengajuan)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $pengajuan->partner_nama }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $pengajuan->lowongan_judul }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    {{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d M Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($pengajuan->status == 'diterima')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check-circle mr-1"></i> Diterima
                                                        </span>
                                                    @elseif($pengajuan->status == 'ditolak')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            <i class="fas fa-times-circle mr-1"></i> Ditolak
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                            <i class="fas fa-clock mr-1"></i> Dalam Proses
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                                    <button type="button" class="text-blue-600 hover:text-blue-900">
                                                        <i class="fas fa-eye mr-1"></i> Detail
                                                    </button>
                                                    @if($pengajuan->status == 'diterima')
                                                    <a href="#" class="text-green-600 hover:text-green-900 ml-3">
                                                        <i class="fas fa-download mr-1"></i> Unduh Surat
                                                    </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                    Belum ada pengajuan magang.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hide file input and style --}}
    <style>
        .file-input {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }
    </style>

    {{-- Tab Switcher --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabForm = document.getElementById('tabForm');
            const tabStatus = document.getElementById('tabStatus');
            const formPengajuan = document.getElementById('formPengajuan');
            const statusPengajuan = document.getElementById('statusPengajuan');

            tabForm.addEventListener('click', function () {
                tabForm.classList.add('text-blue-600', 'border-blue-600');
                tabForm.classList.remove('text-gray-500', 'border-transparent');
                tabStatus.classList.remove('text-blue-600', 'border-blue-600');
                tabStatus.classList.add('text-gray-500', 'border-transparent');
                formPengajuan.classList.remove('hidden');
                statusPengajuan.classList.add('hidden');
            });

            tabStatus.addEventListener('click', function () {
                tabStatus.classList.add('text-blue-600', 'border-blue-600');
                tabStatus.classList.remove('text-gray-500', 'border-transparent');
                tabForm.classList.remove('text-blue-600', 'border-blue-600');
                tabForm.classList.add('text-gray-500', 'border-transparent');
                formPengajuan.classList.add('hidden');
                statusPengajuan.classList.remove('hidden');
            });
            
            // File upload button functionality
            document.querySelectorAll('.text-blue-600.hover\\:text-blue-800').forEach(button => {
                button.addEventListener('click', function() {
                    this.previousElementSibling.click();
                });
            });
        });
    </script>
@endsection