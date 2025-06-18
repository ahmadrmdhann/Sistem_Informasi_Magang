@extends('layouts.dashboard')

@section('title', 'Feedback Mahasiswa')

@section('content')
    <div id="mainContent" class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6 py-8">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-comments text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Feedback Mahasiswa</h1>
                            <p class="text-white/80">Lihat dan analisis feedback dari mahasiswa bimbingan</p>
                        </div>
                    </div>
                    <div class="flex space-x-4 mt-6">
                        <a href="{{ route('dosen.feedback-mahasiswa.analytics') }}"
                            class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white rounded-xl backdrop-blur-sm transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-chart-line mr-2"></i>
                            Analytics
                        </a>
                        <button onclick="exportFeedback()"
                            class="inline-flex items-center px-6 py-3 bg-white/20 hover:bg-white/30 text-white rounded-xl backdrop-blur-sm transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-download mr-2"></i>
                            Export Data
                        </button>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 text-white p-6 rounded-2xl mb-8 shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-2xl"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-gradient-to-r from-rose-400 to-rose-500 text-white p-6 rounded-2xl mb-8 shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-2xl"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Statistik Feedback</h2>
                    <p class="text-gray-600">Monitor dan analisis feedback mahasiswa bimbingan</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-comments text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $stats['total_responses'] }}</h3>
                                <p class="text-indigo-500 text-xs">Feedback</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-graduate text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $stats['total_students'] }}</h3>
                                <p class="text-emerald-500 text-xs">Mahasiswa</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h3 class="font-bold text-2xl text-gray-800">{{ $stats['total_partners'] }}</h3>
                                <p class="text-purple-500 text-xs">Perusahaan</p>
                            </div>
                        </div>
                    </div>

                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-star text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Rata-rata</p>
                                <h3 class="font-bold text-2xl text-gray-800">
                                    @if($stats['avg_rating'])
                                        {{ number_format($stats['avg_rating'], 1) }}
                                    @else
                                        -
                                    @endif
                                </h3>
                                <p class="text-amber-500 text-xs">Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100 mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Filter Feedback</h2>

                <form method="GET" action="{{ route('dosen.feedback-mahasiswa.index') }}"
                    class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label for="mahasiswa_id" class="block text-sm font-medium text-gray-600 mb-2">Mahasiswa</label>
                        <select name="mahasiswa_id" id="mahasiswa_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                            <option value="">Semua Mahasiswa</option>
                            @foreach($supervisedStudents as $student)
                                <option value="{{ $student->mahasiswa_id }}" {{ $mahasiswaFilter == $student->mahasiswa_id ? 'selected' : '' }}>
                                    {{ $student->user->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="partner_id" class="block text-sm font-medium text-gray-600 mb-2">Perusahaan</label>
                        <select name="partner_id" id="partner_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                            <option value="">Semua Perusahaan</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->partner_id }}" {{ $partnerFilter == $partner->partner_id ? 'selected' : '' }}>
                                    {{ $partner->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="form_id" class="block text-sm font-medium text-gray-600 mb-2">Form Feedback</label>
                        <select name="form_id" id="form_id"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                            <option value="">Semua Form</option>
                            @foreach($feedbackForms as $form)
                                <option value="{{ $form->form_id }}" {{ $formFilter == $form->form_id ? 'selected' : '' }}>
                                    {{ $form->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-600 mb-2">Dari Tanggal</label>
                        <input type="date" name="date_from" id="date_from" value="{{ $dateFrom }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-600 mb-2">Sampai Tanggal</label>
                        <input type="date" name="date_to" id="date_to" value="{{ $dateTo }}"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400">
                    </div>

                    <div class="md:col-span-5 flex space-x-3">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            Filter
                        </button>
                        <a href="{{ route('dosen.feedback-mahasiswa.index') }}"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Feedback List -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Daftar Feedback Mahasiswa</h2>
                            <p class="text-gray-600">Feedback yang telah dikirim oleh mahasiswa bimbingan</p>
                        </div>
                    </div>

                    @if($feedbackResponses->isEmpty())
                        <div class="text-center py-16">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-comments text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-500 mb-2">Belum Ada Feedback</h3>
                            <p class="text-gray-400">Belum ada feedback yang dikirim oleh mahasiswa bimbingan dengan filter yang dipilih.</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($feedbackResponses as $response)
                                <div class="bg-gradient-to-br from-indigo-50 to-blue-100 border border-indigo-200 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-4 mb-3">
                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                                    <i class="fas fa-user text-white text-lg"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-800">
                                                        {{ $response->mahasiswa->user->nama }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $response->mahasiswa->user->email }}</p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-600">Form:</span>
                                                    <span class="font-medium text-indigo-600">{{ $response->form->title }}</span>
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
                                                    <i class="fas fa-star text-amber-400"></i>
                                                    <span class="font-medium">{{ number_format($avgRating, 1) }}/10</span>
                                                </div>
                                            @endif

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Completed
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Quick Stats -->
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 bg-white rounded-xl border border-gray-200">
                                        <div class="text-center transform hover:scale-105 transition-transform duration-200">
                                            <div class="text-lg font-bold text-gray-800">{{ $response->answers->count() }}</div>
                                            <div class="text-sm text-gray-600">Total Jawaban</div>
                                        </div>
                                        <div class="text-center transform hover:scale-105 transition-transform duration-200">
                                            <div class="text-lg font-bold text-indigo-600">
                                                {{ $response->answers->whereNotNull('rating_value')->count() }}</div>
                                            <div class="text-sm text-gray-600">Rating Questions</div>
                                        </div>
                                        <div class="text-center transform hover:scale-105 transition-transform duration-200">
                                            <div class="text-lg font-bold text-emerald-600">
                                                {{ $response->answers->whereNotNull('answer_text')->count() }}</div>
                                            <div class="text-sm text-gray-600">Text Questions</div>
                                        </div>
                                        <div class="text-center transform hover:scale-105 transition-transform duration-200">
                                            @if($avgRating)
                                                <div class="text-lg font-bold text-amber-600">{{ number_format($avgRating, 1) }}</div>
                                                <div class="text-sm text-gray-600">Avg Rating</div>
                                            @else
                                                <div class="text-lg font-bold text-gray-400">-</div>
                                                <div class="text-sm text-gray-600">No Ratings</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex justify-end">
                                        <a href="{{ route('dosen.feedback-mahasiswa.show', $response->response_id) }}"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white text-sm rounded-xl font-medium transition-all duration-300 transform hover:scale-105 shadow-md">
                                            <i class="fas fa-eye mr-2"></i>
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $feedbackResponses->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportFeedback() {
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

            const exportUrl = '{{ route("dosen.feedback-mahasiswa.export") }}' + '?' + params.toString();
            window.location.href = exportUrl;
        }
    </script>
@endsection