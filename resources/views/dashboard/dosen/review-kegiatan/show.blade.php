@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('dosen.review-kegiatan.index') }}" 
               class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">Detail Kegiatan Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Review aktivitas magang mahasiswa bimbingan</p>
            </div>
            
            @if($activity->status === 'pending')
                <a href="{{ route('dosen.review-kegiatan.review', $activity->activity_id) }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Review Kegiatan
                </a>
            @endif
        </div>
    </div>

    <!-- Activity Header -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $activity->activity_title }}</h2>
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-user mr-2"></i>
                            <span>{{ $activity->mahasiswa->user->nama }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-building mr-2"></i>
                            <span>{{ $activity->pengajuan->lowongan->partner->nama }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>{{ $activity->activity_date->format('d F Y') }}</span>
                        </div>
                        @if($activity->start_time && $activity->end_time)
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $activity->start_time->format('H:i') }} - {{ $activity->end_time->format('H:i') }} ({{ $activity->duration }})</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="flex flex-col items-end space-y-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $activity->status_badge_color }}">
                        <i class="fas {{ $activity->status_icon }} mr-2"></i>
                        {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                    </span>
                    
                    @if($activity->is_weekly_summary)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-purple-100 text-purple-600">
                            <i class="fas fa-calendar-week mr-1"></i>
                            Ringkasan Mingguan
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Activity Details -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Description -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Kegiatan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $activity->activity_description }}</p>
                        </div>
                    </div>

                    <!-- Learning Objectives -->
                    @if($activity->learning_objectives)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tujuan Pembelajaran</h3>
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $activity->learning_objectives }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Challenges -->
                    @if($activity->challenges_faced)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tantangan yang Dihadapi</h3>
                            <div class="bg-orange-50 border-l-4 border-orange-400 p-4">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $activity->challenges_faced }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Solutions -->
                    @if($activity->solutions_applied)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Solusi yang Diterapkan</h3>
                            <div class="bg-green-50 border-l-4 border-green-400 p-4">
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $activity->solutions_applied }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Weekly Summary Info -->
                    @if($activity->is_weekly_summary && $activity->week_start_date && $activity->week_end_date)
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Periode Ringkasan</h3>
                            <div class="bg-purple-50 border-l-4 border-purple-400 p-4">
                                <p class="text-gray-700">
                                    <i class="fas fa-calendar-week mr-2"></i>
                                    {{ $activity->week_start_date->format('d F Y') }} - {{ $activity->week_end_date->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Activity Info -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Kegiatan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $activity->status)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dikirim:</span>
                                <span class="font-medium">{{ $activity->submitted_at ? $activity->submitted_at->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                            @if($activity->reviewed_at)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Direview:</span>
                                    <span class="font-medium">{{ $activity->reviewed_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @endif
                            @if($activity->attachments->isNotEmpty())
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Lampiran:</span>
                                    <span class="font-medium">{{ $activity->attachments->count() }} file</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Attachments -->
                    @if($activity->attachments->isNotEmpty())
                        <div class="bg-white border rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Lampiran File</h3>
                            <div class="space-y-2">
                                @foreach($activity->attachments as $attachment)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <i class="fas {{ $attachment->file_type_icon }} {{ $attachment->file_type_color }} text-lg"></i>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $attachment->original_filename }}</p>
                                                <p class="text-xs text-gray-500">{{ $attachment->formatted_file_size }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('mahasiswa.kegiatan.download-attachment', $attachment->attachment_id) }}" 
                                           class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white border rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Aksi Cepat</h3>
                        <div class="space-y-2">
                            @if($activity->status === 'pending')
                                <a href="{{ route('dosen.review-kegiatan.review', $activity->activity_id) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                                    <i class="fas fa-clipboard-check mr-2"></i>
                                    Review Kegiatan
                                </a>
                            @endif
                            
                            <a href="{{ route('dosen.review-kegiatan.student-progress', $activity->mahasiswa_id) }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors">
                                <i class="fas fa-chart-line mr-2"></i>
                                Lihat Progress Mahasiswa
                            </a>
                            
                            <a href="{{ route('dosen.review-kegiatan.index') }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                <i class="fas fa-list mr-2"></i>
                                Kembali ke Daftar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review History -->
    @if($activity->reviews->isNotEmpty())
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat Review</h2>
                <p class="text-gray-600 text-sm mt-1">Feedback dan penilaian yang telah diberikan</p>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($activity->reviews as $review)
                        <div class="border-l-4 {{ $review->review_status_badge_color }} pl-4 py-3">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $review->dosen->user->nama }}</p>
                                    <p class="text-sm text-gray-600">{{ $review->reviewed_at->format('d F Y, H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $review->review_status_badge_color }}">
                                        <i class="fas {{ $review->review_status_icon }} mr-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $review->review_status)) }}
                                    </span>
                                    @if($review->rating)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="text-sm text-gray-600 ml-1">({{ $review->rating }}/5)</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($review->feedback_comment)
                                <div class="mb-2">
                                    <p class="text-sm font-medium text-gray-700 mb-1">Feedback:</p>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $review->feedback_comment }}</p>
                                </div>
                            @endif
                            
                            @if($review->suggestions)
                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-1">Saran Perbaikan:</p>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $review->suggestions }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
