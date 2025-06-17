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
                            <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Manajemen Dosen</h1>
                            <p class="text-white/80">Kelola data dosen dalam sistem</p>
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

            <!-- Dosen Table -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Dosen</h3>
                            <p class="text-gray-600">Kelola data dosen sistem</p>
                        </div>
                        <button id="btnTambahDosen" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg flex items-center gap-2">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Dosen</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="dosenTable" class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-blue-100">
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama Dosen</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">NIDN</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Bidang Keahlian</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent text-center">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($dataDosen as $dosen)
                                    <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $dosen->user->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $dosen->nidn }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $dosen->user->email ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $dosen->bidang->nama ?? '-' }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <button type="button" 
                                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200 btn-edit"
                                                    data-dosen-id="{{ $dosen->dosen_id }}"
                                                    data-user-id="{{ $dosen->user_id }}"
                                                    data-nidn="{{ $dosen->nidn }}"
                                                    data-bidang-minat="{{ $dosen->bidang_minat }}">
                                                    <i class="fas fa-edit"></i>
                                                    <span>Edit</span>
                                                </button>
                                                <button type="button"
                                                    class="btn-delete bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200"
                                                    data-dosen-id="{{ $dosen->dosen_id }}"
                                                    data-dosen-nama="{{ $dosen->user->nama ?? 'Dosen' }}">
                                                    <i class="fas fa-trash"></i>
                                                    <span>Hapus</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-chalkboard-teacher text-gray-400 text-2xl"></i>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-400 mb-1">Tidak ada data</h3>
                                                <p class="text-gray-400">Belum ada data dosen yang tersedia</p>
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
    <div id="createDosenModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah Dosen</h3>
                <button type="button" id="btnCloseCreate" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>

            <form id="createDosenForm" action="{{ route('admin.dosen.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="create_user_id" class="block text-gray-700 mb-2">Pilih User</label>
                    <select name="user_id" id="create_user_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <div id="create_user_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="create_nidn" class="block text-gray-700 mb-2">NIDN</label>
                    <input type="text" name="nidn" id="create_nidn" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div id="create_nidn_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="create_bidang_minat" class="block text-gray-700 mb-2">Bidang Keahlian</label>
                    <select name="bidang_minat" id="create_bidang_minat" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Bidang Keahlian --</option>
                        @foreach ($bidangKeahlian as $keahlian)
                            <option value="{{ $keahlian->keahlian_id }}">{{ $keahlian->nama }}</option>
                        @endforeach
                    </select>
                    <div id="create_bidang_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="btnCancelCreate"
                        class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-save mr-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editDosenModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit Dosen</h3>
                <button type="button" id="btnCloseEdit" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>
            <form id="editDosenForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_user_id" class="block text-gray-700 mb-2">User</label>
                    <select name="user_id" id="edit_user_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <div id="edit_user_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="edit_nidn" class="block text-gray-700 mb-2">NIDN</label>
                    <input type="text" name="nidn" id="edit_nidn" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div id="edit_nidn_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="edit_bidang_minat" class="block text-gray-700 mb-2">Bidang Keahlian</label>
                    <select name="bidang_minat" id="edit_bidang_minat" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">-- Pilih Bidang Keahlian --</option>
                        @foreach ($bidangKeahlian as $keahlian)
                            <option value="{{ $keahlian->keahlian_id }}">{{ $keahlian->nama }}</option>
                        @endforeach
                    </select>
                    <div id="edit_bidang_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="btnCancelEdit"
                        class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">
                        <i class="fas fa-save mr-1"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div id="deleteConfirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus dosen "<span id="deleteDosenName" class="font-semibold"></span>"?</p>
            </div>
            <div class="flex justify-center space-x-3">
                <button type="button" id="btnCancelDelete"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">Batal</button>
                <form id="deleteDosenForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                        <i class="fas fa-trash mr-1"></i>Hapus
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
            const table = $('#dosenTable').DataTable({
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
                        "orderable": false
                    },
                    {
                        "targets": [5],
                        "orderable": false
                    }
                ],
                "order": [[1, "asc"]],
                "drawCallback": function(settings) {
                    $('.dataTables_paginate .paginate_button').removeClass().addClass('px-4 py-2 bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 mx-1 rounded-xl shadow-sm');
                    $('.dataTables_paginate .paginate_button.current').removeClass().addClass('px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 text-sm font-medium text-white mx-1 rounded-xl shadow-md');
                    $('.dataTables_paginate .paginate_button.disabled').removeClass().addClass('px-4 py-2 bg-gray-50 border border-gray-100 text-sm font-medium text-gray-400 mx-1 rounded-xl cursor-not-allowed');
                    $('.dataTables_paginate').addClass('space-x-1');
                }
            });

            // === CREATE MODAL HANDLERS ===
            $('#btnTambahDosen').on('click', function() {
                $('#createDosenModal').removeClass('hidden');
                $('#createDosenForm')[0].reset();
                $('.text-red-500').addClass('hidden');
            });

            $('#btnCloseCreate, #btnCancelCreate').on('click', function() {
                $('#createDosenModal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#createDosenModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // === EDIT MODAL HANDLERS ===
            $(document).on('click', '.btn-edit', function() {
                const dosenId = $(this).data('dosen-id');
                const userId = $(this).data('user-id');
                const nidn = $(this).data('nidn');
                const bidangMinat = $(this).data('bidang-minat');
                
                $('#edit_user_id').val(userId);
                $('#edit_nidn').val(nidn);
                $('#edit_bidang_minat').val(bidangMinat);
                $('#editDosenForm').attr('action', `/admin/dosen/${dosenId}`);
                $('.text-red-500').addClass('hidden');
                $('#editDosenModal').removeClass('hidden');
            });

            $('#btnCloseEdit, #btnCancelEdit').on('click', function() {
                $('#editDosenModal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#editDosenModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // === DELETE MODAL HANDLERS ===
            $(document).on('click', '.btn-delete', function() {
                const dosenId = $(this).data('dosen-id');
                const dosenNama = $(this).data('dosen-nama');
                
                $('#deleteDosenName').text(dosenNama);
                $('#deleteDosenForm').attr('action', `/admin/dosen/${dosenId}`);
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
            $('#createDosenForm').on('submit', function(e) {
                let isValid = true;
                $('.text-red-500').addClass('hidden');

                if ($('#create_user_id').val() === '') {
                    $('#create_user_error').text('User harus dipilih').removeClass('hidden');
                    isValid = false;
                }

                if ($('#create_nidn').val().trim() === '') {
                    $('#create_nidn_error').text('NIDN tidak boleh kosong').removeClass('hidden');
                    isValid = false;
                }

                if ($('#create_bidang_minat').val() === '') {
                    $('#create_bidang_error').text('Bidang keahlian harus dipilih').removeClass('hidden');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });

            $('#editDosenForm').on('submit', function(e) {
                let isValid = true;
                $('.text-red-500').addClass('hidden');

                if ($('#edit_user_id').val() === '') {
                    $('#edit_user_error').text('User harus dipilih').removeClass('hidden');
                    isValid = false;
                }

                if ($('#edit_nidn').val().trim() === '') {
                    $('#edit_nidn_error').text('NIDN tidak boleh kosong').removeClass('hidden');
                    isValid = false;
                }

                if ($('#edit_bidang_minat').val() === '') {
                    $('#edit_bidang_error').text('Bidang keahlian harus dipilih').removeClass('hidden');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });

            // Clear errors on input change
            $('#create_user_id, #create_nidn, #create_bidang_minat').on('change input', function() {
                $(this).siblings('.text-red-500').addClass('hidden');
            });

            $('#edit_user_id, #edit_nidn, #edit_bidang_minat').on('change input', function() {
                $(this).siblings('.text-red-500').addClass('hidden');
            });
        });
    </script>
@endsection
