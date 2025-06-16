@extends('layouts.dashboard')

@section('title')
    <title>Manajemen Level</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
            <div class="relative z-10">
                <div class="flex items-center mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                        <i class="fas fa-layer-group text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white">Manajemen Level Pengguna</h2>
                        <p class="text-white/90 text-lg">Kelola tingkat akses dan peran pengguna dalam sistem</p>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-gradient-to-r from-green-400 to-green-500 rounded-2xl p-6 mb-8 text-white shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-white text-xl mr-4"></i>
                    <p class="font-semibold">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-gradient-to-r from-red-400 to-red-500 rounded-2xl p-6 mb-8 text-white shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-white text-xl mr-4"></i>
                    <p class="font-semibold">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="mb-12">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Statistik Level</h3>
                <p class="text-gray-600">Overview data level dalam sistem</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Level -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-layer-group text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $levels->count() }}</h4>
                            <p class="text-blue-500 text-xs">Level</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Level -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-user-shield text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Level</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $levels->where('level_kode', 'ADM')->count() }}</h4>
                            <p class="text-red-500 text-xs">Admin</p>
                        </div>
                    </div>
                </div>

                <!-- User Level -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Level</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $levels->whereNotIn('level_kode', ['ADM'])->count() }}</h4>
                            <p class="text-green-500 text-xs">Pengguna</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Level Table -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Level Pengguna</h3>
                        <p class="text-gray-600">Kelola tingkat akses dan peran dalam sistem</p>
                    </div>
                    <!-- Note: Add button removed as per original code -->
                </div>

                <div class="overflow-x-auto">
                    <table id="levelTable" class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">No</th>
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Kode Level</th>
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Nama Level</th>
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Dibuat</th>
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Diperbarui</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($levels as $index => $level)
                                <tr class="border-b border-gray-50 hover:bg-blue-50/50 transition-all duration-300">
                                    <td class="py-4 px-6 text-gray-700">{{ $index + 1 }}</td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br 
                                                {{ $level->level_kode === 'ADM' ? 'from-red-400 to-red-600' : 
                                                   ($level->level_kode === 'DSN' ? 'from-blue-400 to-blue-600' : 'from-green-400 to-green-600') }}
                                                rounded-full flex items-center justify-center mr-3">
                                                <i class="fas 
                                                    {{ $level->level_kode === 'ADM' ? 'fa-user-shield' : 
                                                       ($level->level_kode === 'DSN' ? 'fa-chalkboard-teacher' : 'fa-user-graduate') }}
                                                    text-white text-sm"></i>
                                            </div>
                                            <span class="font-mono font-semibold text-gray-800">{{ $level->level_kode }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-gray-800">{{ $level->level_nama }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $level->level_kode === 'ADM' ? 'Akses penuh sistem' : 
                                               ($level->level_kode === 'DSN' ? 'Akses dosen pembimbing' : 'Akses mahasiswa') }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">
                                        <div class="text-sm">{{ $level->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $level->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-500">
                                        <div class="text-sm">{{ $level->updated_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $level->updated_at->format('H:i') }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 px-6 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-layer-group text-gray-400 text-2xl"></i>
                                            </div>
                                            <p class="text-lg font-medium text-gray-500">Tidak ada data level</p>
                                            <p class="text-gray-400 text-sm">Data level akan muncul di sini</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Level Information -->
        <div class="mt-8 bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Level</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-2xl p-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-shield text-red-600 text-xl mr-3"></i>
                        <h4 class="font-semibold text-red-800">Administrator</h4>
                    </div>
                    <p class="text-red-700 text-sm">Memiliki akses penuh untuk mengelola seluruh sistem magang mahasiswa.</p>
                </div>
                
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-chalkboard-teacher text-blue-600 text-xl mr-3"></i>
                        <h4 class="font-semibold text-blue-800">Dosen</h4>
                    </div>
                    <p class="text-blue-700 text-sm">Dapat membimbing mahasiswa dan mengelola data terkait bimbingan magang.</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-user-graduate text-green-600 text-xl mr-3"></i>
                        <h4 class="font-semibold text-green-800">Mahasiswa</h4>
                    </div>
                    <p class="text-green-700 text-sm">Dapat mengajukan permohonan magang dan mengelola data pribadi.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- modalismo --}}
    <div id="createUserModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
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
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
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
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
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
                },
                "order": [[0, "asc"]],
                "pageLength": 10,
                "responsive": true
            });
        });

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