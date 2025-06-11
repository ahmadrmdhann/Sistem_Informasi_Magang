@extends('layouts.dashboard')

@section('title')
    <title>Detail Respons Feedback</title>
@endsection

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <div class="flex items-center mb-2">
                <a href="{{ route('admin.feedback.responses') }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 mr-4">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Daftar
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Detail Respons Feedback</h2>
            </div>
            <p class="text-gray-600">Respons dari {{ $response->mahasiswa->user->nama }}</p>
        </div>
        <button onclick="window.print()" 
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
            <i class="fas fa-print mr-2"></i>Cetak
        </button>
    </div>

    <!-- Student Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Mahasiswa</h3>
        
        <div class="flex items-center mb-4">
            @if($response->mahasiswa->foto_profil)
                <img class="h-16 w-16 rounded-full object-cover border-2 border-blue-300" 
                     src="{{ asset($response->mahasiswa->foto_profil) }}" 
                     alt="Profile">
            @else
                <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center border-2 border-blue-300">
                    <i class="fas fa-user text-white text-xl"></i>
                </div>
            @endif
            <div class="ml-4">
                <h4 class="font-semibold text-gray-800">{{ $response->mahasiswa->user->nama }}</h4>
                <p class="text-gray-600">{{ $response->mahasiswa->nim }}</p>
                <p class="text-gray-500 text-sm">{{ $response->mahasiswa->prodi->prodi_nama ?? '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Form Feedback</label>
                <p class="text-gray-900">{{ $response->form->title }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Submit</label>
                <p class="text-gray-900">{{ $response->submitted_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status Kelengkapan</label>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                           {{ $response->isComplete() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    <i class="fas {{ $response->isComplete() ? 'fa-check-circle' : 'fa-exclamation-triangle' }} mr-1"></i>
                    {{ $response->isComplete() ? 'Lengkap' : 'Tidak Lengkap' }}
                </span>
            </div>
        </div>

        @if($response->pengajuan)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <h4 class="font-medium text-gray-800 mb-2">Informasi Magang</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Perusahaan</label>
                        <p class="text-gray-900">{{ $response->company_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Posisi</label>
                        <p class="text-gray-900">{{ $response->position_title }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Response Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-question-circle text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pertanyaan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $response->form->questions->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Dijawab</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $response->total_answers }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-percentage text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Kelengkapan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $response->completion_percentage }}%</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-star text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Rata-rata Rating</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $response->average_rating ? number_format($response->average_rating, 1) . '/10' : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Answers -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-6">Jawaban Detail</h3>
        
        <div class="space-y-6">
            @foreach($response->form->questions as $question)
                @php
                    $answer = $response->answers->where('question_id', $question->question_id)->first();
                @endphp
                
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-2">
                                Pertanyaan {{ $loop->iteration }}
                                @if($question->is_required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </h4>
                            <p class="text-gray-700">{{ $question->question_text }}</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ml-4
                                   {{ $question->question_type === 'rating' ? 'bg-yellow-100 text-yellow-800' : 
                                      ($question->question_type === 'text' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                            @if($question->question_type === 'rating')
                                <i class="fas fa-star mr-1"></i>Rating
                            @elseif($question->question_type === 'text')
                                <i class="fas fa-align-left mr-1"></i>Teks
                            @else
                                <i class="fas fa-list mr-1"></i>Pilihan
                            @endif
                        </span>
                    </div>
                    
                    <div class="mt-3 p-3 bg-gray-50 rounded-md">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jawaban:</label>
                        @if($answer && $answer->hasValue())
                            @if($question->question_type === 'rating')
                                <div class="flex items-center">
                                    <div class="flex items-center mr-4">
                                        @for($i = 1; $i <= 10; $i++)
                                            <i class="fas fa-star text-lg {{ $i <= $answer->rating_value ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-lg font-semibold text-gray-900">
                                        {{ $answer->rating_value }}/10
                                    </span>
                                </div>
                            @else
                                <p class="text-gray-900">{{ $answer->answer_text }}</p>
                            @endif
                        @else
                            <p class="text-gray-400 italic">Tidak dijawab</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Print Styles -->
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
</div>
@endsection
