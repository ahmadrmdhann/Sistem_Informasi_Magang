@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Log Kegiatan Magang</h1>
                <p class="text-gray-600 mt-1">Catat dan kelola aktivitas harian magang Anda</p>
            </div>
            
            @if($internships->isNotEmpty())
                <a href="{{ route('mahasiswa.kegiatan.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kegiatan
                </a>
            @endif
        </div>
    </div>

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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <i class="fas fa-clipboard-list text-blue-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Kegiatan</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <i class="fas fa-clock text-yellow-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Menunggu Review</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Disetujui</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['approved'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <i class="fas fa-edit text-orange-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Perlu Revisi</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['needs_revision'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <i class="fas fa-times-circle text-red-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Ditolak</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['rejected'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Kegiatan</h2>
        
        <form method="GET" action="{{ route('mahasiswa.kegiatan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="internship_id" class="block text-sm font-medium text-gray-700 mb-2">Pengalaman Magang</label>
                <select name="internship_id" id="internship_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Magang</option>
                    @foreach($internships as $internship)
                        <option value="{{ $internship->id }}" {{ $selectedInternship == $internship->id ? 'selected' : '' }}>
                            {{ $internship->lowongan->judul }} - {{ $internship->lowongan->partner->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                    <option value="approved" {{ $statusFilter == 'approved' ? 'selected' : '' }}>Disetujui</option>
                    <option value="needs_revision" {{ $statusFilter == 'needs_revision' ? 'selected' : '' }}>Perlu Revisi</option>
                    <option value="rejected" {{ $statusFilter == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <input type="date" name="date_from" id="date_from" value="{{ $dateFrom }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <input type="date" name="date_to" id="date_to" value="{{ $dateTo }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="md:col-span-4 flex space-x-3">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('mahasiswa.kegiatan.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Activities List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Kegiatan</h2>
            <p class="text-gray-600 text-sm mt-1">Riwayat aktivitas magang Anda</p>
        </div>

        <div class="p-6">
            @if($activities->isEmpty())
                <div class="text-center py-12">
                    @if($internships->isEmpty())
                        <i class="fas fa-info-circle text-4xl text-blue-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Magang yang Diterima</h3>
                        <p class="text-gray-600 mb-4">Anda perlu memiliki magang yang diterima untuk dapat mencatat kegiatan.</p>
                        <a href="{{ route('mahasiswa.lowongan.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-search mr-2"></i>
                            Cari Lowongan Magang
                        </a>
                    @else
                        <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kegiatan</h3>
                        <p class="text-gray-600 mb-4">Mulai catat aktivitas magang harian Anda.</p>
                        <a href="{{ route('mahasiswa.kegiatan.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Kegiatan Pertama
                        </a>
                    @endif
                </div>
            @else
                <!-- Timeline View -->
                <div class="space-y-6">
                    @foreach($activities as $activity)
                        <div class="relative">
                            <!-- Timeline line -->
                            @if(!$loop->last)
                                <div class="absolute left-6 top-12 w-0.5 h-full bg-gray-200"></div>
                            @endif
                            
                            <!-- Activity card -->
                            <div class="flex items-start space-x-4">
                                <!-- Status icon -->
                                <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center {{ $activity->status_badge_color }}">
                                    <i class="fas {{ $activity->status_icon }}"></i>
                                </div>
                                
                                <!-- Activity content -->
                                <div class="flex-1 bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $activity->activity_title }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $activity->activity_date->format('d/m/Y') }}
                                                @if($activity->start_time && $activity->end_time)
                                                    • {{ $activity->start_time->format('H:i') }} - {{ $activity->end_time->format('H:i') }}
                                                    • {{ $activity->duration }}
                                                @endif
                                            </p>
                                            <p class="text-sm text-blue-600 font-medium">
                                                {{ $activity->pengajuan->lowongan->partner->nama }}
                                            </p>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activity->status_badge_color }}">
                                                <i class="fas {{ $activity->status_icon }} mr-1"></i>
                                                {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                                            </span>
                                            
                                            @if($activity->attachments->isNotEmpty())
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                                    <i class="fas fa-paperclip mr-1"></i>
                                                    {{ $activity->attachments->count() }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mb-3 line-clamp-2">{{ Str::limit($activity->activity_description, 150) }}</p>
                                    
                                    @if($activity->latestReview && $activity->latestReview->feedback_comment)
                                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-3">
                                            <p class="text-sm text-blue-800">
                                                <strong>Feedback Dosen:</strong> {{ Str::limit($activity->latestReview->feedback_comment, 100) }}
                                            </p>
                                        </div>
                                    @endif
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-gray-500">
                                            Dikirim: {{ $activity->submitted_at ? $activity->submitted_at->format('d/m/Y H:i') : '-' }}
                                            @if($activity->reviewed_at)
                                                • Direview: {{ $activity->reviewed_at->format('d/m/Y H:i') }}
                                            @endif
                                        </div>
                                        
                                        <div class="flex space-x-2">
                                            <a href="{{ route('mahasiswa.kegiatan.show', $activity->activity_id) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-eye mr-1"></i>Lihat
                                            </a>
                                            
                                            @if($activity->canBeEdited())
                                                <a href="{{ route('mahasiswa.kegiatan.edit', $activity->activity_id) }}" 
                                                   class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </a>
                                                
                                                <button onclick="deleteActivity({{ $activity->activity_id }})" 
                                                        class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    <i class="fas fa-trash mr-1"></i>Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
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
});

function deleteActivity(activityId) {
    if (!confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }

    $.ajax({
        url: `/mahasiswa/kegiatan/${activityId}`,
        type: 'DELETE',
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);

                // Reload page after 1.5 seconds
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(xhr) {
            const message = xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus kegiatan.';
            showAlert('error', message);
        }
    });
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
