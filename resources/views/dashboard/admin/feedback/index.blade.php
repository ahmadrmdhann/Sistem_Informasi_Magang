@extends('layouts.dashboard')

@section('title')
    <title>Manajemen Form Fe                <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ $forms->sum('questions_count') }}</h3>
                <p class="text-sm text-gray-500">Total semua pertanyaan</p>
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16"></div>
            </div>

            <!-- Total Responses Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 relative overflow-hidden">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-chart-bar text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-xs font-semibold text-gray-400">Total Respons</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ $forms->sum('responses_count') }}</h3>
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
                        <i class="fas fa-comment-dots text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-white">Manajemen Form Feedback</h2>
                        <p class="text-white/90 text-lg">Kelola formulir umpan balik untuk evaluasi magang</p>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
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
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Statistik Feedback</h3>
                <p class="text-gray-600">Overview data formulir feedback dalam sistem</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Forms -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-clipboard-list text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $forms->count() }}</h4>
                            <p class="text-blue-500 text-xs">Form Feedback</p>
                        </div>
                    </div>
                </div>

                <!-- Active Forms -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-check-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Form</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $forms->where('is_active', true)->count() }}</h4>
                            <p class="text-green-500 text-xs">Aktif</p>
                        </div>
                    </div>
                </div>

                <!-- Total Questions -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-question-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $forms->sum('questions_count') }}</h4>
                            <p class="text-indigo-500 text-xs">Pertanyaan</p>
                        </div>
                    </div>
                </div>

                <!-- Total Responses -->
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-chart-bar text-white text-xl"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total</p>
                            <h4 class="font-bold text-2xl text-gray-800">{{ $forms->sum('responses_count') }}</h4>
                            <p class="text-purple-500 text-xs">Respons</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Section -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Form Feedback</h3>
                        <p class="text-gray-600">Kelola form umpan balik untuk evaluasi magang</p>
                    </div>
                    <button class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5 transform" id="createFormBtn">
                        <i class="fas fa-plus text-sm mr-2"></i>
                        <span>Tambah Form</span>
                    </button>
                </div>

                <!-- Table Controls -->
               

                <div class="overflow-x-auto">
                    <table id="feedbackTable" class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">No</th>
                                <th class="py-4 px-6 text-left font-semibold text-gray-700">Judul Form
                        </th>
                        <th class="py-4 px-6 text-left font-semibold text-gray-700">Deskripsi</th>
                        <th class="py-4 px-6 text-left font-semibold text-gray-700">Jumlah Pertanyaan</th>
                        <th class="py-4 px-6 text-left font-semibold text-gray-700">Jumlah Respons</th>
                        <th class="py-4 px-6 text-left font-semibold text-gray-700">Status</th>
                        <th class="py-4 px-6 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($forms as $index => $form)
                        <tr class="border-b border-gray-50 hover:bg-blue-50/50 transition-all duration-300">
                            <td class="py-4 px-6 text-gray-700">{{ $index + 1 }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-clipboard-list text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $form->title }}</div>
                                        <div class="text-sm text-gray-500">
                                            Dibuat: {{ $form->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="max-w-xs">
                                    <div class="font-medium text-gray-800">{{ $form->description ?: 'Tidak ada deskripsi' }}</div>
                                    <div class="text-sm text-gray-500">
                                        Diperbarui: {{ $form->updated_at->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-800 flex items-center">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                                        <i class="fas fa-question-circle text-blue-600 text-sm"></i>
                                    </div>
                                    {{ $form->questions_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-50 text-green-700">
                                    <i class="fas fa-reply mr-1.5"></i>
                                    {{ $form->responses_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <form action="{{ route('admin.feedback.toggle-status', $form->form_id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transition-all duration-200
                                            {{ $form->is_active 
                                                ? 'bg-green-50 text-green-700 hover:bg-green-100 hover:text-green-800' 
                                                : 'bg-red-50 text-red-700 hover:bg-red-100 hover:text-red-800' 
                                            }}">
                                        <i class="fas {{ $form->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1.5"></i>
                                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('admin.feedback.show', $form->form_id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 hover:text-blue-800 rounded-lg transition-all duration-200">
                                        <i class="fas fa-eye mr-1.5"></i>
                                        <span>Lihat</span>
                                    </a>
                                    <a href="{{ route('admin.feedback.edit', $form->form_id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 hover:text-yellow-800 rounded-lg transition-all duration-200">
                                        <i class="fas fa-edit mr-1.5"></i>
                                        <span>Edit</span>
                                    </a>
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 hover:bg-red-100 hover:text-red-800 rounded-lg transition-all duration-200 btn-delete"
                                        data-form-id="{{ $form->form_id }}" data-form-title="{{ $form->title }}">
                                        <i class="fas fa-trash mr-1.5"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada form feedback</p>
                                    <p class="text-sm">Klik tombol "Tambah Form Feedback" untuk membuat form pertama</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-clipboard-list text-2xl text-blue-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Form</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $forms->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Form Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $forms->where('is_active', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-comments text-2xl text-purple-500"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Respons</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $forms->sum('responses_count') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mt-6 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.feedback.responses') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-list mr-2"></i>Lihat Semua Respons
                </a>
                <a href="{{ route('admin.feedback.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Buat Form Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus form feedback "<span id="formTitle"></span>"?
                Semua data respons akan ikut terhapus.</p>
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelDeleteBtn"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Form Modal (AJAX) -->
    <div id="createFormModal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 bg-gray-900/70 p-4">
        <div
            class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto mx-auto my-auto flex items-center justify-center min-h-screen">
            <div class="w-full">
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900">Tambah Form Feedback Baru</h3>
                    <button type="button" id="closeCreateModal" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="createModalContent" class="p-6">
                    <!-- Create form content will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="hidden fixed inset-0 z-60 bg-gray-900/50">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg p-6 shadow-xl">
                <div class="flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                    <span class="text-gray-700">Memproses...</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        let feedbackTable;
        let questionIndex = 0;

        $(document).ready(function () {
            // Initialize DataTable
            feedbackTable = $('#feedbackTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "order": [[0, "asc"]],
                "columnDefs": [
                    { "orderable": false, "targets": [6] }
                ]
            });

            // CSRF Token setup for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Create Form Modal Events
            $('#createFormBtn').on('click', function () {
                openCreateModal();
            });

            // Delete confirmation
            $(document).on('click', '.btn-delete', function () {
                const formId = $(this).data('form-id');
                const formTitle = $(this).data('form-title');

                $('#formTitle').text(formTitle);
                $('#deleteForm').attr('action', `/admin/feedback/${formId}`);
                showModal('#deleteConfirmModal');
            });

            $('#cancelDeleteBtn').on('click', function () {
                hideModal('#deleteConfirmModal');
            });

            // Modal close events
            $('#closeCreateModal').on('click', function () {
                hideModal('#createFormModal');
            });

            // Close modals when clicking outside
            $('.fixed').on('click', function (e) {
                if (e.target === this) {
                    hideModal(this);
                }
            });

            // Handle delete form submission
            $('#deleteForm').on('submit', function (e) {
                e.preventDefault();
                const form = $(this);
                const url = form.attr('action');

                showLoading();

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function (response) {
                        hideLoading();
                        hideModal('#deleteConfirmModal');
                        showAlert('success', 'Form feedback berhasil dihapus.');
                        reloadTable();
                    },
                    error: function (xhr) {
                        hideLoading();
                        showAlert('error', 'Terjadi kesalahan saat menghapus form feedback.');
                    }
                });
            });
        });

        // Modal utility functions
        function showModal(modalId) {
            $(modalId).removeClass('hidden').show();
        }

        function hideModal(modalId) {
            $(modalId).addClass('hidden').hide();

            // Reset create form modal
            if (modalId === '#createFormModal') {
                $('#createModalContent').empty();
                questionIndex = 0;
            }
        }

        function showLoading() {
            $('#loadingOverlay').removeClass('hidden').show();
        }

        function hideLoading() {
            $('#loadingOverlay').addClass('hidden').hide();
        }

        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
            const alertHtml = `
            <div class="${alertClass} border-l-4 p-4 mb-4 rounded alert-message" role="alert">
                ${message}
            </div>
        `;

            // Remove existing alerts
            $('.alert-message').remove();

            // Add new alert at the top
            $('#mainContent').prepend(alertHtml);

            // Auto-hide after 5 seconds
            setTimeout(function () {
                $('.alert-message').fadeOut(function () {
                    $(this).remove();
                });
            }, 5000);
        }

        function reloadTable() {
            // Reload the page to refresh the table data and statistics
            window.location.reload();
        }

        // Open Create Modal
        function openCreateModal() {
            showLoading();

            // Load create form content
            const createFormHtml = `
            <form id="feedbackForm" class="space-y-6">
                <!-- Form Information -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="text-md font-medium text-gray-900 mb-4">Informasi Form</h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Form <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required>
                            <div class="text-red-500 text-sm mt-1 error-message" id="title-error"></div>
                        </div>

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                                Status Form
                            </label>
                            <select name="is_active" id="is_active"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Form
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Deskripsi singkat tentang tujuan form feedback ini"></textarea>
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Mulai
                            </label>
                            <input type="date" name="start_date" id="start_date"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Berakhir
                            </label>
                            <input type="date" name="end_date" id="end_date"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-medium text-gray-900">Pertanyaan Feedback</h4>
                        <button type="button" id="addQuestionBtn"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-colors text-sm">
                            <i class="fas fa-plus mr-1"></i>Tambah Pertanyaan
                        </button>
                    </div>

                    <div id="questionsContainer">
                        <!-- Questions will be added here dynamically -->
                    </div>

                    <div id="noQuestionsMessage" class="text-center py-6 text-gray-500">
                        <i class="fas fa-question-circle text-3xl text-gray-300 mb-3"></i>
                        <p class="font-medium">Belum ada pertanyaan</p>
                        <p class="text-sm">Klik "Tambah Pertanyaan" untuk menambahkan pertanyaan pertama</p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <button type="button" id="cancelFormBtn"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button type="submit" id="submitFormBtn"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-save mr-2"></i>Simpan Form
                    </button>
                </div>
            </form>
        `;

            $('#createModalContent').html(createFormHtml);
            hideLoading();
            showModal('#createFormModal');

            // Initialize form events
            initializeFormEvents();

            // Add first question by default
            addQuestion();
        }

        // Initialize Form Events
        function initializeFormEvents() {
            // Add question button
            $(document).off('click', '#addQuestionBtn').on('click', '#addQuestionBtn', function () {
                addQuestion();
            });

            // Cancel button
            $(document).off('click', '#cancelFormBtn').on('click', '#cancelFormBtn', function () {
                hideModal('#createFormModal');
            });

            // Form submission
            $(document).off('submit', '#feedbackForm').on('submit', '#feedbackForm', function (e) {
                e.preventDefault();
                submitForm();
            });

            // Question type change
            $(document).off('change', '.question-type').on('change', '.question-type', function () {
                const optionsContainer = $(this).closest('.question-item').find('.options-container');
                if ($(this).val() === 'multiple_choice') {
                    optionsContainer.show();
                } else {
                    optionsContainer.hide();
                }
            });

            // Remove question
            $(document).off('click', '.remove-question').on('click', '.remove-question', function () {
                $(this).closest('.question-item').remove();
                updateQuestionNumbers();
                toggleNoQuestionsMessage();
            });
        }

        // Add Question Function
        function addQuestion(existingQuestion = null) {
            const questionHtml = `
            <div class="question-item border border-gray-200 rounded-lg p-3 mb-3 bg-white">
                <div class="flex justify-between items-start mb-3">
                    <h5 class="text-sm font-medium text-gray-800">Pertanyaan <span class="question-number">${questionIndex + 1}</span></h5>
                    <button type="button" class="remove-question text-red-500 hover:text-red-700 text-sm">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Teks Pertanyaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="questions[${questionIndex}][question_text]"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                  rows="2" required placeholder="Masukkan pertanyaan feedback">${existingQuestion ? existingQuestion.question_text : ''}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Tipe Pertanyaan <span class="text-red-500">*</span>
                        </label>
                        <select name="questions[${questionIndex}][question_type]"
                                class="question-type w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                            <option value="">Pilih Tipe</option>
                            <option value="rating" ${existingQuestion && existingQuestion.question_type === 'rating' ? 'selected' : ''}>Rating (1-10)</option>
                            <option value="text" ${existingQuestion && existingQuestion.question_type === 'text' ? 'selected' : ''}>Teks Bebas</option>
                            <option value="multiple_choice" ${existingQuestion && existingQuestion.question_type === 'multiple_choice' ? 'selected' : ''}>Pilihan Ganda</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Wajib Diisi
                        </label>
                        <select name="questions[${questionIndex}][is_required]"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="1" ${existingQuestion && existingQuestion.is_required ? 'selected' : ''}>Ya</option>
                            <option value="0" ${existingQuestion && !existingQuestion.is_required ? 'selected' : ''}>Tidak</option>
                        </select>
                    </div>

                    <div class="options-container md:col-span-2" style="display: ${existingQuestion && existingQuestion.question_type === 'multiple_choice' ? 'block' : 'none'};">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Pilihan Jawaban (pisahkan dengan enter)
                        </label>
                        <textarea name="questions[${questionIndex}][options_text]"
                                  class="options-textarea w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                  rows="3" placeholder="Pilihan 1&#10;Pilihan 2&#10;Pilihan 3">${existingQuestion && existingQuestion.options ? existingQuestion.options.join('\n') : ''}</textarea>
                    </div>
                </div>
            </div>
        `;

            $('#questionsContainer').append(questionHtml);
            questionIndex++;

            updateQuestionNumbers();
            toggleNoQuestionsMessage();
        }

        function updateQuestionNumbers() {
            $('#questionsContainer .question-item').each(function (index) {
                $(this).find('.question-number').text(index + 1);

                // Update input names to maintain proper indexing
                $(this).find('input, select, textarea').each(function () {
                    const name = $(this).attr('name');
                    if (name && name.includes('[')) {
                        $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
                    }
                });
            });
        }

        function toggleNoQuestionsMessage() {
            const hasQuestions = $('#questionsContainer .question-item').length > 0;
            $('#noQuestionsMessage').toggle(!hasQuestions);
        }

        // Submit Form Function
        function submitForm() {
            const form = $('#feedbackForm');
            const formId = form.data('form-id');
            const isEdit = !!formId;

            // Clear previous errors
            $('.error-message').text('');
            $('.border-red-500').removeClass('border-red-500');

            // Validate questions
            const questions = $('#questionsContainer .question-item');
            if (questions.length === 0) {
                showAlert('error', 'Minimal harus ada satu pertanyaan dalam form feedback.');
                return;
            }

            // Prepare form data
            const formData = {
                title: $('#title').val(),
                description: $('#description').val(),
                is_active: $('#is_active').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                questions: []
            };

            // Collect questions data
            questions.each(function (index) {
                const questionItem = $(this);
                const questionType = questionItem.find('.question-type').val();
                const questionData = {
                    question_text: questionItem.find(`[name="questions[${index}][question_text]"]`).val(),
                    question_type: questionType,
                    is_required: questionItem.find(`[name="questions[${index}][is_required]"]`).val(),
                    options: null
                };

                if (questionType === 'multiple_choice') {
                    const optionsText = questionItem.find('.options-textarea').val();
                    if (optionsText.trim()) {
                        questionData.options = optionsText.split('\n')
                            .map(option => option.trim())
                            .filter(option => option !== '');
                    } else {
                        questionData.options = [];
                    }
                }

                formData.questions.push(questionData);
            });

            // Validate multiple choice questions have options
            const invalidQuestions = formData.questions.filter((q, index) =>
                q.question_type === 'multiple_choice' && (!q.options || q.options.length === 0)
            );

            if (invalidQuestions.length > 0) {
                showAlert('error', 'Pertanyaan pilihan ganda harus memiliki minimal satu pilihan jawaban.');
                return;
            }

            // Show loading
            showLoading();

            // Submit form
            const url = isEdit ? `/admin/feedback/${formId}` : '/admin/feedback';
            const method = isEdit ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                success: function (response) {
                    hideLoading();
                    hideModal('#createFormModal');
                    showAlert('success', isEdit ? 'Form feedback berhasil diperbarui.' : 'Form feedback berhasil dibuat.');
                    reloadTable();
                },
                error: function (xhr) {
                    hideLoading();

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function (field) {
                            const errorElement = $(`#${field}-error`);
                            const inputElement = $(`#${field}`);

                            if (errorElement.length) {
                                errorElement.text(errors[field][0]);
                                inputElement.addClass('border-red-500');
                            }
                        });

                        showAlert('error', 'Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.');
                    } else {
                        showAlert('error', 'Terjadi kesalahan saat menyimpan form feedback.');
                    }
                }
            });
        }
    </script>
</div> <!-- Close the mainContent div -->

    <!-- Information Cards Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Form Creation Guide -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-clipboard-list text-white text-xl"></i>
                    </div>
                    <h3 class="ml-4 text-lg font-bold text-white">Panduan Pembuatan Form</h3>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <p class="text-gray-600">Buat form dengan judul yang jelas dan deskriptif</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <p class="text-gray-600">Tambahkan pertanyaan yang relevan dengan tujuan evaluasi</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                        <p class="text-gray-600">Sesuaikan tipe pertanyaan dengan jenis respons yang diharapkan</p>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Form Types Info -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-purple-500 to-purple-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-list-alt text-white text-xl"></i>
                    </div>
                    <h3 class="ml-4 text-lg font-bold text-white">Tipe Pertanyaan</h3>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-paragraph text-purple-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-700">Text</p>
                            <p class="text-sm text-gray-500">Jawaban berupa teks singkat atau panjang</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-list text-purple-500 mt-1 mr-3"></i>
                        <div>
                            <p class="font-medium text-gray-700">Multiple Choice</p>
                            <p class="text-sm text-gray-500">Pilihan jawaban yang telah ditentukan</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Response Management -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-green-500 to-green-600">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <h3 class="ml-4 text-lg font-bold text-white">Pengelolaan Respons</h3>
                </div>
            </div>
            <div class="p-6">
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-calendar-check text-green-500 mt-1 mr-3"></i>
                        <p class="text-gray-600">Atur periode aktif form untuk mengontrol pengisian</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-shield-alt text-green-500 mt-1 mr-3"></i>
                        <p class="text-gray-600">Pantau status form dan jumlah respons yang masuk</p>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-download text-green-500 mt-1 mr-3"></i>
                        <p class="text-gray-600">Unduh dan analisis data respons yang terkumpul</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Feedback Information -->
    <div class="mt-8 bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Form Feedback</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6">
                <div class="flex items-center mb-3">
                    <i class="fas fa-clipboard-check text-blue-600 text-xl mr-3"></i>
                    <h4 class="font-semibold text-blue-800">Form Evaluasi</h4>
                </div>
                <p class="text-blue-700 text-sm">Form standar untuk mengevaluasi pengalaman dan pembelajaran selama magang.</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6">
                <div class="flex items-center mb-3">
                    <i class="fas fa-star text-purple-600 text-xl mr-3"></i>
                    <h4 class="font-semibold text-purple-800">Form Rating</h4>
                </div>
                <p class="text-purple-700 text-sm">Form penilaian untuk mengukur kepuasan dan performa selama program magang.</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6">
                <div class="flex items-center mb-3">
                    <i class="fas fa-comments text-green-600 text-xl mr-3"></i>
                    <h4 class="font-semibold text-green-800">Form Saran</h4>
                </div>
                <p class="text-green-700 text-sm">Form untuk memberikan masukan dan saran perbaikan program magang.</p>
            </div>
        </div>
    </div>
@endsection
