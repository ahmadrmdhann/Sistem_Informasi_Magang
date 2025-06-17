@extends('layouts.dashboard')

@section('title')
    <title>Manajemen Mitra</title>
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
                            <i class="fas fa-building text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Manajemen Mitra</h1>
                            <p class="text-white/80">Kelola data mitra dalam sistem</p>
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

            <!-- Partner Table -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Mitra</h3>
                            <p class="text-gray-600">Kelola data mitra sistem</p>
                        </div>
                        <button id="btnTambahPartner" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg flex items-center gap-2">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Mitra</span>
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="partnerTable" class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-blue-100">
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Nama</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Alamat</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Telepon</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent text-center">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($partners as $partner)
                                    <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $partner->nama }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $partner->alamat }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $partner->telepon }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $partner->email }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <button type="button" 
                                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200 editPartnerBtn"
                                                    data-partner='@json($partner)'>
                                                    <i class="fas fa-edit"></i>
                                                    <span>Edit</span>
                                                </button>
                                                <button type="button" 
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200 btn-delete" 
                                                    data-partner-id="{{ $partner->partner_id }}">
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
                                                    <i class="fas fa-building text-gray-400 text-2xl"></i>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-400 mb-1">Tidak ada data</h3>
                                                <p class="text-gray-400">Belum ada data mitra yang tersedia</p>
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
    <div id="createPartnerModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah Mitra</h3>
                <button type="button" id="btnCloseCreate" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>

            <form id="createPartnerForm" action="{{ route('partner.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="create_nama" class="block text-gray-700 mb-2">Nama Mitra</label>
                    <input type="text" name="nama" id="create_nama" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div id="create_nama_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="create_alamat" class="block text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="create_alamat" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                    <div id="create_alamat_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="create_telepon" class="block text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="telepon" id="create_telepon" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div id="create_telepon_error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                <div class="mb-4">
                    <label for="create_email" class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="create_email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <div id="create_email_error" class="text-red-500 text-sm mt-1 hidden"></div>
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
    <div id="editPartnerModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit Mitra</h3>
                <button type="button" data-modal-hide="editPartnerModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <form id="editPartnerForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit_nama" class="block text-gray-700 mb-2">Nama Mitra</label>
                    <input type="text" name="nama" id="edit_nama" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="edit_alamat" class="block text-gray-700 mb-2">Alamat</label>
                    <textarea name="alamat" id="edit_alamat" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit_telepon" class="block text-gray-700 mb-2">Telepon</label>
                    <input type="text" name="telepon" id="edit_telepon" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="edit_email" class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="editPartnerModal"
                        class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data mitra ini?</p>
            <div class="flex justify-end">
                <button type="button" id="cancelDeleteBtn"
                    class="mr-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200">Batal</button>
                <form id="deletePartnerForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            const table = $('#partnerTable').DataTable({
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
            $('#btnTambahPartner').on('click', function() {
                $('#createPartnerModal').removeClass('hidden');
                $('#createPartnerForm')[0].reset();
                $('.text-red-500').addClass('hidden');
            });

            $('#btnCloseCreate, #btnCancelCreate').on('click', function() {
                $('#createPartnerModal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#createPartnerModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // === EDIT MODAL HANDLERS ===
            $(document).on('click', '.editPartnerBtn', function() {
                const partner = JSON.parse($(this).attr("data-partner"));
                $('#edit_nama').val(partner.nama);
                $('#edit_alamat').val(partner.alamat);
                $('#edit_telepon').val(partner.telepon);
                $('#edit_email').val(partner.email);
                $('#editPartnerForm').attr('action', `/admin/partner/${partner.partner_id}`);
                $('.text-red-500').addClass('hidden');
                $('#editPartnerModal').removeClass('hidden');
            });

            $(document).on('click', '[data-modal-hide="editPartnerModal"]', function() {
                $('#editPartnerModal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#editPartnerModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // === DELETE MODAL HANDLERS ===
            $(document).on('click', '.btn-delete', function() {
                const partnerId = $(this).data('partner-id');
                $('#deletePartnerForm').attr('action', `/admin/partner/${partnerId}`);
                $('#deleteConfirmModal').removeClass('hidden');
            });

            $('#cancelDeleteBtn').on('click', function() {
                $('#deleteConfirmModal').addClass('hidden');
            });

            // Close modal when clicking outside
            $('#deleteConfirmModal').on('click', function(e) {
                if (e.target === this) {
                    $(this).addClass('hidden');
                }
            });

            // === FORM VALIDATION ===
            $('#createPartnerForm').on('submit', function(e) {
                let isValid = true;
                $('.text-red-500').addClass('hidden');

                // Validate nama
                if ($('#create_nama').val().trim() === '') {
                    $('#create_nama_error').text('Nama mitra tidak boleh kosong').removeClass('hidden');
                    isValid = false;
                }

                // Validate alamat
                if ($('#create_alamat').val().trim() === '') {
                    $('#create_alamat_error').text('Alamat tidak boleh kosong').removeClass('hidden');
                    isValid = false;
                }

                // Validate telepon
                if ($('#create_telepon').val().trim() === '') {
                    $('#create_telepon_error').text('Telepon tidak boleh kosong').removeClass('hidden');
                    isValid = false;
                }

                // Validate email
                const email = $('#create_email').val().trim();
                if (email === '') {
                    $('#create_email_error').text('Email tidak boleh kosong').removeClass('hidden');
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    $('#create_email_error').text('Format email tidak valid').removeClass('hidden');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    return false;
                }
            });

            // Clear errors on input change
            $('#create_nama, #create_alamat, #create_telepon, #create_email').on('input', function() {
                $(this).siblings('.text-red-500').addClass('hidden');
            });
        });
    </script>
@endsection
