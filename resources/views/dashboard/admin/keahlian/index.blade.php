@extends('layouts.dashboard')

@section('title')
    <title>Manajemen Keahlian</title>
@endsection

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
                        <i class="fas fa-cogs text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Manajemen Keahlian</h1>
                        <p class="text-white/80">Kelola daftar keahlian dalam sistem</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-2xl mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-2xl mr-4"></i>
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-gradient-to-r from-red-400 to-red-500 text-white p-6 rounded-2xl mb-6 shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-2xl mr-4"></i>
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Keahlian Table -->
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Keahlian</h3>
                        <p class="text-gray-600">Kelola data keahlian sistem</p>
                    </div>
                    <button id="btnTambahKeahlian" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg flex items-center gap-2">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Keahlian</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table id="keahlianTable" class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-blue-100">
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Keahlian</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent text-center w-40">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($keahlians as $keahlian)
                                <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $keahlian->nama }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <button type="button" 
                                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200 btn-edit"
                                                data-keahlian-id="{{ $keahlian->keahlian_id }}"
                                                data-keahlian-nama="{{ $keahlian->nama }}">
                                                <i class="fas fa-edit"></i>
                                                <span>Edit</span>
                                            </button>
                                            <button type="button"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200 btn-delete"
                                                data-keahlian-id="{{ $keahlian->keahlian_id }}"
                                                data-keahlian-nama="{{ $keahlian->nama }}">
                                                <i class="fas fa-trash"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-cogs text-gray-400 text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-400 mb-1">Tidak ada data</h3>
                                            <p class="text-gray-400">Belum ada data keahlian yang tersedia</p>
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

<!-- Create Modal -->
<div id="createKeahlianModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700">Tambah Keahlian</h3>
            <button type="button" id="btnCloseCreate" class="text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
        </div>

        <form id="createKeahlianForm" action="{{ route('keahlian.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="create_nama" class="block text-gray-700 mb-2">Nama Keahlian</label>
                <input type="text" name="nama" id="create_nama" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <div id="create_error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
            <div class="flex justify-end">
                <button type="button" id="btnCancelCreate" class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    <i class="fas fa-save mr-1"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editKeahlianModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-700">Edit Keahlian</h3>
            <button type="button" id="btnCloseEdit" class="text-gray-500 hover:text-gray-700 text-2xl">
                &times;
            </button>
        </div>

        <form id="editKeahlianForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="edit_nama" class="block text-gray-700 mb-2">Nama Keahlian</label>
                <input type="text" name="nama" id="edit_nama" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                <div id="edit_error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
            <div class="flex justify-end">
                <button type="button" id="btnCancelEdit" class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    <i class="fas fa-save mr-1"></i>
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Konfirmasi Hapus</h3>
            <p class="text-gray-600">Apakah Anda yakin ingin menghapus keahlian "<span id="deleteKeahlianName" class="font-semibold"></span>"?</p>
        </div>
        <div class="flex justify-center space-x-3">
            <button type="button" id="btnCancelDelete" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                Batal
            </button>
            <form id="deleteKeahlianForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-trash mr-1"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable
    const table = $('#keahlianTable').DataTable({
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
                "targets": [2],
                "orderable": false
            }
        ],
        "order": [[0, "asc"]],
        "drawCallback": function(settings) {
            $('.dataTables_paginate .paginate_button').removeClass().addClass('px-4 py-2 bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 mx-1 rounded-xl shadow-sm');
            $('.dataTables_paginate .paginate_button.current').removeClass().addClass('px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 text-sm font-medium text-white mx-1 rounded-xl shadow-md');
            $('.dataTables_paginate .paginate_button.disabled').removeClass().addClass('px-4 py-2 bg-gray-50 border border-gray-100 text-sm font-medium text-gray-400 mx-1 rounded-xl cursor-not-allowed');
            $('.dataTables_paginate').addClass('space-x-1');
        }
    });

    // === CREATE MODAL HANDLERS ===
    $('#btnTambahKeahlian').on('click', function() {
        $('#createKeahlianModal').removeClass('hidden');
        $('#create_nama').val('');
        $('#create_error').addClass('hidden');
    });

    $('#btnCloseCreate, #btnCancelCreate').on('click', function() {
        $('#createKeahlianModal').addClass('hidden');
    });

    // Close modal when clicking outside
    $('#createKeahlianModal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });

    // === EDIT MODAL HANDLERS ===
    $(document).on('click', '.btn-edit', function() {
        const keahlianId = $(this).data('keahlian-id');
        const keahlianNama = $(this).data('keahlian-nama');
        
        $('#edit_nama').val(keahlianNama);
        $('#editKeahlianForm').attr('action', `/admin/keahlian/${keahlianId}`);
        $('#edit_error').addClass('hidden');
        $('#editKeahlianModal').removeClass('hidden');
    });

    $('#btnCloseEdit, #btnCancelEdit').on('click', function() {
        $('#editKeahlianModal').addClass('hidden');
    });

    // Close modal when clicking outside
    $('#editKeahlianModal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });

    // === DELETE MODAL HANDLERS ===
    $(document).on('click', '.btn-delete', function() {
        const keahlianId = $(this).data('keahlian-id');
        const keahlianNama = $(this).data('keahlian-nama');
        
        $('#deleteKeahlianName').text(keahlianNama);
        $('#deleteKeahlianForm').attr('action', `/admin/keahlian/${keahlianId}`);
        $('#deleteConfirmModal').removeClass('hidden');
    });

    $('#btnCancelDelete').on('click', function() {
        $('#deleteConfirmModal').addClass('hidden');
    });

    // Close modal when clicking outside
    $('#deleteConfirmModal').on('click', function(e) {
        if (e.target === this) {
            $(this).addClass('hidden');
        }
    });

    // === FORM VALIDATION ===
    $('#createKeahlianForm').on('submit', function(e) {
        const nama = $('#create_nama').val().trim();
        if (nama === '') {
            e.preventDefault();
            $('#create_error').text('Nama keahlian tidak boleh kosong').removeClass('hidden');
            return false;
        }
    });

    $('#editKeahlianForm').on('submit', function(e) {
        const nama = $('#edit_nama').val().trim();
        if (nama === '') {
            e.preventDefault();
            $('#edit_error').text('Nama keahlian tidak boleh kosong').removeClass('hidden');
            return false;
        }
    });

    // Clear error on input
    $('#create_nama').on('input', function() {
        $('#create_error').addClass('hidden');
    });

    $('#edit_nama').on('input', function() {
        $('#edit_error').addClass('hidden');
    });
});
</script>
@endsection
