@extends('layouts.dashboard')

@section('title')
    <title>Manajemen Form Feedback</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Manajemen Form Feedback</h2>
            <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow" id="createFormBtn">
                <i class="fas fa-plus mr-2"></i>Tambah Form Feedback
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="feedbackTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Judul Form
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Deskripsi
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Jumlah Pertanyaan
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Jumlah Respons
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($forms as $index => $form)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                <div class="font-medium">{{ $form->title }}</div>
                                <div class="text-sm text-gray-500">
                                    Dibuat: {{ $form->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                <div class="max-w-xs truncate">
                                    {{ $form->description ?: 'Tidak ada deskripsi' }}
                                </div>
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $form->questions_count }} pertanyaan
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200 text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $form->responses_count }} respons
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                <form action="{{ route('admin.feedback.toggle-status', $form->form_id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors
                                                       {{ $form->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <i class="fas {{ $form->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.feedback.show', $form->form_id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                    <a href="{{ route('admin.feedback.edit', $form->form_id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <button type="button"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition-colors duration-150 btn-delete"
                                        data-form-id="{{ $form->form_id }}" data-form-title="{{ $form->title }}">
                                        <i class="fas fa-trash mr-1"></i>Hapus
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
@endsection
