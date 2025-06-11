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
                <h1 class="text-2xl font-bold text-gray-800">Laporan Kegiatan Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Generate dan export laporan aktivitas magang mahasiswa bimbingan</p>
            </div>
            
            <button onclick="printReport()" 
                    class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print Laporan
            </button>
        </div>
    </div>

    <!-- Report Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Laporan</h2>
        
        <form method="GET" action="{{ route('dosen.review-kegiatan.report') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="mahasiswa_id" class="block text-sm font-medium text-gray-700 mb-2">Mahasiswa</label>
                <select name="mahasiswa_id" id="mahasiswa_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Mahasiswa</option>
                    @foreach($supervisedStudents as $student)
                        <option value="{{ $student->mahasiswa_id }}" {{ $mahasiswaId == $student->mahasiswa_id ? 'selected' : '' }}>
                            {{ $student->user->nama }}
                        </option>
                    @endforeach
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
            
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-search mr-2"></i>Generate Laporan
                </button>
            </div>
        </form>
    </div>

    <!-- Report Content -->
    <div id="reportContent" class="bg-white rounded-lg shadow">
        <!-- Report Header -->
        <div class="p-6 border-b border-gray-200 print:border-b-2 print:border-black">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">LAPORAN KEGIATAN MAGANG MAHASISWA</h1>
                <p class="text-gray-600">Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d F Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d F Y') }}</p>
                @if($mahasiswaId)
                    @php
                        $selectedStudent = $supervisedStudents->where('mahasiswa_id', $mahasiswaId)->first();
                    @endphp
                    @if($selectedStudent)
                        <p class="text-gray-600">Mahasiswa: {{ $selectedStudent->user->nama }}</p>
                    @endif
                @endif
                <p class="text-sm text-gray-500 mt-2">Dosen Pembimbing: {{ $dosen->user->nama }}</p>
            </div>
        </div>

        <!-- Summary Statistics -->
        @if($activities->isNotEmpty())
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Statistik</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $activities->count() }}</div>
                        <div class="text-sm text-gray-600">Total Kegiatan</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $activities->where('status', 'approved')->count() }}</div>
                        <div class="text-sm text-gray-600">Disetujui</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $activities->where('status', 'pending')->count() }}</div>
                        <div class="text-sm text-gray-600">Menunggu Review</div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4 text-center">
                        @php
                            $totalHours = $activities->sum(function($activity) {
                                if ($activity->start_time && $activity->end_time) {
                                    $start = \Carbon\Carbon::parse($activity->start_time);
                                    $end = \Carbon\Carbon::parse($activity->end_time);
                                    return $start->diffInHours($end);
                                }
                                return 0;
                            });
                        @endphp
                        <div class="text-2xl font-bold text-purple-600">{{ number_format($totalHours, 1) }}</div>
                        <div class="text-sm text-gray-600">Total Jam</div>
                    </div>
                </div>

                <!-- Performance by Student -->
                @if(!$mahasiswaId)
                    <div class="mb-6">
                        <h3 class="text-md font-semibold text-gray-900 mb-3">Performa per Mahasiswa</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Disetujui</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Pending</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Rata-rata Rating</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($activities->groupBy('mahasiswa_id') as $mahasiswaId => $studentActivities)
                                        @php
                                            $student = $studentActivities->first()->mahasiswa;
                                            $avgRating = $studentActivities->whereNotNull('latestReview.rating')->avg('latestReview.rating');
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $student->user->nama }}</td>
                                            <td class="px-4 py-2 text-sm text-center">{{ $studentActivities->count() }}</td>
                                            <td class="px-4 py-2 text-sm text-center">{{ $studentActivities->where('status', 'approved')->count() }}</td>
                                            <td class="px-4 py-2 text-sm text-center">{{ $studentActivities->where('status', 'pending')->count() }}</td>
                                            <td class="px-4 py-2 text-sm text-center">
                                                @if($avgRating)
                                                    {{ number_format($avgRating, 1) }}/5
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Detailed Activities -->
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Kegiatan</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                @if(!$mahasiswaId)
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                                @endif
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kegiatan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Perusahaan</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Durasi</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($activities->sortBy('activity_date') as $activity)
                                <tr class="print:break-inside-avoid">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $activity->activity_date->format('d/m/Y') }}</td>
                                    @if(!$mahasiswaId)
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $activity->mahasiswa->user->nama }}</td>
                                    @endif
                                    <td class="px-4 py-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $activity->activity_title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($activity->activity_description, 80) }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $activity->pengajuan->lowongan->partner->nama }}</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        @if($activity->start_time && $activity->end_time)
                                            {{ $activity->duration }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $activity->status_badge_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $activity->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($activity->latestReview && $activity->latestReview->rating)
                                            <div class="flex items-center justify-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-xs {{ $i <= $activity->latestReview->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                                <span class="text-xs text-gray-600 ml-1">({{ $activity->latestReview->rating }})</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Report Footer -->
            <div class="p-6 border-t border-gray-200 print:border-t-2 print:border-black">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <p>Laporan dibuat pada: {{ now()->format('d F Y, H:i') }} WIB</p>
                        <p>Dosen Pembimbing: {{ $dosen->user->nama }}</p>
                    </div>
                    <div class="text-right">
                        <p>Total {{ $activities->count() }} kegiatan</p>
                        <p>Periode: {{ \Carbon\Carbon::parse($dateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        @else
            <!-- No Data -->
            <div class="p-12 text-center">
                <i class="fas fa-chart-bar text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Data</h3>
                <p class="text-gray-600">Tidak ada kegiatan mahasiswa dalam periode yang dipilih.</p>
                <p class="text-gray-500 text-sm mt-2">Silakan ubah filter tanggal atau pilih mahasiswa yang berbeda.</p>
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    
    #reportContent, #reportContent * {
        visibility: visible;
    }
    
    #reportContent {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none;
        border-radius: 0;
    }
    
    .print\:break-inside-avoid {
        break-inside: avoid;
    }
    
    .print\:border-b-2 {
        border-bottom-width: 2px;
    }
    
    .print\:border-t-2 {
        border-top-width: 2px;
    }
    
    .print\:border-black {
        border-color: black;
    }
    
    /* Hide elements that shouldn't be printed */
    .no-print {
        display: none !important;
    }
}
</style>

<script>
function printReport() {
    window.print();
}

// Auto-set date range to current month if not set
$(document).ready(function() {
    if (!$('#date_from').val()) {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        $('#date_from').val(firstDay.toISOString().split('T')[0]);
    }
    
    if (!$('#date_to').val()) {
        const now = new Date();
        $('#date_to').val(now.toISOString().split('T')[0]);
    }
});
</script>
@endsection
