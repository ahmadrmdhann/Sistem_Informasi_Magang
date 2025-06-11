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
                <h1 class="text-2xl font-bold text-gray-800">Detail Feedback Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Feedback lengkap dari {{ $feedbackResponse->mahasiswa->user->nama }}</p>
            </div>
        </div>
    </div>

    <!-- Feedback Header -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-start">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-user text-blue-600 text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $feedbackResponse->mahasiswa->user->nama }}</h2>
                        <p class="text-gray-600">{{ $feedbackResponse->mahasiswa->user->email }}</p>
                        @if($feedbackResponse->mahasiswa->nim)
                            <p class="text-sm text-gray-500">NIM: {{ $feedbackResponse->mahasiswa->nim }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i>
                        Feedback Completed
                    </span>
                    <p class="text-sm text-gray-500 mt-1">{{ $feedbackResponse->submitted_at->format('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Feedback Info -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Form Feedback</h3>
                    <p class="text-lg font-semibold text-blue-600">{{ $feedbackResponse->form->title }}</p>
                    @if($feedbackResponse->form->description)
                        <p class="text-sm text-gray-600 mt-1">{{ $feedbackResponse->form->description }}</p>
                    @endif
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Perusahaan Magang</h3>
                    <p class="text-lg font-semibold text-gray-900">{{ $feedbackResponse->pengajuan->lowongan->partner->nama }}</p>
                    <p class="text-sm text-gray-600">{{ $feedbackResponse->pengajuan->lowongan->judul }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Periode Magang</h3>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($feedbackResponse->pengajuan->lowongan->tanggal_mulai)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($feedbackResponse->pengajuan->lowongan->tanggal_akhir)->format('d/m/Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Summary -->
    @if($ratingStats['total_ratings'] > 0)
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Ringkasan Penilaian</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2">{{ number_format($ratingStats['average_rating'], 1) }}</div>
                        <div class="text-sm text-gray-600">Rata-rata Rating (dari 10)</div>
                        <div class="flex justify-center mt-2">
                            @for($i = 1; $i <= 10; $i++)
                                <div class="w-3 h-3 mx-0.5 rounded {{ $i <= round($ratingStats['average_rating']) ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                            @endfor
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2">{{ $ratingStats['total_ratings'] }}</div>
                        <div class="text-sm text-gray-600">Total Pertanyaan Rating</div>
                    </div>
                    <div class="text-center">
                        @php
                            $satisfactionRate = $ratingStats['average_rating'] >= 7 ? 'Sangat Puas' : ($ratingStats['average_rating'] >= 5 ? 'Puas' : 'Kurang Puas');
                            $satisfactionColor = $ratingStats['average_rating'] >= 7 ? 'text-green-600' : ($ratingStats['average_rating'] >= 5 ? 'text-yellow-600' : 'text-red-600');
                        @endphp
                        <div class="text-2xl font-bold {{ $satisfactionColor }} mb-2">{{ $satisfactionRate }}</div>
                        <div class="text-sm text-gray-600">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Detailed Answers -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Jawaban Detail</h2>
            <p class="text-gray-600 text-sm mt-1">Semua jawaban yang diberikan mahasiswa</p>
        </div>

        <div class="p-6">
            @if($feedbackResponse->answers->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-question-circle text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600">Tidak ada jawaban yang tersedia.</p>
                </div>
            @else
                <div class="space-y-8">
                    <!-- Rating Questions -->
                    @if($groupedAnswers->has('rating'))
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-star text-yellow-500 mr-2"></i>
                                Pertanyaan Rating
                            </h3>
                            <div class="space-y-4">
                                @foreach($groupedAnswers['rating'] as $answer)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex justify-between items-start mb-3">
                                            <h4 class="font-medium text-gray-900 flex-1">{{ $answer->question->question_text }}</h4>
                                            <div class="flex items-center space-x-2 ml-4">
                                                <div class="flex items-center">
                                                    @for($i = 1; $i <= 10; $i++)
                                                        <div class="w-3 h-3 mx-0.5 rounded {{ $i <= $answer->rating_value ? 'bg-blue-500' : 'bg-gray-300' }}"></div>
                                                    @endfor
                                                </div>
                                                <span class="text-lg font-bold text-blue-600">{{ $answer->rating_value }}/10</span>
                                            </div>
                                        </div>
                                        @if($answer->question->description)
                                            <p class="text-sm text-gray-600">{{ $answer->question->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Text Questions -->
                    @if($groupedAnswers->has('text'))
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-align-left text-blue-500 mr-2"></i>
                                Pertanyaan Teks
                            </h3>
                            <div class="space-y-4">
                                @foreach($groupedAnswers['text'] as $answer)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-900 mb-3">{{ $answer->question->question_text }}</h4>
                                        @if($answer->question->description)
                                            <p class="text-sm text-gray-600 mb-3">{{ $answer->question->description }}</p>
                                        @endif
                                        <div class="bg-gray-50 rounded-lg p-4">
                                            <p class="text-gray-700 whitespace-pre-line">{{ $answer->answer_text ?: 'Tidak ada jawaban' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Multiple Choice Questions -->
                    @if($groupedAnswers->has('multiple_choice'))
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-list text-green-500 mr-2"></i>
                                Pertanyaan Pilihan Ganda
                            </h3>
                            <div class="space-y-4">
                                @foreach($groupedAnswers['multiple_choice'] as $answer)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="font-medium text-gray-900 mb-3">{{ $answer->question->question_text }}</h4>
                                        @if($answer->question->description)
                                            <p class="text-sm text-gray-600 mb-3">{{ $answer->question->description }}</p>
                                        @endif
                                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                            <p class="text-blue-800 font-medium">{{ $answer->answer_text ?: 'Tidak ada jawaban' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Other Question Types -->
                    @foreach($groupedAnswers as $type => $answers)
                        @if(!in_array($type, ['rating', 'text', 'multiple_choice']))
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-question text-gray-500 mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                                </h3>
                                <div class="space-y-4">
                                    @foreach($answers as $answer)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <h4 class="font-medium text-gray-900 mb-3">{{ $answer->question->question_text }}</h4>
                                            @if($answer->question->description)
                                                <p class="text-sm text-gray-600 mb-3">{{ $answer->question->description }}</p>
                                            @endif
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                @if($answer->rating_value)
                                                    <p class="text-gray-700">Rating: {{ $answer->rating_value }}</p>
                                                @endif
                                                @if($answer->answer_text)
                                                    <p class="text-gray-700 whitespace-pre-line">{{ $answer->answer_text }}</p>
                                                @endif
                                                @if(!$answer->rating_value && !$answer->answer_text)
                                                    <p class="text-gray-500 italic">Tidak ada jawaban</p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('dosen.feedback-mahasiswa.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
        
        <div class="flex space-x-3">
            <button onclick="printFeedback()" 
                    class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                <i class="fas fa-print mr-2"></i>
                Print Feedback
            </button>
        </div>
    </div>
</div>

<script>
function printFeedback() {
    window.print();
}
</script>

<style>
@media print {
    #mainContent {
        margin-left: 0 !important;
        padding-top: 0 !important;
    }
    
    .no-print {
        display: none !important;
    }
}
</style>
@endsection
