@extends('layouts.dashboard')

@section('title', 'Review Kegiatan Mahasiswa')

@section('content')
<div id="mainContent" class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-gray-50 via-slate-50 to-blue-50">
    <div class="container mx-auto px-6 py-8">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-slate-600 via-gray-600 to-slate-700 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-clipboard-check text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Review Kegiatan Mahasiswa</h1>
                            <p class="text-xl text-white/90">Kelola dan review aktivitas magang mahasiswa bimbingan</p>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('dosen.review-kegiatan.report') }}" 
                           class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 backdrop-blur-sm">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Generate Report
                        </a>
                    </div>
                </div>
            </div>
        </div>        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border border-emerald-400 text-emerald-700 rounded-xl flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-100 border border-rose-400 text-rose-700 rounded-xl flex items-center">
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
        
        <form method="GET" action="{{ route('dosen.review-kegiatan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Mahasiswa</option>
                    @foreach($supervisedStudents as $student)
                        <option value="{{ $student->mahasiswa_id }}" {{ $mahasiswaFilter == $student->mahasiswa_id ? 'selected' : '' }}>
                            {{ $student->user->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Menunggu Review</option>
                    <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>Semua Status</option>
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
                <a href="{{ route('dosen.review-kegiatan.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Activities List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Kegiatan untuk Review</h2>
            <p class="text-gray-600 text-sm mt-1">Aktivitas mahasiswa yang memerlukan review Anda</p>
        </div>

        <div class="p-6">
            @if($activities->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-clipboard-list text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Kegiatan</h3>
                    <p class="text-gray-600">Belum ada kegiatan mahasiswa yang perlu direview dengan filter yang dipilih.</p>
                </div>
            @else
                <!-- Activities Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Mahasiswa & Kegiatan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal & Waktu
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lampiran
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($activities as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $activity->mahasiswa->user->nama }}
                                                </p>
                                                <p class="text-sm text-blue-600 font-medium">
                                                    {{ $activity->activity_title }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $activity->pengajuan->lowongan->partner->nama }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    {{ Str::limit($activity->activity_description, 80) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $activity->activity_date->format('d/m/Y') }}
                                        </div>
                                        @if($activity->start_time && $activity->end_time)
                                            <div class="text-sm text-gray-500">
                                                {{ $activity->start_time->format('H:i') }} - {{ $activity->end_time->format('H:i') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ $activity->duration }}
                                            </div>
                                        @endif
                                        <div class="text-xs text-gray-400 mt-1">
                                            Dikirim: {{ $activity->submitted_at ? $activity->submitted_at->format('d/m H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activity->status_badge_color }}">
                                            <i class="fas {{ $activity->status_icon }} mr-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                                        </span>
                                        @if($activity->latestReview && $activity->latestReview->rating)
                                            <div class="flex items-center mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-xs {{ $i <= $activity->latestReview->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                                <span class="text-xs text-gray-500 ml-1">({{ $activity->latestReview->rating }}/5)</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($activity->attachments->isNotEmpty())
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-600">
                                                <i class="fas fa-paperclip mr-1"></i>
                                                {{ $activity->attachments->count() }} file
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('dosen.review-kegiatan.show', $activity->activity_id) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye mr-1"></i>Lihat
                                            </a>
                                            
                                            @if($activity->status === 'pending')
                                                <a href="{{ route('dosen.review-kegiatan.review', $activity->activity_id) }}" 
                                                   class="text-green-600 hover:text-green-800">
                                                    <i class="fas fa-clipboard-check mr-1"></i>Review
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('dosen.review-kegiatan.student-progress', $activity->mahasiswa_id) }}" 
                                               class="text-purple-600 hover:text-purple-800">
                                                <i class="fas fa-chart-line mr-1"></i>Progress
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
