{{-- Show Activity Modal Content --}}
<div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
    {{-- Modal Header --}}
    <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <div>
            <h3 class="text-xl font-semibold text-gray-800">Detail Kegiatan Magang</h3>
            <p class="text-sm text-gray-600 mt-1">{{ $activity->activity_title }}</p>
        </div>
        <button type="button" id="closeShowModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>
    </div>

    {{-- Modal Body --}}
    <div class="p-6">
        {{-- Activity Information --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            {{-- Basic Information --}}
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Informasi Dasar</h4>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm font-medium text-gray-600">Tanggal Kegiatan:</span>
                        <p class="text-gray-900">{{ $activity->activity_date->format('d/m/Y') }}</p>
                    </div>
                    @if($activity->start_time && $activity->end_time)
                        <div>
                            <span class="text-sm font-medium text-gray-600">Waktu:</span>
                            <p class="text-gray-900">{{ $activity->start_time->format('H:i') }} - {{ $activity->end_time->format('H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Durasi:</span>
                            <p class="text-gray-900">{{ $activity->duration }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="text-sm font-medium text-gray-600">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activity->status_badge_color }}">
                            <i class="fas {{ $activity->status_icon }} mr-1"></i>
                            {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Internship Information --}}
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-800 mb-3">Informasi Magang</h4>
                <div class="space-y-2">
                    <div>
                        <span class="text-sm font-medium text-gray-600">Perusahaan:</span>
                        <p class="text-gray-900">{{ $activity->pengajuan->lowongan->partner->nama }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-600">Posisi:</span>
                        <p class="text-gray-900">{{ $activity->pengajuan->lowongan->judul }}</p>
                    </div>
                    @if($activity->dosen)
                        <div>
                            <span class="text-sm font-medium text-gray-600">Dosen Pembimbing:</span>
                            <p class="text-gray-900">{{ $activity->dosen->user->nama }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Activity Description --}}
        <div class="mb-6">
            <h4 class="font-semibold text-gray-800 mb-3">Deskripsi Kegiatan</h4>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $activity->activity_description }}</p>
            </div>
        </div>

        {{-- Learning Objectives --}}
        @if($activity->learning_objectives)
            <div class="mb-6">
                <h4 class="font-semibold text-gray-800 mb-3">Tujuan Pembelajaran</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $activity->learning_objectives }}</p>
                </div>
            </div>
        @endif

        {{-- Challenges and Solutions --}}
        @if($activity->challenges_faced || $activity->solutions_applied)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                @if($activity->challenges_faced)
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Tantangan yang Dihadapi</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $activity->challenges_faced }}</p>
                        </div>
                    </div>
                @endif

                @if($activity->solutions_applied)
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-3">Solusi yang Diterapkan</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900 whitespace-pre-wrap">{{ $activity->solutions_applied }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Weekly Summary Information --}}
        @if($activity->is_weekly_summary)
            <div class="mb-6">
                <h4 class="font-semibold text-gray-800 mb-3">Ringkasan Mingguan</h4>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-calendar-week text-blue-600 mr-2"></i>
                        <span class="font-medium text-blue-800">Periode Minggu</span>
                    </div>
                    <p class="text-blue-700">
                        {{ $activity->week_start_date->format('d/m/Y') }} - {{ $activity->week_end_date->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Attachments --}}
        @if($activity->attachments->isNotEmpty())
            <div class="mb-6">
                <h4 class="font-semibold text-gray-800 mb-3">Lampiran</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($activity->attachments as $attachment)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <i class="fas {{ $attachment->file_type_icon }} text-2xl {{ $attachment->file_type_color }}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        {{ $attachment->original_filename }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $attachment->formatted_file_size }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{ route('mahasiswa.kegiatan.download-attachment', $attachment->attachment_id) }}"
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Reviews --}}
        @if($activity->reviews->isNotEmpty())
            <div class="mb-6">
                <h4 class="font-semibold text-gray-800 mb-3">Riwayat Review</h4>
                <div class="space-y-4">
                    @foreach($activity->reviews as $review)
                        <div class="bg-blue-50 border-l-4 border-blue-400 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <p class="font-medium text-blue-800">{{ $review->dosen->user->nama }}</p>
                                    <p class="text-sm text-blue-600">{{ $review->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $review->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                       ($review->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                </span>
                            </div>
                            @if($review->feedback_comment)
                                <p class="text-blue-800 whitespace-pre-wrap">{{ $review->feedback_comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Timestamps --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-800 mb-3">Informasi Waktu</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="font-medium text-gray-600">Dibuat:</span>
                    <p class="text-gray-900">{{ $activity->created_at->format('d/m/Y H:i') }}</p>
                </div>
                @if($activity->submitted_at)
                    <div>
                        <span class="font-medium text-gray-600">Dikirim:</span>
                        <p class="text-gray-900">{{ $activity->submitted_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
                @if($activity->reviewed_at)
                    <div>
                        <span class="font-medium text-gray-600">Direview:</span>
                        <p class="text-gray-900">{{ $activity->reviewed_at->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Footer --}}
    <div class="flex justify-between items-center p-6 border-t border-gray-200 bg-gray-50">
        <div class="flex space-x-3">
            @if($activity->canBeEdited())
                <button type="button" onclick="openEditModal({{ $activity->activity_id }})"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Kegiatan
                </button>
            @endif
        </div>
        <button type="button" id="closeShowModalBtn"
            class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
            <i class="fas fa-times mr-2"></i>
            Tutup
        </button>
    </div>
</div>
