@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('dosen.feedback-mahasiswa.index') }}" 
               class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-gray-800">Analytics Feedback Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Analisis dan statistik feedback dari mahasiswa bimbingan</p>
            </div>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Periode</h2>
        
        <form method="GET" action="{{ route('dosen.feedback-mahasiswa.analytics') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    <i class="fas fa-chart-line mr-2"></i>Update Analytics
                </button>
            </div>
        </form>
    </div>

    <!-- Overview Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-comments text-blue-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Feedback</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $analytics['total_responses'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-star text-yellow-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Kepuasan</p>
                    <p class="text-xl font-semibold text-gray-900">
                        {{ number_format($analytics['student_satisfaction']['average'], 1) }}/10
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-thumbs-up text-green-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Tingkat Kepuasan</p>
                    <p class="text-xl font-semibold text-gray-900">
                        {{ number_format($analytics['student_satisfaction']['satisfaction_rate'], 1) }}%
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-building text-purple-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Perusahaan Partner</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $analytics['responses_by_partner']->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Feedback Trend -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Tren Feedback per Bulan</h2>
            </div>
            <div class="p-6">
                @if($analytics['responses_by_month']->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($analytics['responses_by_month'] as $month => $count)
                            @php
                                $percentage = ($count / $analytics['total_responses']) * 100;
                                $monthName = \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y');
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $monthName }}</span>
                                    <span class="text-sm text-gray-600">{{ $count }} feedback</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-chart-line text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">Tidak ada data untuk periode ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Partner Performance -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Performa Partner</h2>
            </div>
            <div class="p-6">
                @if($analytics['average_ratings_by_partner']->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($analytics['average_ratings_by_partner']->sortByDesc(function($rating) { return $rating; })->take(5) as $partner => $avgRating)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ Str::limit($partner, 25) }}</h4>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 10; $i++)
                                            <div class="w-2 h-2 mx-0.5 rounded {{ $i <= round($avgRating) ? 'bg-yellow-400' : 'bg-gray-300' }}"></div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-blue-600">{{ number_format($avgRating, 1) }}</div>
                                    <div class="text-xs text-gray-500">dari 10</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-building text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">Tidak ada data rating partner</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Detailed Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Feedback by Partner -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Feedback per Perusahaan</h2>
            </div>
            <div class="p-6">
                @if($analytics['responses_by_partner']->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($analytics['responses_by_partner']->sortByDesc(function($count) { return $count; }) as $partner => $count)
                            @php
                                $percentage = ($count / $analytics['total_responses']) * 100;
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ Str::limit($partner, 30) }}</span>
                                    <span class="text-sm text-gray-600">{{ $count }} ({{ number_format($percentage, 1) }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-building text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">Tidak ada data feedback</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Satisfaction Analysis -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Analisis Kepuasan</h2>
            </div>
            <div class="p-6">
                @if($analytics['student_satisfaction']['total_ratings'] > 0)
                    <div class="space-y-6">
                        <!-- Overall Satisfaction -->
                        <div class="text-center">
                            <div class="text-4xl font-bold text-blue-600 mb-2">
                                {{ number_format($analytics['student_satisfaction']['average'], 1) }}
                            </div>
                            <div class="text-sm text-gray-600 mb-4">Rata-rata Kepuasan (dari 10)</div>
                            <div class="flex justify-center">
                                @for($i = 1; $i <= 10; $i++)
                                    <div class="w-4 h-4 mx-1 rounded {{ $i <= round($analytics['student_satisfaction']['average']) ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                                @endfor
                            </div>
                        </div>

                        <!-- Satisfaction Rate -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Tingkat Kepuasan (Rating ≥ 7)</span>
                                <span class="text-sm text-gray-600">{{ number_format($analytics['student_satisfaction']['satisfaction_rate'], 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-500 h-3 rounded-full" style="width: {{ $analytics['student_satisfaction']['satisfaction_rate'] }}%"></div>
                            </div>
                        </div>

                        <!-- Total Ratings -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-gray-900">{{ $analytics['student_satisfaction']['total_ratings'] }}</div>
                                <div class="text-sm text-gray-600">Total Rating Diberikan</div>
                            </div>
                        </div>

                        <!-- Satisfaction Categories -->
                        <div class="space-y-2">
                            @php
                                $excellent = ($analytics['student_satisfaction']['average'] >= 8.5) ? 'Excellent' : '';
                                $good = ($analytics['student_satisfaction']['average'] >= 7 && $analytics['student_satisfaction']['average'] < 8.5) ? 'Good' : '';
                                $fair = ($analytics['student_satisfaction']['average'] >= 5 && $analytics['student_satisfaction']['average'] < 7) ? 'Fair' : '';
                                $poor = ($analytics['student_satisfaction']['average'] < 5) ? 'Poor' : '';
                                
                                $category = $excellent ?: ($good ?: ($fair ?: $poor));
                                $categoryColor = $excellent ? 'text-green-600' : ($good ? 'text-blue-600' : ($fair ? 'text-yellow-600' : 'text-red-600'));
                            @endphp
                            <div class="text-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 {{ $categoryColor }}">
                                    {{ $category ?: 'No Data' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-star text-4xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600">Tidak ada data rating</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Summary Report -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Ringkasan Periode</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-medium text-gray-900 mb-3">Periode Analisis</h3>
                    <p class="text-gray-600">{{ \Carbon\Carbon::parse($dateFrom)->format('d F Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d F Y') }}</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900 mb-3">Kesimpulan</h3>
                    @if($analytics['total_responses'] > 0)
                        <p class="text-gray-600">
                            Dalam periode ini, terdapat {{ $analytics['total_responses'] }} feedback dari mahasiswa bimbingan 
                            dengan rata-rata kepuasan {{ number_format($analytics['student_satisfaction']['average'], 1) }}/10 
                            dan tingkat kepuasan {{ number_format($analytics['student_satisfaction']['satisfaction_rate'], 1) }}%.
                        </p>
                    @else
                        <p class="text-gray-600">Tidak ada feedback yang diterima dalam periode ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
