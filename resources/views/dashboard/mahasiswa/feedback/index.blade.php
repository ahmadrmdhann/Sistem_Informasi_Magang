@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Feedback Magang</h1>
                <p class="text-gray-600 mt-1">Berikan feedback tentang pengalaman magang Anda</p>
            </div>

            <!-- Test Mode Toggle -->
            <div class="flex items-center space-x-3">
                <button id="toggleTestMode"
                        class="px-4 py-2 rounded-lg transition-colors {{ $testMode ? 'bg-orange-500 hover:bg-orange-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-700' }}">
                    <i class="fas {{ $testMode ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-2"></i>
                    Test Mode
                </button>

                @if($testMode)
                    <button id="clearTestData"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Clear Test Data
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- Test Mode Banner -->
    @if($testMode)
        <div class="mb-6 p-4 bg-orange-100 border-l-4 border-orange-500 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-orange-500 mr-3"></i>
                <div>
                    <h3 class="text-orange-800 font-semibold">TEST MODE AKTIF</h3>
                    <p class="text-orange-700 text-sm">Anda dapat mengisi feedback untuk semua pengajuan magang. Data yang dikirim akan ditandai sebagai data testing.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Internship Status Summary -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Magang Anda</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                <i class="fas fa-briefcase text-blue-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Magang</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $completedInternships->count() }}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-green-50 rounded-lg">
                <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Feedback Terkirim</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $formsWithStatus->where('is_submitted', true)->count() }}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-yellow-50 rounded-lg">
                <i class="fas fa-clock text-yellow-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Menunggu Feedback</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $formsWithStatus->where('can_submit', true)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Feedback Forms -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Form Feedback Tersedia</h2>
            <p class="text-gray-600 text-sm mt-1">Isi feedback untuk pengalaman magang Anda</p>
        </div>

        <div class="p-6">
            @if($formsWithStatus->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Form Feedback</h3>
                    <p class="text-gray-600">Saat ini belum ada form feedback yang tersedia.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($formsWithStatus as $item)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900 mr-3">{{ $item['form']->title }}</h3>
                                        @if($item['is_submitted'])
                                            @if($item['is_test_response'])
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                                    <i class="fas fa-flask mr-1"></i>
                                                    Test Data
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i>
                                                    Sudah Terkirim
                                                </span>
                                            @endif
                                        @elseif($item['can_submit'])
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Menunggu
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Tidak Tersedia
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($item['form']->description)
                                        <p class="text-gray-600 mb-3">{{ $item['form']->description }}</p>
                                    @endif

                                    <div class="flex items-center text-sm text-gray-500 space-x-4">
                                        <span>
                                            <i class="fas fa-question-circle mr-1"></i>
                                            {{ $item['form']->questions->count() }} pertanyaan
                                        </span>
                                        @if($item['form']->end_date)
                                            <span>
                                                <i class="fas fa-calendar mr-1"></i>
                                                Berakhir: {{ $item['form']->end_date->format('d/m/Y') }}
                                            </span>
                                        @endif
                                        @if($item['is_submitted'])
                                            <span>
                                                <i class="fas fa-clock mr-1"></i>
                                                Dikirim: {{ $item['submitted_at']->format('d/m/Y H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="ml-4">
                                    @if($item['is_submitted'])
                                        <a href="{{ route('mahasiswa.feedback.response', $item['response']->response_id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                            <i class="fas fa-eye mr-2"></i>
                                            Lihat Jawaban
                                        </a>
                                    @elseif($item['can_submit'])
                                        <a href="{{ route('mahasiswa.feedback.form', $item['form']->form_id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                            <i class="fas fa-edit mr-2"></i>
                                            Isi Feedback
                                        </a>
                                    @else
                                        <button disabled 
                                                class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed">
                                            <i class="fas fa-lock mr-2"></i>
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Completed Internships Info -->
    @if($completedInternships->isNotEmpty())
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Magang Anda</h2>
                <p class="text-gray-600 text-sm mt-1">Daftar pengalaman magang yang telah selesai</p>
            </div>
            
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($completedInternships as $internship)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <i class="fas fa-building text-blue-500 text-xl mr-4"></i>
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $internship->lowongan->judul }}</h4>
                                <p class="text-sm text-gray-600">{{ $internship->lowongan->partner->nama }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Selesai
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="p-6 text-center">
                <i class="fas fa-info-circle text-4xl text-blue-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Magang yang Selesai</h3>
                <p class="text-gray-600">Anda perlu menyelesaikan magang terlebih dahulu sebelum dapat mengisi feedback.</p>
                <a href="{{ route('mahasiswa.lowongan.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors mt-4">
                    <i class="fas fa-search mr-2"></i>
                    Cari Lowongan Magang
                </a>
            </div>
        </div>
    @endif
</div>

<script>
$(document).ready(function() {
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Toggle Test Mode
    $('#toggleTestMode').on('click', function() {
        const button = $(this);
        const originalText = button.html();

        // Show loading state
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Loading...');

        $.ajax({
            url: '{{ route("mahasiswa.feedback.toggle-test") }}',
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);

                    // Reload page to reflect changes
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert('error', 'Gagal mengubah test mode.');
                    button.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan saat mengubah test mode.');
                button.prop('disabled', false).html(originalText);
            }
        });
    });

    // Clear Test Data
    $('#clearTestData').on('click', function() {
        if (!confirm('Apakah Anda yakin ingin menghapus semua data test feedback? Tindakan ini tidak dapat dibatalkan.')) {
            return;
        }

        const button = $(this);
        const originalText = button.html();

        // Show loading state
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...');

        $.ajax({
            url: '{{ route("mahasiswa.feedback.clear-test") }}',
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);

                    // Reload page to reflect changes
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert('error', 'Gagal menghapus data test.');
                    button.prop('disabled', false).html(originalText);
                }
            },
            error: function() {
                showAlert('error', 'Terjadi kesalahan saat menghapus data test.');
                button.prop('disabled', false).html(originalText);
            }
        });
    });
});

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
