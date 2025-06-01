@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Lowongan</h2>
            <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow" data-modal-target="createLowonganModal"
                data-modal-toggle="createLowonganModal">
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
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $index => $lowongan)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->judul }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->partner->nama }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->periode->nama }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ \Carbon\Carbon::parse($lowongan->tanggal_mulai)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ \Carbon\Carbon::parse($lowongan->tanggal_akhir)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <button type="button"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150 editLowonganBtn"
                                        data-lowongan='@json($lowongan)'>
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    <button type="button"
                                        class="bg-purple-900 hover:bg-green-500 text-white px-3 py-1 rounded shadow transition-colors duration-150 showLowonganBtn"
                                        data-lowongan='@json($lowongan)'>
                                        <i class="fas fa-edit mr-1"></i>show
                                    </button>
                                    <form action="{{ route('lowongan.destroy', $lowongan->lowongan_id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-lowongan-id="{{ $lowongan->lowongan_id }}"
                                            class="btn-delete bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-3 text-center text-gray-500">Tidak ada data Lowongan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- modalista --}}
    <div id="createLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah Lowongan</h3>
                <button type="button" data-modal-hide="createLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form action="{{ route('lowongan.store') }}" method="POST">
                @csrf
                <select name="partner_id" id="partner_id"
                    class="w-full px-3 py-2 border rounded-md @error('partner_id') border-red-500 @enderror" required>
                    <option value="">Pilih Partner</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->partner_id }}" {{ old('partner_id') == $partner->partner_id ? 'selected' : '' }}>
                            {{ $partner->nama }}</option>
                    @endforeach
                </select>
                <div class="mb-4">
                    <label for="judul" class="block text-gray-700">judul</label>
                    <input type="text" name="judul" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700">deskripsi</label>
                    <input type="text" name="deskripsi" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="persyaratan" class="block text-gray-700">persyaratan</label>
                    <input type="text" name="persyaratan" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <select name="lokasi" id="lokasi" class="w-full px-3 py-2 border rounded-md @error('lokasi') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->kabupaten_id }}" {{ old('kabupaten_id') == $lokasi->kabupaten_id ? 'selected' : '' }}>
                            {{ $lokasi->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="mb-4">
                    <label for="bidang_keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                        Bidang Keahlian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bidang_keahlian" id="bidang_keahlian"
                        class="w-full px-3 py-2 border rounded-md @error('bidang_keahlian') border-red-500 @enderror"
                        value="{{ old('bidang_keahlian') }}" placeholder="Masukkan bidang keahlian" required>
                    @error('bidang_keahlian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Periode <span class="text-red-500">*</span>
                    </label>
                    <select name="periode_id" id="periode_id"
                        class="w-full px-3 py-2 border rounded-md @error('periode_id') border-red-500 @enderror" required>
                        <option value="">Pilih Periode</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->periode_id }}" {{ old('periode_id') == $periode->periode_id ? 'selected' : '' }}>
                                {{ $periode->nama }}</option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_mulai') border-red-500 @enderror"
                        value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_akhir') border-red-500 @enderror"
                        value="{{ old('tanggal_akhir') }}" required>
                    @error('tanggal_akhir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>

                <div class="flex justify-end">
                    <button type="button" data-modal-hide="createLowonganModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus Lowongan ini?</p>
            <div class="flex justify-end">
                <button type="button" id="cancelDeleteBtn"
                    class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                <button type="button" id="confirmDeleteBtn"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
            </div>
        </div>
    </div>
    <div id="editLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit User</h3>
                <button type="button" data-modal-hide="editLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form id="editLowonganForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="lowongan_id" id="edit_lowongan_id">
                <select name="partner_id" id="partner_id"
                    class="w-full px-3 py-2 border rounded-md @error('partner_id') border-red-500 @enderror" required>
                    <option value="">Pilih Partner</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->partner_id }}" {{ old('partner_id') == $partner->partner_id ? 'selected' : '' }}>
                            {{ $partner->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="mb-4">
                    <label for="judul" class="block text-gray-700">judul</label>
                    <input type="text" name="judul" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700">deskripsi</label>
                    <input type="text" name="deskripsi" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="persyaratan" class="block text-gray-700">persyaratan</label>
                    <input type="text" name="persyaratan" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <select name="lokasi" id="lokasi" class="w-full px-3 py-2 border rounded-md @error('lokasi') border-red-500 @enderror"
                    required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->kabupaten_id }}" {{ old('kabupaten_id') == $lokasi->kabupaten_id ? 'selected' : '' }}>
                            {{ $lokasi->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="mb-4">
                    <label for="bidang_keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                        Bidang Keahlian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bidang_keahlian" id="bidang_keahlian"
                        class="w-full px-3 py-2 border rounded-md @error('bidang_keahlian') border-red-500 @enderror"
                        value="{{ old('bidang_keahlian') }}" placeholder="Masukkan bidang keahlian" required>
                    @error('bidang_keahlian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Periode <span class="text-red-500">*</span>
                    </label>
                    <select name="periode_id" id="periode_id"
                        class="w-full px-3 py-2 border rounded-md @error('periode_id') border-red-500 @enderror" required>
                        <option value="">Pilih Periode</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->periode_id }}" {{ old('periode_id') == $periode->periode_id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_mulai') border-red-500 @enderror"
                        value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_akhir') border-red-500 @enderror"
                        value="{{ old('tanggal_akhir') }}" required>
                    @error('tanggal_akhir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="editUserModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div id="showLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">show User</h3>
                <button type="button" data-modal-hide="showLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form id="showLowonganForm" method="POST">
                @csrf
                @method('GET')
                <input type="hidden" name="lowongan_id" id="show_lowongan_id">
                <select name="partner_id" id="partner_id"
                    class="w-full px-3 py-2 border rounded-md @error('partner_id') border-red-500 @enderror" required>
                    <option value="">Pilih Partner</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->partner_id }}" {{ old('partner_id') == $partner->partner_id ? 'selected' : '' }}>
                            {{ $partner->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="mb-4">
                    <label for="judul" class="block text-gray-700">judul</label>
                    <input type="text" name="judul" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="block text-gray-700">deskripsi</label>
                    <input type="text" name="deskripsi" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="persyaratan" class="block text-gray-700">persyaratan</label>
                    <input type="text" name="persyaratan" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <select name="lokasi" id="lokasi"
                    class="w-full px-3 py-2 border rounded-md @error('lokasi') border-red-500 @enderror" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->kabupaten_id }}" {{ old('kabupaten_id') == $lokasi->kabupaten_id ? 'selected' : '' }}>
                            {{ $lokasi->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="mb-4">
                    <label for="bidang_keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                        Bidang Keahlian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bidang_keahlian" id="bidang_keahlian"
                        class="w-full px-3 py-2 border rounded-md @error('bidang_keahlian') border-red-500 @enderror"
                        value="{{ old('bidang_keahlian') }}" placeholder="Masukkan bidang keahlian" required>
                    @error('bidang_keahlian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Periode <span class="text-red-500">*</span>
                    </label>
                    <select name="periode_id" id="periode_id"
                        class="w-full px-3 py-2 border rounded-md @error('periode_id') border-red-500 @enderror" required>
                        <option value="">Pilih Periode</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->periode_id }}" {{ old('periode_id') == $periode->periode_id ? 'selected' : '' }}>
                                {{ $periode->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_mulai') border-red-500 @enderror"
                        value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_akhir') border-red-500 @enderror"
                        value="{{ old('tanggal_akhir') }}" required>
                    @error('tanggal_akhir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </form>
        </div>
    </div>
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
                    // Perbaikan 1: Gunakan nama yang konsisten (lowongan, bukan Lowongan)
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Perbaikan 2: Set hidden input dengan ID yang benar
                    document.getElementById("edit_lowongan_id").value = lowongan.lowongan_id;

                    // Perbaikan 3: Populate form fields dengan data lowongan
                    editForm.querySelector('[name="partner_id"]').value = lowongan.partner_id || '';
                    editForm.querySelector('[name="judul"]').value = lowongan.judul || '';
                    editForm.querySelector('[name="deskripsi"]').value = lowongan.deskripsi || '';
                    editForm.querySelector('[name="persyaratan"]').value = lowongan.persyaratan || '';
                    editForm.querySelector('[name="lokasi"]').value = lowongan.lokasi || '';
                    editForm.querySelector('[name="bidang_keahlian"]').value = lowongan.bidang_keahlian || '';
                    editForm.querySelector('[name="periode_id"]').value = lowongan.periode_id || '';
                    editForm.querySelector('[name="tanggal_mulai"]').value = lowongan.tanggal_mulai || '';
                    editForm.querySelector('[name="tanggal_akhir"]').value = lowongan.tanggal_akhir || '';

                    // Perbaikan 4: Set action URL yang benar
                    editForm.action = `/Sistem_Informasi_Magang/public/admin/lowongan/${lowongan.lowongan_id}`;
                    // Atau jika menggunakan named route: editForm.action = "{{ route('lowongan.update', '') }}" + "/" + lowongan.lowongan_id;

                    // Tampilkan modal
                    document.getElementById("editLowonganModal").classList.remove("hidden");
                });
            });

            // Event listener untuk menutup modal
            document.querySelectorAll('[data-modal-hide="editLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("editLowonganModal").classList.add("hidden");
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Perbaikan 1: Gunakan nama variabel yang konsisten
            const showButtons = document.querySelectorAll(".showLowonganBtn"); // bukan .ShowLowonganBtn
            const showForm = document.getElementById("showLowonganForm");

            showButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    // Ambil data lowongan dari attribute
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Set hidden input dengan ID yang benar
                    document.getElementById("show_lowongan_id").value = lowongan.lowongan_id;

                    // Populate form fields dengan data lowongan (readonly untuk show)
                    const partnerSelect = showForm.querySelector('[name="partner_id"]');
                    const judulInput = showForm.querySelector('[name="judul"]');
                    const deskripsiInput = showForm.querySelector('[name="deskripsi"]');
                    const persyaratanInput = showForm.querySelector('[name="persyaratan"]');
                    const lokasiSelect = showForm.querySelector('select[name="lokasi"]');
                    const bidangKeahlianInput = showForm.querySelector('[name="bidang_keahlian"]');
                    const periodeSelect = showForm.querySelector('select[name="periode_id"]');
                    const tanggalMulaiInput = showForm.querySelector('[name="tanggal_mulai"]');
                    const tanggalAkhirInput = showForm.querySelector('[name="tanggal_akhir"]');

                    // Fill values
                    if (partnerSelect) partnerSelect.value = lowongan.partner_id || '';
                    if (judulInput) judulInput.value = lowongan.judul || '';
                    if (deskripsiInput) deskripsiInput.value = lowongan.deskripsi || '';
                    if (persyaratanInput) persyaratanInput.value = lowongan.persyaratan || '';
                    if (lokasiSelect) lokasiSelect.value = lowongan.lokasi || '';
                    if (bidangKeahlianInput) bidangKeahlianInput.value = lowongan.bidang_keahlian || '';
                    if (periodeSelect) periodeSelect.value = lowongan.periode_id || '';
                    if (tanggalMulaiInput) tanggalMulaiInput.value = lowongan.tanggal_mulai || '';
                    if (tanggalAkhirInput) tanggalAkhirInput.value = lowongan.tanggal_akhir || '';

                    // Set semua field menjadi readonly untuk show modal
                    partnerSelect.disabled = true;
                    judulInput.readOnly = true;
                    deskripsiInput.readOnly = true;
                    persyaratanInput.readOnly = true;
                    lokasiSelect.disabled = true;
                    bidangKeahlianInput.readOnly = true;
                    periodeSelect.disabled = true;
                    tanggalMulaiInput.readOnly = true;
                    tanggalAkhirInput.readOnly = true;

                    // Tampilkan modal
                    document.getElementById("showLowonganModal").classList.remove("hidden");
                });
            });

            // Event listener untuk menutup modal
            document.querySelectorAll('[data-modal-hide="showLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    // Reset form fields ketika modal ditutup
                    const showForm = document.getElementById("showLowonganForm");
                    const fields = showForm.querySelectorAll('input, select');
                    fields.forEach(field => {
                        field.readOnly = false;
                        field.disabled = false;
                        field.value = '';
                    });

                    document.getElementById("showLowonganModal").classList.add("hidden");
                });
            });
        });
    </script>
@endsection
