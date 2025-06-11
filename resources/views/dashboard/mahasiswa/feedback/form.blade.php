@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('mahasiswa.feedback.index') }}" 
               class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $form->title }}</h1>
                <p class="text-gray-600 mt-1">Isi feedback untuk pengalaman magang Anda</p>
            </div>
        </div>
    </div>

    <!-- Test Mode Banner -->
    @if($testMode)
        <div class="mb-6 p-4 bg-orange-100 border-l-4 border-orange-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-flask text-orange-500 mr-3"></i>
                <div>
                    <h3 class="text-orange-800 font-semibold">MODE TESTING AKTIF</h3>
                    <p class="text-orange-700 text-sm">Feedback yang Anda kirim akan ditandai sebagai data testing dan dapat dihapus kapan saja.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Form</h2>
        
        @if($form->description)
            <div class="mb-4">
                <p class="text-gray-700">{{ $form->description }}</p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                <i class="fas fa-question-circle text-blue-500 mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Pertanyaan</p>
                    <p class="font-medium">{{ $form->questions->count() }} pertanyaan</p>
                </div>
            </div>
            <div class="flex items-center p-3 bg-green-50 rounded-lg">
                <i class="fas fa-star text-green-500 mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Pertanyaan Rating</p>
                    <p class="font-medium">{{ $form->questions->where('question_type', 'rating')->count() }} pertanyaan</p>
                </div>
            </div>
            @if($form->end_date)
                <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                    <i class="fas fa-calendar text-yellow-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Batas Waktu</p>
                        <p class="font-medium">{{ $form->end_date->format('d/m/Y') }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Feedback Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Form Feedback</h2>
            <p class="text-gray-600 text-sm mt-1">Semua pertanyaan dengan tanda <span class="text-red-500">*</span> wajib diisi</p>
        </div>

        <form id="feedbackForm" class="p-6">
            @csrf
            
            <!-- Select Internship Experience -->
            <div class="mb-6">
                <label for="pengajuan_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Pengalaman Magang <span class="text-red-500">*</span>
                </label>
                <select name="pengajuan_id" id="pengajuan_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        required>
                    <option value="">Pilih pengalaman magang yang akan dievaluasi</option>
                    @foreach($completedInternships as $internship)
                        <option value="{{ $internship->id }}">
                            {{ $internship->lowongan->judul }} - {{ $internship->lowongan->partner->nama }}
                        </option>
                    @endforeach
                </select>
                <div class="text-red-500 text-sm mt-1 error-message" id="pengajuan_id-error"></div>
            </div>

            <!-- Questions -->
            <div class="space-y-6">
                @foreach($form->questions as $index => $question)
                    <div class="question-item border border-gray-200 rounded-lg p-4">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="text-blue-600 font-semibold">Pertanyaan {{ $index + 1 }}</span>
                                @if($question->is_required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <p class="text-gray-800 mb-3">{{ $question->question_text }}</p>
                        </div>

                        @if($question->question_type === 'rating')
                            <!-- Rating Question (1-10 buttons) -->
                            <div class="rating-container">
                                <p class="text-sm text-gray-600 mb-3">Pilih rating dari 1 (sangat buruk) hingga 10 (sangat baik):</p>
                                <div class="flex flex-wrap gap-2">
                                    @for($i = 1; $i <= 10; $i++)
                                        <label class="rating-option">
                                            <input type="radio" 
                                                   name="answers[{{ $question->question_id }}]" 
                                                   value="{{ $i }}" 
                                                   class="hidden rating-input"
                                                   {{ $question->is_required ? 'required' : '' }}>
                                            <span class="rating-button inline-flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                                                {{ $i }}
                                            </span>
                                        </label>
                                    @endfor
                                </div>
                            </div>
                        @elseif($question->question_type === 'text')
                            <!-- Text Question -->
                            <textarea name="answers[{{ $question->question_id }}]" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                      rows="4" 
                                      placeholder="Tulis jawaban Anda di sini..."
                                      {{ $question->is_required ? 'required' : '' }}></textarea>
                        @elseif($question->question_type === 'multiple_choice')
                            <!-- Multiple Choice Question -->
                            <div class="space-y-2">
                                @foreach($question->options as $optionIndex => $option)
                                    <label class="flex items-center">
                                        <input type="radio" 
                                               name="answers[{{ $question->question_id }}]" 
                                               value="{{ $option }}" 
                                               class="mr-3 text-blue-600 focus:ring-blue-500"
                                               {{ $question->is_required ? 'required' : '' }}>
                                        <span class="text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <div class="text-red-500 text-sm mt-1 error-message" id="answers_{{ $question->question_id }}-error"></div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <a href="{{ route('mahasiswa.feedback.index') }}" 
                       class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    
                    <button type="submit" id="submitBtn"
                            class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Feedback
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 z-50 bg-gray-900/50">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg p-6 shadow-xl">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <span class="text-gray-700">Mengirim feedback...</span>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input:checked + .rating-button {
    background-color: #3B82F6;
    border-color: #3B82F6;
    color: white;
}

.rating-button:hover {
    transform: scale(1.05);
}

.error-message:not(:empty) {
    display: block;
}

.error-message:empty {
    display: none;
}

.border-red-500 {
    border-color: #EF4444 !important;
}
</style>

<script>
$(document).ready(function() {
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form submission
    $('#feedbackForm').on('submit', function(e) {
        e.preventDefault();

        // Clear previous errors
        $('.error-message').text('');
        $('.border-red-500').removeClass('border-red-500');

        // Show loading
        showLoading();

        // Prepare form data
        const formData = {
            pengajuan_id: $('#pengajuan_id').val(),
            answers: {}
        };

        // Collect answers
        $('[name^="answers["]').each(function() {
            const name = $(this).attr('name');
            const questionId = name.match(/answers\[(\d+)\]/)[1];

            if ($(this).is(':radio')) {
                if ($(this).is(':checked')) {
                    formData.answers[questionId] = $(this).val();
                }
            } else {
                formData.answers[questionId] = $(this).val();
            }
        });

        // Submit via AJAX
        $.ajax({
            url: '{{ route("mahasiswa.feedback.store", $form->form_id) }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                hideLoading();

                if (response.success) {
                    // Show success message and redirect
                    showAlert('success', response.message);

                    setTimeout(function() {
                        window.location.href = '{{ route("mahasiswa.feedback.index") }}';
                    }, 2000);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                hideLoading();

                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;

                    // Show field-specific errors
                    for (const field in errors) {
                        const errorElement = $('#' + field.replace(/\./g, '_') + '-error');
                        errorElement.text(errors[field][0]);

                        // Highlight field
                        const fieldElement = $('[name="' + field + '"]');
                        fieldElement.addClass('border-red-500');
                    }

                    showAlert('error', xhr.responseJSON.message || 'Terjadi kesalahan validasi.');
                } else {
                    showAlert('error', 'Terjadi kesalahan saat mengirim feedback. Silakan coba lagi.');
                }
            }
        });
    });

    // Clear error when field is changed
    $('input, select, textarea').on('change input', function() {
        const name = $(this).attr('name');
        if (name) {
            const errorElement = $('#' + name.replace(/\./g, '_') + '-error');
            errorElement.text('');
            $(this).removeClass('border-red-500');
        }
    });
});

function showLoading() {
    $('#loadingOverlay').removeClass('hidden');
    $('#submitBtn').prop('disabled', true);
}

function hideLoading() {
    $('#loadingOverlay').addClass('hidden');
    $('#submitBtn').prop('disabled', false);
}

function showAlert(type, message) {
    const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

    const alertHtml = `
        <div class="${alertClass} border-l-4 p-4 mb-4 rounded alert-message" role="alert">
            <div class="flex items-center">
                <i class="fas ${iconClass} mr-2"></i>
                ${message}
            </div>
        </div>
    `;

    // Remove existing alerts
    $('.alert-message').remove();

    // Add new alert at the top
    $('#mainContent').prepend(alertHtml);

    // Auto-hide after 5 seconds
    setTimeout(function() {
        $('.alert-message').fadeOut(function() {
            $(this).remove();
        });
    }, 5000);

    // Scroll to top to show alert
    $('html, body').animate({ scrollTop: 0 }, 300);
}
</script>
@endsection
