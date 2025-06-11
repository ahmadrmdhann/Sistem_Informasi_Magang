@extends('layouts.dashboard')

@section('title')
    <title>Respons Feedback Mahasiswa</title>
@endsection

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Respons Feedback Mahasiswa</h2>
            <p class="text-gray-600">Lihat dan analisis feedback dari mahasiswa</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.feedback.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Respons</h3>
        <form method="GET" action="{{ route('admin.feedback.responses') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="form_id" class="block text-sm font-medium text-gray-700 mb-2">Form Feedback</label>
                <select name="form_id" id="form_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Form</option>
                    @foreach($forms as $form)
                        <option value="{{ $form->form_id }}" {{ request('form_id') == $form->form_id ? 'selected' : '' }}>
                            {{ $form->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Mahasiswa</label>
                <input type="text" name="search" id="search" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nama atau NIM mahasiswa" value="{{ request('search') }}">
            </div>

            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-comments text-2xl text-blue-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Respons</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $responses->total() }}</p>
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
                        @php
                            $avgRating = $responses->avg('average_rating');
                        @endphp
                        {{ $avgRating ? number_format($avgRating, 1) . '/10' : 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-calendar text-2xl text-green-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Hari Ini</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $responses->where('submitted_at', '>=', now()->startOfDay())->count() }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-users text-2xl text-purple-500"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Mahasiswa Unik</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $responses->unique('mahasiswa_id')->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Responses List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($responses->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Mahasiswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Form Feedback
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Program Studi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Tanggal Submit
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Rata-rata Rating
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($responses as $response)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($response->mahasiswa->foto_profil)
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ asset($response->mahasiswa->foto_profil) }}" 
                                                 alt="Profile">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $response->mahasiswa->user->nama }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $response->mahasiswa->nim }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $response->form->title }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $response->total_answers }} dari {{ $response->form->questions->count() }} pertanyaan
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $response->mahasiswa->prodi->prodi_nama ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $response->submitted_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($response->average_rating)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                   {{ $response->average_rating >= 8 ? 'bg-green-100 text-green-800' : 
                                                      ($response->average_rating >= 6 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            <i class="fas fa-star mr-1"></i>
                                            {{ number_format($response->average_rating, 1) }}/10
                                        </span>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('admin.feedback.response-detail', $response->response_id) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $responses->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-comments text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada respons feedback</h3>
                <p class="text-gray-500">
                    @if(request()->hasAny(['form_id', 'search']))
                        Tidak ada respons yang sesuai dengan filter yang dipilih.
                    @else
                        Mahasiswa belum memberikan feedback untuk form yang tersedia.
                    @endif
                </p>
                @if(request()->hasAny(['form_id', 'search']))
                    <div class="mt-4">
                        <a href="{{ route('admin.feedback.responses') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <i class="fas fa-refresh mr-2"></i>Reset Filter
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
