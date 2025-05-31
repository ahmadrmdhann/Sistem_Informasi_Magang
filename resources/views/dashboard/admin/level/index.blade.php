@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4 w-auto">
            <h2 class="text-2xl font-bold">Daftar Level</h2>
            <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow" data-modal-target="createUserModal"
                data-modal-toggle="createUserModal">
                <i class="fas fa-plus mr-2"></i>Tambah Level
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="levelTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Kode Level</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Nama Level</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Dibuat</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Diperbarui</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($levels as $index => $level)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 font-mono border-b border-r border-gray-200">
                                {{ $level->level_kode }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $level->level_nama }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">
                                {{ $level->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">
                                {{ $level->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <button type="button"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150 editUserBtn"
                                        data-level='@json($level)'>
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    <form action="{{ route('level.destroy', $level->level_id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus level ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-level-id="{{ $level->level_id }}"
                                            class="btn-delete bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-gray-500">Tidak ada data Level</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- modalismo --}}
    <div id="createUserModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah User</h3>
                <button type="button" data-modal-hide="createUserModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form action="{{ route('level.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="level_kode" class="block text-gray-700">level_kode</label>
                    <input type="text" name="level_kode" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="level_nama" class="block text-gray-700">level_nama</label>
                    <input type="level_nama" name="level_nama" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="createUserModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                    </div>
            </form>
        </div>
    </div>
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus user ini?</p>
            <div class="flex justify-end">
                <button type="button" id="cancelDeleteBtn"
                    class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                <button type="button" id="confirmDeleteBtn"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
            </div>
        </div>
    </div>
    <div id="editlevelModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit User</h3>
                <button type="button" data-modal-hide="editlevelModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form id="editLevelForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="level_id" id="edit_level_id">
                <div class="mb-4">
                    <label for="edit_level_kode" class="block text-gray-700">level_kode</label>
                    <input id="edit_level_kode" type="text" name="level_kode"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="edit_level_nama" class="block text-gray-700">level_nama</label>
                    <input id="edit_level_nama" type="text" name="level_nama"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>      </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="editlevelModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#levelTable').DataTable({
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

        // Ketika tombol delete ditekan
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                formToDelete = button.closest('form'); // Ambil form dari tombol yang ditekan
                document.getElementById('deleteConfirmModal').classList.remove('hidden'); // Tampilkan modal
            });
        });

        // Jika tombol konfirmasi hapus ditekan
        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
            if (formToDelete) {
                formToDelete.submit(); // Submit form yang sudah disimpan saat klik delete
            }
        });

        // Jika user membatalkan penghapusan
        document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
            formToDelete = null;
            document.getElementById('deleteConfirmModal').classList.add('hidden'); // Sembunyikan modal
        });
    </script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                        const editButtons = document.querySelectorAll(".editUserBtn");
                        const editForm = document.getElementById("editLevelForm");

                        editButtons.forEach(btn => {
                            btn.addEventListener("click", () => {
                                const level = JSON.parse(btn.getAttribute("data-level"));

                                document.getElementById("edit_level_id").value = level.level_id;
                                document.getElementById("edit_level_kode").value = level.level_kode;
                                document.getElementById("edit_level_nama").value = level.level_nama;

                                editForm.action = `/Sistem_Informasi_Magang/public/admin/level/${level.level_id}`; 

                                document.getElementById("editlevelModal").classList.remove("hidden");
                            });
                        });

                        document.querySelectorAll('[data-modal-hide="editlevelModal"]').forEach(btn => {
                            btn.addEventListener("click", () => {
                                document.getElementById("editlevelModal").classList.add("hidden");
                            });
                        });
                    });

            </script>

@endsection