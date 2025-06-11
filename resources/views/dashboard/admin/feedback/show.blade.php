@extends('layouts.dashboard')

@section('title')
    <title>Detail Form Feedback</title>
@endsection

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Detail Form Feedback</h2>
            <p class="text-gray-600">{{ $form->title }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.feedback.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <a href="{{ route('admin.feedback.edit', $form->form_id) }}" 
               class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-edit mr-2"></i>Edit Form
            </a>
        </div>
    </div>

    <!-- Form Information -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Form</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium
                           {{ $form->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    <i class="fas {{ $form->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                    {{ $form->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Mulai</label>
                <p class="text-gray-900">{{ $form->start_date ? $form->start_date->format('d/m/Y') : 'Tidak ditentukan' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Berakhir</label>
                <p class="text-gray-900">{{ $form->end_date ? $form->end_date->format('d/m/Y') : 'Tidak ditentukan' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-500 mb-1">Dibuat</label>
                <p class="text-gray-900">{{ $form->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        @if($form->description)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-500 mb-1">Deskripsi</label>
                <p class="text-gray-900">{{ $form->description }}</p>
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-question-circle text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pertanyaan</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $form->questions->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-star text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pertanyaan Rating</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $form->questions->where('question_type', 'rating')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-comments text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Respons</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $form->total_responses }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-chart-line text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Rata-rata Rating</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $form->average_rating ? number_format($form->average_rating, 1) . '/10' : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions List -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Daftar Pertanyaan</h3>
            <span class="text-sm text-gray-500">{{ $form->questions->count() }} pertanyaan</span>
        </div>

        @if($form->questions->count() > 0)
            <div class="space-y-4">
                @foreach($form->questions as $question)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-gray-900">Pertanyaan {{ $loop->iteration }}</h4>
                            <div class="flex space-x-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                           {{ $question->question_type === 'rating' ? 'bg-yellow-100 text-yellow-800' : 
                                              ($question->question_type === 'text' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    @if($question->question_type === 'rating')
                                        <i class="fas fa-star mr-1"></i>Rating 1-10
                                    @elseif($question->question_type === 'text')
                                        <i class="fas fa-align-left mr-1"></i>Teks Bebas
                                    @else
                                        <i class="fas fa-list mr-1"></i>Pilihan Ganda
                                    @endif
                                </span>
                                @if($question->is_required)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-asterisk mr-1"></i>Wajib
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <p class="text-gray-700 mb-3">{{ $question->question_text }}</p>
                        
                        @if($question->question_type === 'multiple_choice' && $question->options)
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-500 mb-1">Pilihan Jawaban:</p>
                                <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                    @foreach($question->options as $option)
                                        <li>{{ $option }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($question->question_type === 'rating' && $question->average_rating)
                            <div class="mt-2 flex items-center">
                                <span class="text-sm text-gray-500 mr-2">Rata-rata rating:</span>
                                <span class="font-medium text-yellow-600">{{ $question->average_rating }}/10</span>
                                <span class="text-sm text-gray-500 ml-2">({{ $question->total_answers }} respons)</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-question-circle text-4xl text-gray-300 mb-4"></i>
                <p class="text-lg font-medium">Belum ada pertanyaan</p>
                <p class="text-sm">Form ini belum memiliki pertanyaan</p>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="flex flex-wrap gap-3">
            @if($form->total_responses > 0)
                <a href="{{ route('admin.feedback.responses') }}?form_id={{ $form->form_id }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-list mr-2"></i>Lihat Respons ({{ $form->total_responses }})
                </a>
            @endif
            
            <a href="{{ route('admin.feedback.edit', $form->form_id) }}" 
               class="inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors">
                <i class="fas fa-edit mr-2"></i>Edit Form
            </a>
            
            <form action="{{ route('admin.feedback.toggle-status', $form->form_id) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 rounded-lg transition-colors
                               {{ $form->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white">
                    <i class="fas {{ $form->is_active ? 'fa-pause' : 'fa-play' }} mr-2"></i>
                    {{ $form->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
