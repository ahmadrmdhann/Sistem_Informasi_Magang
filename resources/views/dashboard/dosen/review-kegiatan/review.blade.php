@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('dosen.review-kegiatan.show', $activity->activity_id) }}" 
               class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Review Kegiatan Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Berikan penilaian dan feedback untuk aktivitas mahasiswa</p>
            </div>
        </div>
    </div>

    <!-- Activity Summary -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Kegiatan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Mahasiswa:</p>
                    <p class="font-medium text-gray-900">{{ $activity->mahasiswa->user->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Perusahaan:</p>
                    <p class="font-medium text-gray-900">{{ $activity->pengajuan->lowongan->partner->nama }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tanggal Kegiatan:</p>
                    <p class="font-medium text-gray-900">{{ $activity->activity_date->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Waktu:</p>
                    <p class="font-medium text-gray-900">
                        @if($activity->start_time && $activity->end_time)
                            {{ $activity->start_time->format('H:i') }} - {{ $activity->end_time->format('H:i') }} ({{ $activity->duration }})
                        @else
                            Tidak ditentukan
                        @endif
                    </p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $activity->activity_title }}</h3>
            <p class="text-gray-700 leading-relaxed">{{ Str::limit($activity->activity_description, 200) }}</p>
            @if(strlen($activity->activity_description) > 200)
                <button onclick="toggleFullDescription()" id="toggleBtn" class="text-blue-600 hover:text-blue-800 text-sm mt-2">
                    Lihat selengkapnya
                </button>
                <div id="fullDescription" class="hidden mt-3">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $activity->activity_description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Review Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Form Review</h2>
            <p class="text-gray-600 text-sm mt-1">Berikan penilaian dan feedback untuk kegiatan ini</p>
        </div>

        <form id="reviewForm" class="p-6">
            @csrf
            
            <!-- Review Status -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Status Review <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="relative">
                        <input type="radio" name="review_status" value="approved" 
                               class="sr-only peer" required>
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-green-300 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Disetujui</p>
                                    <p class="text-sm text-gray-600">Kegiatan sudah baik dan sesuai</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" name="review_status" value="needs_revision" 
                               class="sr-only peer" required>
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-edit text-orange-500 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Perlu Revisi</p>
                                    <p class="text-sm text-gray-600">Perlu perbaikan atau tambahan</p>
                                </div>
                            </div>
                        </div>
                    </label>
                    
                    <label class="relative">
                        <input type="radio" name="review_status" value="rejected" 
                               class="sr-only peer" required>
                        <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-red-300 transition-colors">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                <div>
                                    <p class="font-medium text-gray-900">Ditolak</p>
                                    <p class="text-sm text-gray-600">Kegiatan tidak sesuai standar</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                <div id="review_status_error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>

            <!-- Rating -->
            <div class="mb-6">
                <label for="rating" class="block text-sm font-medium text-gray-700 mb-3">
                    Penilaian Kualitas (Opsional)
                </label>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Buruk</span>
                    <div class="flex space-x-1" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" 
                                    class="rating-star text-2xl text-gray-300 hover:text-yellow-400 transition-colors focus:outline-none">
                                <i class="fas fa-star"></i>
                            </button>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">Excellent</span>
                    <span id="ratingText" class="text-sm font-medium text-gray-700 ml-4"></span>
                </div>
                <input type="hidden" name="rating" id="ratingValue" value="">
                <div id="rating_error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>

            <!-- Feedback Comment -->
            <div class="mb-6">
                <label for="feedback_comment" class="block text-sm font-medium text-gray-700 mb-2">
                    Komentar Feedback <span class="text-red-500">*</span>
                </label>
                <textarea name="feedback_comment" id="feedback_comment" rows="5"
                          placeholder="Berikan feedback yang konstruktif tentang kegiatan mahasiswa. Jelaskan apa yang sudah baik dan apa yang perlu diperbaiki (minimal 10 karakter)"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                          required></textarea>
                <div class="flex justify-between items-center mt-1">
                    <div id="feedback_comment_error" class="text-red-500 text-sm hidden"></div>
                    <span id="feedbackCharCount" class="text-gray-500 text-sm">0 karakter</span>
                </div>
            </div>

            <!-- Suggestions -->
            <div class="mb-6">
                <label for="suggestions" class="block text-sm font-medium text-gray-700 mb-2">
                    Saran Perbaikan (Opsional)
                </label>
                <textarea name="suggestions" id="suggestions" rows="4"
                          placeholder="Berikan saran spesifik untuk perbaikan atau pengembangan lebih lanjut"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                <div id="suggestions_error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('dosen.review-kegiatan.show', $activity->activity_id) }}" 
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                
                <button type="submit" id="submitBtn"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-save mr-2"></i>
                    <span id="submitText">Simpan Review</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Character counter for feedback
    $('#feedback_comment').on('input', function() {
        const length = $(this).val().length;
        $('#feedbackCharCount').text(length + ' karakter');
        
        if (length < 10) {
            $('#feedbackCharCount').removeClass('text-green-500').addClass('text-red-500');
        } else {
            $('#feedbackCharCount').removeClass('text-red-500').addClass('text-green-500');
        }
    });

    // Form submission
    $('#reviewForm').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $('.text-red-500').addClass('hidden');
        
        // Disable submit button
        $('#submitBtn').prop('disabled', true);
        $('#submitText').text('Menyimpan...');
        
        const formData = {
            review_status: $('input[name="review_status"]:checked').val(),
            rating: $('#ratingValue').val(),
            feedback_comment: $('#feedback_comment').val(),
            suggestions: $('#suggestions').val()
        };
        
        $.ajax({
            url: '{{ route("dosen.review-kegiatan.store-review", $activity->activity_id) }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    
                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = response.redirect_url || '{{ route("dosen.review-kegiatan.index") }}';
                    }, 2000);
                } else {
                    showAlert('error', response.message);
                    $('#submitBtn').prop('disabled', false);
                    $('#submitText').text('Simpan Review');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    for (const field in errors) {
                        $(`#${field}_error`).text(errors[field][0]).removeClass('hidden');
                    }
                } else {
                    const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat menyimpan review.';
                    showAlert('error', message);
                }
                
                $('#submitBtn').prop('disabled', false);
                $('#submitText').text('Simpan Review');
            }
        });
    });

    // Initialize character counter
    $('#feedback_comment').trigger('input');
});

let currentRating = 0;

function setRating(rating) {
    currentRating = rating;
    $('#ratingValue').val(rating);
    
    // Update star display
    $('.rating-star').each(function(index) {
        const star = $(this).find('i');
        if (index < rating) {
            star.removeClass('text-gray-300').addClass('text-yellow-400');
        } else {
            star.removeClass('text-yellow-400').addClass('text-gray-300');
        }
    });
    
    // Update rating text
    const ratingTexts = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
    $('#ratingText').text(`(${rating}/5 - ${ratingTexts[rating]})`);
}

function toggleFullDescription() {
    const fullDesc = $('#fullDescription');
    const toggleBtn = $('#toggleBtn');
    
    if (fullDesc.hasClass('hidden')) {
        fullDesc.removeClass('hidden');
        toggleBtn.text('Lihat lebih sedikit');
    } else {
        fullDesc.addClass('hidden');
        toggleBtn.text('Lihat selengkapnya');
    }
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
