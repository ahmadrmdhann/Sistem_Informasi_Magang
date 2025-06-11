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
                <h1 class="text-2xl font-bold text-gray-800">Progress Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Monitoring perkembangan aktivitas magang {{ $mahasiswa->user->name }}</p>
            </div>
        </div>
    </div>

    <!-- Student Info -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-user text-blue-600 text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-900">{{ $mahasiswa->user->nama }}</h2>
                    <p class="text-gray-600">{{ $mahasiswa->user->email }}</p>
                    @if($mahasiswa->nim)
                        <p class="text-sm text-gray-500">NIM: {{ $mahasiswa->nim }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-600">Total Kegiatan</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['total_activities'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Disetujui</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</p>
                </div>
                <i class="fas fa-check-circle text-green-500 text-2xl"></i>
            </div>
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $stats['total_activities'] > 0 ? ($stats['approved'] / $stats['total_activities']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Menunggu Review</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
                <i class="fas fa-clock text-yellow-500 text-2xl"></i>
            </div>
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $stats['total_activities'] > 0 ? ($stats['pending'] / $stats['total_activities']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Perlu Revisi</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $stats['needs_revision'] }}</p>
                </div>
                <i class="fas fa-edit text-orange-500 text-2xl"></i>
            </div>
            <div class="mt-2">
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $stats['total_activities'] > 0 ? ($stats['needs_revision'] / $stats['total_activities']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Jam</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['total_hours'], 1) }}</p>
                </div>
                <i class="fas fa-clock text-blue-500 text-2xl"></i>
            </div>
            <div class="mt-2">
                <p class="text-xs text-gray-500">Jam kerja tercatat</p>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Average Rating -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rata-rata Penilaian</h3>
            <div class="flex items-center justify-center">
                @if($stats['average_rating'])
                    <div class="text-center">
                        <div class="text-4xl font-bold text-blue-600 mb-2">{{ number_format($stats['average_rating'], 1) }}</div>
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-lg {{ $i <= round($stats['average_rating']) ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-gray-600">dari 5.0</p>
                    </div>
                @else
                    <div class="text-center text-gray-500">
                        <i class="fas fa-star text-4xl text-gray-300 mb-2"></i>
                        <p>Belum ada penilaian</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Activity Trend -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tren Aktivitas</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Tingkat Persetujuan</span>
                    <span class="font-medium">{{ $stats['total_activities'] > 0 ? number_format(($stats['approved'] / $stats['total_activities']) * 100, 1) : 0 }}%</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Rata-rata Jam per Kegiatan</span>
                    <span class="font-medium">{{ $stats['total_activities'] > 0 ? number_format($stats['total_hours'] / $stats['total_activities'], 1) : 0 }} jam</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Kegiatan dengan Lampiran</span>
                    <span class="font-medium">{{ $activities->where('attachments_count', '>', 0)->count() }} dari {{ $stats['total_activities'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Riwayat Kegiatan</h2>
            <p class="text-gray-600 text-sm mt-1">Aktivitas terbaru mahasiswa dengan status review</p>
        </div>

        <div class="p-6">
            @if($activities->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kegiatan</h3>
                    <p class="text-gray-600">Mahasiswa belum mencatat kegiatan magang.</p>
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
                                <div class="flex-1 bg-gray-50 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $activity->activity_title }}</h3>
                                            <p class="text-sm text-gray-600">
                                                {{ $activity->activity_date->format('d/m/Y') }}
                                                @if($activity->start_time && $activity->end_time)
                                                    • {{ $activity->start_time->format('H:i') }} - {{ $activity->end_time->format('H:i') }}
                                                    • {{ $activity->duration }}
                                                @endif
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
                                    
                                    @if($activity->latestReview)
                                        <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-3">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <p class="text-sm text-blue-800">
                                                        <strong>Review:</strong> {{ Str::limit($activity->latestReview->feedback_comment, 100) }}
                                                    </p>
                                                </div>
                                                @if($activity->latestReview->rating)
                                                    <div class="flex items-center ml-3">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star text-xs {{ $i <= $activity->latestReview->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                        @endfor
                                                        <span class="text-xs text-gray-600 ml-1">({{ $activity->latestReview->rating }}/5)</span>
                                                    </div>
                                                @endif
                                            </div>
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
                                            <a href="{{ route('dosen.review-kegiatan.show', $activity->activity_id) }}" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                <i class="fas fa-eye mr-1"></i>Lihat
                                            </a>
                                            
                                            @if($activity->status === 'pending')
                                                <a href="{{ route('dosen.review-kegiatan.review', $activity->activity_id) }}" 
                                                   class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    <i class="fas fa-clipboard-check mr-1"></i>Review
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
