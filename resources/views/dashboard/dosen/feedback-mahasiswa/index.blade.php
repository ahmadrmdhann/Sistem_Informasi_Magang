@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Feedback Mahasiswa</h1>
                <p class="text-gray-600 mt-1">Lihat dan analisis feedback dari mahasiswa bimbingan setelah menyelesaikan magang</p>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('dosen.feedback-mahasiswa.analytics') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-chart-line mr-2"></i>
                    Analytics
                </a>
                <button onclick="exportFeedback()" 
                        class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-download mr-2"></i>
                    Export Data
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-comments text-blue-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Total Feedback</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_responses'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-user-graduate text-green-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Mahasiswa Bimbingan</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_students'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-building text-purple-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Perusahaan Partner</p>
                    <p class="text-xl font-semibold text-gray-900">{{ $stats['total_partners'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <i class="fas fa-star text-yellow-500 text-2xl mr-3"></i>
                <div>
                    <p class="text-sm text-gray-600">Rata-rata Rating</p>
                    <p class="text-xl font-semibold text-gray-900">
                        @if($stats['avg_rating'])
                            {{ number_format($stats['avg_rating'], 1) }}/10
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Filter Feedback</h2>
        
        <form method="GET" action="{{ route('dosen.feedback-mahasiswa.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
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
                <label for="partner_id" class="block text-sm font-medium text-gray-700 mb-2">Perusahaan</label>
                <select name="partner_id" id="partner_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Perusahaan</option>
                    @foreach($partners as $partner)
                        <option value="{{ $partner->partner_id }}" {{ $partnerFilter == $partner->partner_id ? 'selected' : '' }}>
                            {{ $partner->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="form_id" class="block text-sm font-medium text-gray-700 mb-2">Form Feedback</label>
                <select name="form_id" id="form_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Form</option>
                    @foreach($feedbackForms as $form)
                        <option value="{{ $form->form_id }}" {{ $formFilter == $form->form_id ? 'selected' : '' }}>
                            {{ $form->title }}
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
            
            <div class="md:col-span-5 flex space-x-3">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('dosen.feedback-mahasiswa.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-times mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Feedback List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Feedback Mahasiswa</h2>
            <p class="text-gray-600 text-sm mt-1">Feedback yang telah dikirim oleh mahasiswa bimbingan</p>
        </div>

        <div class="p-6">
            @if($feedbackResponses->isEmpty())
                <div class="text-center py-12">
                    <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Feedback</h3>
                    <p class="text-gray-600">Belum ada feedback yang dikirim oleh mahasiswa bimbingan dengan filter yang dipilih.</p>
                </div>
            @else
                <!-- Feedback Cards -->
                <div class="space-y-4">
                    @foreach($feedbackResponses as $response)
                        <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $response->mahasiswa->user->nama }}</h3>
                                            <p class="text-sm text-gray-600">{{ $response->mahasiswa->user->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Form:</span>
                                            <span class="font-medium text-blue-600">{{ $response->form->title }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Perusahaan:</span>
                                            <span class="font-medium">{{ $response->pengajuan->lowongan->partner->nama }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Tanggal Submit:</span>
                                            <span class="font-medium">{{ $response->submitted_at->format('d/m/Y H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col items-end space-y-2">
                                    @php
                                        $avgRating = $response->answers->whereNotNull('rating_value')->avg('rating_value');
                                    @endphp
                                    @if($avgRating)
                                        <div class="flex items-center space-x-1">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            <span class="font-medium">{{ number_format($avgRating, 1) }}/10</span>
                                        </div>
                                    @endif
                                    
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Completed
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Quick Stats -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-gray-900">{{ $response->answers->count() }}</div>
                                    <div class="text-xs text-gray-600">Total Jawaban</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-blue-600">{{ $response->answers->whereNotNull('rating_value')->count() }}</div>
                                    <div class="text-xs text-gray-600">Rating Questions</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-semibold text-green-600">{{ $response->answers->whereNotNull('answer_text')->count() }}</div>
                                    <div class="text-xs text-gray-600">Text Questions</div>
                                </div>
                                <div class="text-center">
                                    @if($avgRating)
                                        <div class="text-lg font-semibold text-yellow-600">{{ number_format($avgRating, 1) }}</div>
                                        <div class="text-xs text-gray-600">Avg Rating</div>
                                    @else
                                        <div class="text-lg font-semibold text-gray-400">-</div>
                                        <div class="text-xs text-gray-600">No Ratings</div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-500">
                                    Form: {{ $response->form->title }}
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('dosen.feedback-mahasiswa.show', $response->response_id) }}" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white text-sm rounded-lg transition-colors">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $feedbackResponses->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function exportFeedback() {
    // Get current filter parameters
    const params = new URLSearchParams();
    
    const mahasiswaId = document.getElementById('mahasiswa_id').value;
    const partnerId = document.getElementById('partner_id').value;
    const formId = document.getElementById('form_id').value;
    const dateFrom = document.getElementById('date_from').value;
    const dateTo = document.getElementById('date_to').value;
    
    if (mahasiswaId) params.append('mahasiswa_id', mahasiswaId);
    if (partnerId) params.append('partner_id', partnerId);
    if (formId) params.append('form_id', formId);
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);
    
    // Create download link
    const exportUrl = '{{ route("dosen.feedback-mahasiswa.export") }}' + '?' + params.toString();
    window.location.href = exportUrl;
}
</script>
@endsection
