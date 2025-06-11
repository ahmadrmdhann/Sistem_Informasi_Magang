@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('mahasiswa.feedback.index') }}" 
               class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Feedback Terkirim</h1>
                <p class="text-gray-600 mt-1">Detail feedback yang telah Anda kirim</p>
            </div>
        </div>
    </div>

    <!-- Response Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Feedback</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-700 mb-2">Form Feedback</h3>
                <p class="text-gray-900 text-lg">{{ $response->form->title }}</p>
                @if($response->form->description)
                    <p class="text-gray-600 text-sm mt-1">{{ $response->form->description }}</p>
                @endif
            </div>
            
            <div>
                <h3 class="font-medium text-gray-700 mb-2">Pengalaman Magang</h3>
                <p class="text-gray-900">{{ $response->pengajuan->lowongan->judul }}</p>
                <p class="text-gray-600 text-sm">{{ $response->pengajuan->lowongan->partner->nama }}</p>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="flex items-center p-3 bg-green-50 rounded-lg">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <p class="font-medium text-green-700">Terkirim</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-blue-50 rounded-lg">
                    <i class="fas fa-calendar text-blue-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Kirim</p>
                        <p class="font-medium">{{ $response->submitted_at->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-purple-50 rounded-lg">
                    <i class="fas fa-clock text-purple-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Waktu Kirim</p>
                        <p class="font-medium">{{ $response->submitted_at->format('H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center p-3 bg-yellow-50 rounded-lg">
                    <i class="fas fa-star text-yellow-500 mr-3"></i>
                    <div>
                        <p class="text-sm text-gray-600">Rata-rata Rating</p>
                        <p class="font-medium">{{ $response->average_rating ? number_format($response->average_rating, 1) . '/10' : 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Answers -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Jawaban Anda</h2>
            <p class="text-gray-600 text-sm mt-1">Berikut adalah jawaban yang telah Anda berikan</p>
        </div>

        <div class="p-6">
            <div class="space-y-6">
                @foreach($response->form->questions as $index => $question)
                    @php
                        $answer = $response->answers->where('question_id', $question->question_id)->first();
                    @endphp
                    
                    <div class="question-item border border-gray-200 rounded-lg p-4">
                        <div class="mb-3">
                            <h3 class="text-sm font-medium text-blue-600 mb-2">
                                Pertanyaan {{ $index + 1 }}
                                @if($question->is_required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </h3>
                            <p class="text-gray-800 mb-3">{{ $question->question_text }}</p>
                        </div>

                        <div class="answer-section">
                            @if($question->question_type === 'rating')
                                <!-- Rating Answer -->
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm text-gray-600">Rating:</span>
                                    <div class="flex items-center space-x-1">
                                        <span class="inline-flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-lg font-semibold">
                                            {{ $answer ? $answer->rating_value : 'N/A' }}
                                        </span>
                                        <span class="text-gray-500">/10</span>
                                    </div>
                                    @if($answer && $answer->rating_value)
                                        <div class="flex space-x-1">
                                            @for($i = 1; $i <= 10; $i++)
                                                <div class="w-3 h-3 rounded-full {{ $i <= $answer->rating_value ? 'bg-yellow-400' : 'bg-gray-200' }}"></div>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                            @elseif($question->question_type === 'text')
                                <!-- Text Answer -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-800">{{ $answer ? $answer->answer_text : 'Tidak dijawab' }}</p>
                                </div>
                            @elseif($question->question_type === 'multiple_choice')
                                <!-- Multiple Choice Answer -->
                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full border-2 mr-3 {{ $answer && $answer->answer_text === $option ? 'bg-blue-500 border-blue-500' : 'border-gray-300' }}">
                                                @if($answer && $answer->answer_text === $option)
                                                    <div class="w-2 h-2 bg-white rounded-full mx-auto mt-0.5"></div>
                                                @endif
                                            </div>
                                            <span class="text-gray-700 {{ $answer && $answer->answer_text === $option ? 'font-medium' : '' }}">
                                                {{ $option }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="p-6 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <a href="{{ route('mahasiswa.feedback.index') }}" 
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
                
                <div class="text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Feedback ini telah dikirim dan tidak dapat diubah
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
