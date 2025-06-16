@extends('layouts.dashboard')

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
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Manajemen Pengguna</h1>
                            <p class="text-white/80">Kelola semua pengguna dalam sistem</p>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-2xl mb-6 shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-2xl mr-4"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Statistik Pengguna</h3>
                    <p class="text-gray-600">Overview data pengguna dalam sistem</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Total Users -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $users->count() }}</h4>
                                <p class="text-blue-500 text-xs">Pengguna</p>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Users -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-shield text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Admin</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $users->where('level.level_kode', 'ADM')->count() }}</h4>
                                <p class="text-red-500 text-xs">Administrator</p>
                            </div>
                        </div>
                    </div>

                    <!-- Dosen Users -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Dosen</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $users->where('level.level_kode', 'DSN')->count() }}</h4>
                                <p class="text-purple-500 text-xs">Pengajar</p>
                            </div>
                        </div>
                    </div>

                    <!-- Mahasiswa Users -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-graduate text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Mahasiswa</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $users->where('level.level_kode', 'MHS')->count() }}</h4>
                                <p class="text-green-500 text-xs">Peserta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Pengguna</h3>
                            <p class="text-gray-600">Kelola akun pengguna sistem</p>
                        </div>
                        <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg flex items-center gap-2"
                            data-modal-target="createUserModal" data-modal-toggle="createUserModal">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Pengguna</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="userTable" class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-blue-100">
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Level</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                        <td class="px-6 py-5">
                                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center text-white font-bold shadow-lg">
                                                1
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12 rounded-xl 
                                                    {{ $user->level->level_kode === 'ADM' ? 'bg-gradient-to-br from-red-400 to-red-600' : 
                                                       ($user->level->level_kode === 'DSN' ? 'bg-gradient-to-br from-purple-400 to-purple-600' : 
                                                        'bg-gradient-to-br from-green-400 to-green-600') }} 
                                                    flex items-center justify-center text-white font-bold shadow-lg">
                                                    {{ strtoupper(substr($user->nama, 0, 2)) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $user->nama }}</div>
                                                    <div class="text-xs text-gray-500">{{ $user->username }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center">
                                                <i class="far fa-envelope text-gray-400 mr-2"></i>
                                                <span class="text-sm text-gray-900">{{ $user->email }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                {{ $user->level->level_kode === 'ADM' ? 'bg-red-50 text-red-700 border border-red-200' : 
                                                   ($user->level->level_kode === 'DSN' ? 'bg-purple-50 text-purple-700 border border-purple-200' : 
                                                    'bg-green-50 text-green-700 border border-green-200') }}">
                                                {{ $user->level->level_nama }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-2">
                                                <button type="button" 
                                                    class="editUserBtn inline-flex items-center px-3 py-2 border border-yellow-200 rounded-lg text-sm font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200"
                                                    data-user='@json($user)'>
                                                    <i class="fas fa-edit mr-2"></i>
                                                    Edit
                                                </button>
                                                <form action="{{ route('user.destroy', $user->user_id) }}" method="POST" class="delete-user-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" data-user-id="{{ $user->user_id }}"
                                                        class="btn-delete inline-flex items-center px-3 py-2 border border-red-200 rounded-lg text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                        <i class="fas fa-trash-alt mr-2"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-20 h-20 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center mb-4 transform -rotate-6">
                                                    <i class="fas fa-users text-2xl"></i>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900 mb-1">Tidak ada data pengguna</h3>
                                                <p class="text-gray-500">Klik tombol "Tambah Pengguna" untuk menambahkan data baru</p>
                                            </div>
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

    {{-- modal modal modal cuyy --}}
        <div id="createUserModal" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-700">Tambah User</h3>
                    <button type="button" data-modal-hide="createUserModal" class="text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>

                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700">Username</label>
                        <input type="text" name="username" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" name="password" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700">Nama</label>
                        <input type="text" name="nama" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="level_id" class="block text-gray-700">Level</label>
                        <select name="level_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                            @endforeach
                        </select>
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
        <div id="editUserModal" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-700">Edit User</h3>
                    <button type="button" data-modal-hide="editUserModal" class="text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_id" id="edit_user_id">
                    <div class="mb-4">
                        <label class="block text-gray-700">Nama</label>
                        <input type="text" name="nama" id="edit_nama" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="email" id="edit_email" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Username</label>
                        <input type="text" name="username" id="edit_username"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700">Level</label>
                        <select name="level_id" id="edit_level_id" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                            @foreach ($levels as $level)
                                <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" data-modal-hide="editUserModal"
                            class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                const table = $('#userTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                    },
                    "pageLength": 7,
                    "ordering": true,
                    "responsive": true,
                    "dom": "<'overflow-x-auto'rt><'flex flex-col md:flex-row justify-center items-center gap-4 mt-6'<'flex items-center'p>>",
                    "searching": false,
                    "info": false,
                    "columnDefs": [
                        {
                            "targets": [0],
                            "searchable": false,
                            "render": function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            "targets": [4],
                            "orderable": false
                        }
                    ],
                    "order": [[0, "asc"]],
                    "drawCallback": function(settings) {
                        // Style pagination buttons
                        $('.dataTables_paginate .paginate_button').removeClass().addClass('px-4 py-2 bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 mx-1 rounded-xl shadow-sm');
                        $('.dataTables_paginate .paginate_button.current').removeClass().addClass('px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 text-sm font-medium text-white mx-1 rounded-xl shadow-md');
                        $('.dataTables_paginate .paginate_button.disabled').removeClass().addClass('px-4 py-2 bg-gray-50 border border-gray-100 text-sm font-medium text-gray-400 mx-1 rounded-xl cursor-not-allowed');
                        $('.dataTables_paginate').addClass('space-x-1');
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
                document.getElementById('deleteConfirmModal').classList.remove('hidden'); // Tampilkan modal
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
                const editButtons = document.querySelectorAll(".editUserBtn");
                const editForm = document.getElementById("editUserForm");

                editButtons.forEach(btn => {
                    btn.addEventListener("click", () => {
                        const user = JSON.parse(btn.getAttribute("data-user"));

                        document.getElementById("edit_user_id").value = user.user_id;
                        document.getElementById("edit_nama").value = user.nama;
                        document.getElementById("edit_email").value = user.email;
                        document.getElementById("edit_username").value = user.username;
                        document.getElementById("edit_level_id").value = user.level_id;

                        // Ganti action form secara dinamis
                        editForm.action = `/admin/user/${user.user_id}`;

                        // Tampilkan modal
                        document.getElementById("editUserModal").classList.remove("hidden");
                    });
                });

                // Tombol keluar modal
                document.querySelectorAll('[data-modal-hide="editUserModal"]').forEach(btn => {
                    btn.addEventListener("click", () => {
                        document.getElementById("editUserModal").classList.add("hidden");
                    });
                });
            });
        </script>


@endsection
