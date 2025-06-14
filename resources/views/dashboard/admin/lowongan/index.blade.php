@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Lowongan</h2>
            <button class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1"
                data-modal-target="createLowonganModal" data-modal-toggle="createLowonganModal">
                <i class="fas fa-plus mr-2"></i>Tambah Lowongan
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="lowonganTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Judul</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Mitra</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Periode</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Tanggal Mulai</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Tanggal Akhir</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Kuota</th> <!-- Tambahkan ini -->
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $index => $lowongan)
                        <tr class="even:bg-blue-50 table-row-hover transition-all duration-200">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->judul }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->partner->nama }}
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->periode->nama }}
                            </td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">
                                {{ \Carbon\Carbon::parse($lowongan->tanggal_mulai)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">
                                {{ \Carbon\Carbon::parse($lowongan->tanggal_akhir)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ $lowongan->kuota }}</td>
                            <!-- Tambahkan ini -->
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center items-center space-x-2">
                                    <!-- View/Show Button -->
                                    <button type="button"
                                        class="btn-action btn-focus inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 showLowonganBtn"
                                        data-lowongan='@json($lowongan)'
                                        data-partner-nama="{{ $lowongan->partner->nama ?? '-' }}"
                                        data-lokasi-nama="{{ $lowongan->kabupaten->nama ?? '-' }}"
                                        data-keahlian-nama="{{ $lowongan->keahlian->nama ?? '-' }}"
                                        data-periode-nama="{{ $lowongan->periode->nama ?? '-' }}"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye mr-1.5"></i>
                                        <span>Lihat</span>
                                    </button>

                                    <!-- Edit Button -->
                                    <button type="button"
                                        class="btn-action btn-focus inline-flex items-center px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1 editLowonganBtn"
                                        data-lowongan='@json($lowongan)'
                                        title="Edit Lowongan">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('lowongan.destroy', $lowongan->lowongan_id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            data-lowongan-id="{{ $lowongan->lowongan_id }}"
                                            class="btn-action btn-focus inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg shadow-sm transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 btn-delete"
                                            title="Hapus Lowongan">
                                            <i class="fas fa-trash mr-1.5"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-3 text-center text-gray-500">Tidak ada data Lowongan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- modalista --}}
    <div id="createLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah Lowongan</h3>
                <button type="button" data-modal-hide="createLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <form action="{{ route('lowongan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="partner_id" class="block text-gray-700">Partner</label>
                        <select name="partner_id" id="partner_id"
                            class="w-full px-3 py-2 border rounded-md @error('partner_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Partner</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->partner_id }}" {{ old('partner_id') == $partner->partner_id ? 'selected' : '' }}>
                                    {{ $partner->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="judul" class="block text-gray-700">Judul</label>
                        <input type="text" name="judul" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2"
                            class="w-full border border-gray-300 rounded px-3 py-2 resize-y"
                            required>{{ old('deskripsi') }}</textarea>
                    </div>
                    <div>
                        <label for="persyaratan" class="block text-gray-700">Persyaratan</label>
                        <input type="text" name="persyaratan" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                    </div>
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <select name="lokasi" id="lokasi"
                            class="w-full px-3 py-2 border rounded-md @error('lokasi') border-red-500 @enderror" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($kabupatens as $lokasi)
                                <option value="{{ $lokasi->kabupaten_id }}" {{ old('kabupaten_id') == $lokasi->kabupaten_id ? 'selected' : '' }}>
                                    {{ $lokasi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                            Keahlian <span class="text-red-500">*</span>
                        </label>
                        <select name="keahlian" id="keahlian"
                            class="w-full px-3 py-2 border rounded-md @error('keahlian') border-red-500 @enderror" required>
                            <option value="">Pilih Bidang Keahlian</option>
                            @foreach($keahlians as $keahlian)
                                <option value="{{ $keahlian->keahlian_id }}" {{ old('keahlian_id') == $keahlian->keahlian_id ? 'selected' : '' }}>
                                    {{ $keahlian->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Periode <span class="text-red-500">*</span>
                        </label>
                        <select name="periode_id" id="periode_id"
                            class="w-full px-3 py-2 border rounded-md @error('periode_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->periode_id }}" {{ old('periode_id') == $periode->periode_id ? 'selected' : '' }}>
                                    {{ $periode->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kuota" class="block text-gray-700">Kuota</label>
                        <input type="number" name="kuota" id="kuota"
                            class="w-full border border-gray-300 rounded px-3 py-2 resize-y" required
                            value="{{ old('kuota') }}">
                    </div>
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            class="w-full px-3 py-2 border rounded-md @error('tanggal_mulai') border-red-500 @enderror"
                            value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div>
                        <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Akhir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                            class="w-full px-3 py-2 border rounded-md @error('tanggal_akhir') border-red-500 @enderror"
                            value="{{ old('tanggal_akhir') }}" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" data-modal-hide="createLowonganModal"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus Lowongan ini?</p>
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelDeleteBtn"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" id="confirmDeleteBtn"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
    {{-- Modal Show Lowongan --}}
    <div id="showLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Detail Lowongan</h3>
                <button type="button" data-modal-hide="showLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Partner</label>
                    <p id="show_partner" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Judul</label>
                    <p id="show_judul" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Deskripsi</label>
                    <p id="show_deskripsi" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 min-h-[100px]">
                    </p>
                </div>
                <div>
                    <label class="block text-gray-700">Persyaratan</label>
                    <p id="show_persyaratan" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Lokasi</label>
                    <p id="show_lokasi" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Bidang Keahlian</label>
                    <p id="show_keahlian" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Periode</label>
                    <p id="show_periode" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Tanggal Mulai</label>
                    <p id="show_tanggal_mulai" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Tanggal Akhir</label>
                    <p id="show_tanggal_akhir" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Kuota</label>
                    <p id="show_kuota" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end">
                <button type="button" data-modal-hide="showLowonganModal"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Edit Lowongan --}}
    <div id="editLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit Lowongan</h3>
                <button type="button" data-modal-hide="editLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <form id="editLowonganForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="lowongan_id" id="edit_lowongan_id">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_partner_id" class="block text-gray-700">Partner</label>
                        <select name="partner_id" id="edit_partner_id"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="">Pilih Partner</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->partner_id }}">{{ $partner->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_judul" class="block text-gray-700">Judul</label>
                        <input type="text" name="judul" id="edit_judul"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_deskripsi" class="block text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" rows="2"
                            class="w-full border border-gray-300 rounded px-3 py-2 resize-y" required></textarea>
                    </div>
                    <div>
                        <label for="edit_persyaratan" class="block text-gray-700">Persyaratan</label>
                        <input type="text" name="persyaratan" id="edit_persyaratan"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_lokasi" class="block text-gray-700">Lokasi</label>
                        <select name="lokasi" id="edit_lokasi" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($kabupatens as $lokasi)
                                <option value="{{ $lokasi->kabupaten_id }}">{{ $lokasi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_keahlian" class="block text-gray-700">Bidang Keahlian</label>
                        <select name="keahlian" id="edit_keahlian" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                            <option value="">Pilih Keahlian</option>
                            @foreach($keahlians as $keahlian)
                                <option value="{{ $keahlian->keahlian_id }}">{{ $keahlian->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_periode_id" class="block text-gray-700">Periode</label>
                        <select name="periode_id" id="edit_periode_id"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->periode_id }}">{{ $periode->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_kuota" class="block text-gray-700">Kuota</label>
                        <input type="number" name="kuota" id="edit_kuota"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_tanggal_mulai" class="block text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_tanggal_akhir" class="block text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="edit_tanggal_akhir"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                </div>
                <div class="mt-6 col-span-2 flex justify-end space-x-3">
                    <button type="button" data-modal-hide="editLowonganModal"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Custom Styling for Enhanced Button Appearance --}}
    <style>
        /* Enhanced button hover effects */
        .btn-action {
            position: relative;
            overflow: hidden;
            transform: translateZ(0);
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-action:hover::before {
            left: 100%;
        }

        /* Button loading state */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        /* Enhanced focus states */
        .btn-focus:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        /* Improved table row hover */
        .table-row-hover:hover {
            background-color: #eff6ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }
    </style>

    {{-- Update the show modal JavaScript --}}
    <script>
        // Show Modal JavaScript
        document.addEventListener("DOMContentLoaded", () => {
            const showButtons = document.querySelectorAll(".showLowonganBtn");

            showButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Update show modal fields
                    document.getElementById("show_partner").textContent = btn.getAttribute("data-partner-nama");
                    document.getElementById("show_judul").textContent = lowongan.judul;
                    document.getElementById("show_deskripsi").textContent = lowongan.deskripsi;
                    document.getElementById("show_persyaratan").textContent = lowongan.persyaratan;
                    document.getElementById("show_lokasi").textContent = btn.getAttribute("data-lokasi-nama");
                    document.getElementById("show_keahlian").textContent = btn.getAttribute("data-keahlian-nama");
                    document.getElementById("show_periode").textContent = btn.getAttribute("data-periode-nama");
                    document.getElementById("show_tanggal_mulai").textContent =
                        new Date(lowongan.tanggal_mulai).toLocaleDateString('id-ID');
                    document.getElementById("show_tanggal_akhir").textContent =
                        new Date(lowongan.tanggal_akhir).toLocaleDateString('id-ID');
                    document.getElementById("show_kuota").textContent = lowongan.kuota;

                    document.getElementById("showLowonganModal").classList.remove("hidden");
                });
            });

            // Close modal handler
            document.querySelectorAll('[data-modal-hide="showLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("showLowonganModal").classList.add("hidden");
                });
            });
        });

        // Edit Modal JavaScript
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".editLowonganBtn");
            const editForm = document.getElementById("editLowonganForm");

            editButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Update form fields
                    document.getElementById("edit_lowongan_id").value = lowongan.lowongan_id;
                    document.getElementById("edit_partner_id").value = lowongan.partner_id;
                    document.getElementById("edit_judul").value = lowongan.judul;
                    document.getElementById("edit_deskripsi").value = lowongan.deskripsi;
                    document.getElementById("edit_persyaratan").value = lowongan.persyaratan;
                    document.getElementById("edit_lokasi_id").value = lowongan.kabupaten_id;
                    document.getElementById("edit_keahlian_id").value = lowongan.keahlian_id;
                    document.getElementById("edit_periode_id").value = lowongan.periode_id;
                    document.getElementById("edit_tanggal_mulai").value = lowongan.tanggal_mulai;
                    document.getElementById("edit_tanggal_akhir").value = lowongan.tanggal_akhir;
                    document.getElementById("edit_kuota").value = lowongan.kuota;

                    editForm.action = `/admin/lowongan/${lowongan.lowongan_id}`;
                    document.getElementById("editLowonganModal").classList.remove("hidden");
                });
            });

            // Close modal handler
            document.querySelectorAll('[data-modal-hide="editLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("editLowonganModal").classList.add("hidden");
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#lowonganTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-modal-target');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.remove('hidden');
                }
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-modal-hide');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.add('hidden');
                }
            });
        });

    </script>
    <script>
        let formToDelete = null;


        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                formToDelete = button.closest('form');
                document.getElementById('deleteConfirmModal').classList.remove('hidden');
            });
        });


        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
            if (formToDelete) {
                formToDelete.submit();
            }
        });


        document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
            formToDelete = null;
            document.getElementById('deleteConfirmModal').classList.add('hidden'); // Sembunyikan modal
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".editLowonganBtn");
            const editForm = document.getElementById("editLowonganForm");

            editButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    document.getElementById("edit_lowongan_id").value = lowongan.lowongan_id;
                    document.getElementById("edit_partner_id").value = lowongan.partner_id;
                    document.getElementById("edit_judul").value = lowongan.judul;
                    document.getElementById("edit_deskripsi").value = lowongan.deskripsi;
                    document.getElementById("edit_persyaratan").value = lowongan.persyaratan;
                    document.getElementById("edit_lokasi").value = lowongan.kabupaten_id;
                    document.getElementById("edit_keahlian").value = lowongan.keahlian_id; // field ID, bukan relasi
                    document.getElementById("edit_periode_id").value = lowongan.periode_id;
                    document.getElementById("edit_tanggal_mulai").value = lowongan.tanggal_mulai;
                    document.getElementById("edit_tanggal_akhir").value = lowongan.tanggal_akhir;
                    document.getElementById("edit_kuota").value = lowongan.kuota;

                    editForm.action = `/admin/lowongan/${lowongan.lowongan_id}`;
                    document.getElementById("editLowonganModal").classList.remove("hidden");
                });
            });

            // Handler untuk menutup modal
            document.querySelectorAll('[data-modal-hide="editLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("editLowonganModal").classList.add("hidden");
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const showButtons = document.querySelectorAll(".showLowonganBtn");

            showButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Mapping nama partner, lokasi, periode dari ID ke teks
                    const partner = btn.getAttribute("data-partner-nama");
                    const lokasi = btn.getAttribute("data-lokasi-nama");
                    const periode = btn.getAttribute("data-periode-nama");

                    document.getElementById("show_partner").textContent = partner || '';
                    document.getElementById("show_judul").textContent = lowongan.judul || '';
                    document.getElementById("show_deskripsi").textContent = lowongan.deskripsi || '';
                    document.getElementById("show_persyaratan").textContent = lowongan.persyaratan || '';
                    document.getElementById("show_lokasi").textContent = lokasi || '';
                    document.getElementById("show_bidang_keahlian").textContent = lowongan.bidang_keahlian || '';
                    document.getElementById("show_periode").textContent = periode || '';
                    document.getElementById("show_tanggal_mulai").textContent = lowongan.tanggal_mulai || '';
                    document.getElementById("show_tanggal_akhir").textContent = lowongan.tanggal_akhir || '';

                    document.getElementById("showLowonganModal").classList.remove("hidden");
                });
            });

            // Close modal
            document.querySelectorAll('[data-modal-hide="showLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    const fields = document.querySelectorAll('#showLowonganForm p');
                    fields.forEach(p => p.textContent = '');
                    document.getElementById("showLowonganModal").classList.add("hidden");
                });
            });
        });

    </script>
@endsection