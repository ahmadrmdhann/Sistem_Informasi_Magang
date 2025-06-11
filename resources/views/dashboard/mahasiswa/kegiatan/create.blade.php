@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex items-center mb-4">
            <a href="{{ route('mahasiswa.kegiatan.index') }}" 
               class="text-blue-600 hover:text-blue-800 mr-4">
                <i class="fas fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tambah Kegiatan Magang</h1>
                <p class="text-gray-600 mt-1">Catat aktivitas harian magang Anda</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Informasi Kegiatan</h2>
            <p class="text-gray-600 text-sm mt-1">Isi detail kegiatan magang yang telah Anda lakukan</p>
        </div>

        <form action="{{ route('mahasiswa.kegiatan.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <!-- Internship Selection -->
            <div class="mb-6">
                <label for="pengajuan_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Pengalaman Magang <span class="text-red-500">*</span>
                </label>
                <select name="pengajuan_id" id="pengajuan_id" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pengajuan_id') border-red-500 @enderror" 
                        required>
                    <option value="">Pilih pengalaman magang</option>
                    @foreach($internships as $internship)
                        <option value="{{ $internship->id }}" {{ old('pengajuan_id', $selectedInternship) == $internship->id ? 'selected' : '' }}>
                            {{ $internship->lowongan->judul }} - {{ $internship->lowongan->partner->nama }}
                        </option>
                    @endforeach
                </select>
                @error('pengajuan_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Activity Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label for="activity_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="activity_date" id="activity_date" 
                           value="{{ old('activity_date') }}"
                           max="{{ date('Y-m-d') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('activity_date') border-red-500 @enderror" 
                           required>
                    @error('activity_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Mulai
                    </label>
                    <input type="time" name="start_time" id="start_time" 
                           value="{{ old('start_time') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_time') border-red-500 @enderror">
                    @error('start_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                        Waktu Selesai
                    </label>
                    <input type="time" name="end_time" id="end_time" 
                           value="{{ old('end_time') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_time') border-red-500 @enderror">
                    @error('end_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Activity Title -->
            <div class="mb-6">
                <label for="activity_title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul Kegiatan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="activity_title" id="activity_title" 
                       value="{{ old('activity_title') }}"
                       placeholder="Contoh: Menganalisis data penjualan bulan ini"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('activity_title') border-red-500 @enderror" 
                       required>
                @error('activity_title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Activity Description -->
            <div class="mb-6">
                <label for="activity_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Kegiatan <span class="text-red-500">*</span>
                </label>
                <textarea name="activity_description" id="activity_description" rows="5"
                          placeholder="Jelaskan secara detail kegiatan yang Anda lakukan, langkah-langkah yang diambil, dan hasil yang dicapai (minimal 50 karakter)"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('activity_description') border-red-500 @enderror" 
                          required>{{ old('activity_description') }}</textarea>
                <div class="flex justify-between items-center mt-1">
                    @error('activity_description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @else
                        <p class="text-gray-500 text-sm">Minimal 50 karakter</p>
                    @enderror
                    <span id="charCount" class="text-gray-500 text-sm">0 karakter</span>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div class="mb-6">
                <label for="learning_objectives" class="block text-sm font-medium text-gray-700 mb-2">
                    Tujuan Pembelajaran yang Dicapai
                </label>
                <textarea name="learning_objectives" id="learning_objectives" rows="3"
                          placeholder="Apa yang Anda pelajari dari kegiatan ini? Keterampilan atau pengetahuan apa yang Anda dapatkan?"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('learning_objectives') border-red-500 @enderror">{{ old('learning_objectives') }}</textarea>
                @error('learning_objectives')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Challenges Faced -->
            <div class="mb-6">
                <label for="challenges_faced" class="block text-sm font-medium text-gray-700 mb-2">
                    Tantangan yang Dihadapi
                </label>
                <textarea name="challenges_faced" id="challenges_faced" rows="3"
                          placeholder="Kesulitan atau hambatan apa yang Anda hadapi selama melakukan kegiatan ini?"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('challenges_faced') border-red-500 @enderror">{{ old('challenges_faced') }}</textarea>
                @error('challenges_faced')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Solutions Applied -->
            <div class="mb-6">
                <label for="solutions_applied" class="block text-sm font-medium text-gray-700 mb-2">
                    Solusi yang Diterapkan
                </label>
                <textarea name="solutions_applied" id="solutions_applied" rows="3"
                          placeholder="Bagaimana Anda mengatasi tantangan tersebut? Solusi apa yang Anda terapkan?"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('solutions_applied') border-red-500 @enderror">{{ old('solutions_applied') }}</textarea>
                @error('solutions_applied')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Weekly Summary Option -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_weekly_summary" id="is_weekly_summary" value="1" 
                           {{ old('is_weekly_summary') ? 'checked' : '' }}
                           class="mr-3 text-blue-600 focus:ring-blue-500">
                    <label for="is_weekly_summary" class="text-sm font-medium text-gray-700">
                        Ini adalah ringkasan kegiatan mingguan
                    </label>
                </div>
                
                <div id="weeklyDates" class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4" style="display: none;">
                    <div>
                        <label for="week_start_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Mulai Minggu
                        </label>
                        <input type="date" name="week_start_date" id="week_start_date" 
                               value="{{ old('week_start_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('week_start_date') border-red-500 @enderror">
                        @error('week_start_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="week_end_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Akhir Minggu
                        </label>
                        <input type="date" name="week_end_date" id="week_end_date" 
                               value="{{ old('week_end_date') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('week_end_date') border-red-500 @enderror">
                        @error('week_end_date')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- File Attachments -->
            <div class="mb-6">
                <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">
                    Lampiran File (Opsional)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                    <input type="file" name="attachments[]" id="attachments" multiple 
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                           class="hidden">
                    <label for="attachments" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600">Klik untuk memilih file atau drag & drop</p>
                        <p class="text-gray-500 text-sm mt-1">
                            Format yang didukung: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX (Maks. 10MB per file)
                        </p>
                    </label>
                </div>
                <div id="fileList" class="mt-3"></div>
                @error('attachments.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('mahasiswa.kegiatan.index') }}" 
                   class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                
                <button type="submit" 
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Kegiatan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Character counter for description
    $('#activity_description').on('input', function() {
        const length = $(this).val().length;
        $('#charCount').text(length + ' karakter');

        if (length < 50) {
            $('#charCount').removeClass('text-green-500').addClass('text-red-500');
        } else {
            $('#charCount').removeClass('text-red-500').addClass('text-green-500');
        }
    });

    // Weekly summary toggle
    $('#is_weekly_summary').on('change', function() {
        if ($(this).is(':checked')) {
            $('#weeklyDates').show();
            $('#week_start_date, #week_end_date').prop('required', true);
        } else {
            $('#weeklyDates').hide();
            $('#week_start_date, #week_end_date').prop('required', false);
        }
    });

    // File upload handling
    $('#attachments').on('change', function() {
        const files = this.files;
        const fileList = $('#fileList');
        fileList.empty();

        if (files.length > 0) {
            const listHtml = '<div class="mt-3"><h4 class="text-sm font-medium text-gray-700 mb-2">File yang dipilih:</h4><ul class="space-y-1">';
            let listItems = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                const fileIcon = getFileIcon(file.name);

                listItems += `
                    <li class="flex items-center text-sm text-gray-600">
                        <i class="fas ${fileIcon} mr-2 text-blue-500"></i>
                        <span class="flex-1">${file.name}</span>
                        <span class="text-gray-500">${fileSize} MB</span>
                    </li>
                `;
            }

            fileList.html(listHtml + listItems + '</ul></div>');
        }
    });

    // Drag and drop functionality
    const dropZone = $('.border-dashed');

    dropZone.on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('border-blue-400 bg-blue-50');
    });

    dropZone.on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('border-blue-400 bg-blue-50');
    });

    dropZone.on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('border-blue-400 bg-blue-50');

        const files = e.originalEvent.dataTransfer.files;
        $('#attachments')[0].files = files;
        $('#attachments').trigger('change');
    });

    // Initialize character counter
    $('#activity_description').trigger('input');

    // Initialize weekly summary state
    if ($('#is_weekly_summary').is(':checked')) {
        $('#weeklyDates').show();
    }
});

function getFileIcon(filename) {
    const extension = filename.split('.').pop().toLowerCase();

    switch (extension) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'fa-image';
        case 'pdf':
            return 'fa-file-pdf';
        case 'doc':
        case 'docx':
            return 'fa-file-word';
        case 'xls':
        case 'xlsx':
            return 'fa-file-excel';
        case 'ppt':
        case 'pptx':
            return 'fa-file-powerpoint';
        default:
            return 'fa-file';
    }
}
</script>
@endsection
