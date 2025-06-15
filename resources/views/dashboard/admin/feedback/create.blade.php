@extends('layouts.dashboard')

@section('title')
    <title>Buat Form Feedback</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold">Buat Form Feedback Baru</h2>
                <p class="text-gray-600">Buat formulir feedback untuk evaluasi mahasiswa pasca magang</p>
            </div>
            <a href="{{ route('admin.feedback.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <div class="font-medium">Terdapat kesalahan:</div>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.feedback.store') }}" method="POST" id="feedbackForm">
            @csrf

            <!-- Form Information -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Form</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Form <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                            value="{{ old('title') }}" required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                            Status Form
                        </label>
                        <select name="is_active" id="is_active"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Form
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                            placeholder="Deskripsi singkat tentang tujuan form feedback ini">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror"
                            value="{{ old('start_date') }}">
                        @error('start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Berakhir
                        </label>
                        <input type="date" name="end_date" id="end_date"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date') border-red-500 @enderror"
                            value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Pertanyaan Feedback</h3>
                    <button type="button" id="addQuestionBtn"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Tambah Pertanyaan
                    </button>
                </div>

                <div id="questionsContainer">
                    <!-- Questions will be added here dynamically -->
                </div>

                <div id="noQuestionsMessage" class="text-center py-8 text-gray-500">
                    <i class="fas fa-question-circle text-4xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">Belum ada pertanyaan</p>
                    <p class="text-sm">Klik "Tambah Pertanyaan" untuk menambahkan pertanyaan pertama</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.feedback.index') }}"
                    class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-medium">
                    <i class="fas fa-save mr-2"></i>Simpan Form
                </button>
            </div>
        </form>
    </div>

    <!-- Question Template -->
    <template id="questionTemplate">
        <div class="question-item border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-md font-medium text-gray-800">Pertanyaan <span class="question-number"></span></h4>
                <button type="button" class="remove-question text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Teks Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="questions[INDEX][question_text]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="2" required placeholder="Masukkan pertanyaan feedback"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <select name="questions[INDEX][question_type]"
                        class="question-type w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Pilih Tipe</option>
                        <option value="rating">Rating (1-10)</option>
                        <option value="text">Teks Bebas</option>
                        <option value="multiple_choice">Pilihan Ganda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Wajib Diisi
                    </label>
                    <select name="questions[INDEX][is_required]"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                    </select>
                </div>

                <div class="options-container md:col-span-2" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilihan Jawaban (pisahkan dengan enter)
                    </label>
                    <textarea name="questions[INDEX][options_text]"
                        class="options-textarea w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        rows="3" placeholder="Pilihan 1&#10;Pilihan 2&#10;Pilihan 3"></textarea>
                </div>
            </div>
        </div>
    </template>

    <script>
        let questionIndex = 0;

        document.addEventListener('DOMContentLoaded', function () {
            const addQuestionBtn = document.getElementById('addQuestionBtn');
            const questionsContainer = document.getElementById('questionsContainer');
            const noQuestionsMessage = document.getElementById('noQuestionsMessage');
            const questionTemplate = document.getElementById('questionTemplate');

            addQuestionBtn.addEventListener('click', function () {
                addQuestion();
            });

            function addQuestion() {
                const template = questionTemplate.content.cloneNode(true);
                const questionItem = template.querySelector('.question-item');

                // Replace INDEX with actual index
                questionItem.innerHTML = questionItem.innerHTML.replace(/INDEX/g, questionIndex);

                // Update question number
                questionItem.querySelector('.question-number').textContent = questionIndex + 1;

                // Add event listeners
                const removeBtn = questionItem.querySelector('.remove-question');
                const questionTypeSelect = questionItem.querySelector('.question-type');

                removeBtn.addEventListener('click', function () {
                    questionItem.remove();
                    updateQuestionNumbers();
                    toggleNoQuestionsMessage();
                });

                questionTypeSelect.addEventListener('change', function () {
                    const optionsContainer = questionItem.querySelector('.options-container');
                    if (this.value === 'multiple_choice') {
                        optionsContainer.style.display = 'block';
                    } else {
                        optionsContainer.style.display = 'none';
                    }
                });

                questionsContainer.appendChild(questionItem);
                questionIndex++;

                updateQuestionNumbers();
                toggleNoQuestionsMessage();
            }

            function updateQuestionNumbers() {
                const questions = questionsContainer.querySelectorAll('.question-item');
                questions.forEach((question, index) => {
                    question.querySelector('.question-number').textContent = index + 1;
                });
            }

            function toggleNoQuestionsMessage() {
                const hasQuestions = questionsContainer.children.length > 0;
                noQuestionsMessage.style.display = hasQuestions ? 'none' : 'block';
            }

            // Form submission handler
            document.getElementById('feedbackForm').addEventListener('submit', function (e) {
                const questions = questionsContainer.querySelectorAll('.question-item');
                if (questions.length === 0) {
                    e.preventDefault();
                    alert('Minimal harus ada satu pertanyaan dalam form feedback.');
                    return;
                }

                // Process options for multiple choice questions
                questions.forEach((question, index) => {
                    const questionType = question.querySelector('.question-type').value;
                    if (questionType === 'multiple_choice') {
                        const optionsTextarea = question.querySelector('.options-textarea');
                        const optionsText = optionsTextarea.value;
                        const options = optionsText.split('\n').filter(option => option.trim() !== '');

                        // Remove the textarea name to avoid sending both
                        optionsTextarea.removeAttribute('name');

                        // Create hidden inputs for each option
                        options.forEach((option, optionIndex) => {
                            const hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = `questions[${index}][options][${optionIndex}]`;
                            hiddenInput.value = option.trim();
                            question.appendChild(hiddenInput);
                        });
                    }
                });
            });

            // Add first question by default
            addQuestion();
        });
    </script>
@endsection
