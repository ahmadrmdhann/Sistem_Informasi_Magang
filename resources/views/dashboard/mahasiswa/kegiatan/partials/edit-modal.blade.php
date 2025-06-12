{{-- Edit Activity Modal Content --}}
<div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-y-auto">
    {{-- Modal Header --}}
    <div class="flex justify-between items-center p-6 border-b border-gray-200">
        <div>
            <h3 class="text-xl font-semibold text-gray-800">Edit Kegiatan Magang</h3>
            <p class="text-sm text-gray-600 mt-1">Perbarui informasi aktivitas magang Anda</p>
        </div>
        <button type="button" id="closeEditModal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">
            &times;
        </button>
    </div>

    {{-- Modal Body --}}
    <form id="editActivityForm" action="{{ route('mahasiswa.kegiatan.update', $activity->activity_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6">
            {{-- Alert Container --}}
            <div id="editAlertContainer" class="mb-4"></div>

            {{-- Basic Information --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <h4 class="font-semibold text-gray-800 mb-4">Informasi Dasar</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Activity Date --}}
                    <div>
                        <label for="edit_activity_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="activity_date" id="edit_activity_date" 
                            value="{{ $activity->activity_date->format('Y-m-d') }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                        <div class="text-red-500 text-sm mt-1 hidden" id="edit_activity_date_error"></div>
                    </div>

                    {{-- Activity Title --}}
                    <div>
                        <label for="edit_activity_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="activity_title" id="edit_activity_title" 
                            value="{{ $activity->activity_title }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required maxlength="255">
                        <div class="text-red-500 text-sm mt-1 hidden" id="edit_activity_title_error"></div>
                    </div>

                    {{-- Start Time --}}
                    <div>
                        <label for="edit_start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Mulai
                        </label>
                        <input type="time" name="start_time" id="edit_start_time" 
                            value="{{ $activity->start_time ? $activity->start_time->format('H:i') : '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="text-red-500 text-sm mt-1 hidden" id="edit_start_time_error"></div>
                    </div>

                    {{-- End Time --}}
                    <div>
                        <label for="edit_end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Selesai
                        </label>
                        <input type="time" name="end_time" id="edit_end_time" 
                            value="{{ $activity->end_time ? $activity->end_time->format('H:i') : '' }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div class="text-red-500 text-sm mt-1 hidden" id="edit_end_time_error"></div>
                    </div>
                </div>
            </div>

            {{-- Activity Description --}}
            <div class="mb-6">
                <label for="edit_activity_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi Kegiatan <span class="text-red-500">*</span>
                </label>
                <textarea name="activity_description" id="edit_activity_description" rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required minlength="50" placeholder="Jelaskan kegiatan yang dilakukan minimal 50 karakter...">{{ $activity->activity_description }}</textarea>
                <div class="text-sm text-gray-500 mt-1">
                    <span id="edit_description_count">{{ strlen($activity->activity_description) }}</span>/50 karakter minimum
                </div>
                <div class="text-red-500 text-sm mt-1 hidden" id="edit_activity_description_error"></div>
            </div>

            {{-- Learning Objectives --}}
            <div class="mb-6">
                <label for="edit_learning_objectives" class="block text-sm font-medium text-gray-700 mb-2">
                    Tujuan Pembelajaran
                </label>
                <textarea name="learning_objectives" id="edit_learning_objectives" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Apa yang ingin dicapai dari kegiatan ini...">{{ $activity->learning_objectives }}</textarea>
                <div class="text-red-500 text-sm mt-1 hidden" id="edit_learning_objectives_error"></div>
            </div>

            {{-- Challenges and Solutions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="edit_challenges_faced" class="block text-sm font-medium text-gray-700 mb-2">
                        Tantangan yang Dihadapi
                    </label>
                    <textarea name="challenges_faced" id="edit_challenges_faced" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Kendala atau kesulitan yang dihadapi...">{{ $activity->challenges_faced }}</textarea>
                    <div class="text-red-500 text-sm mt-1 hidden" id="edit_challenges_faced_error"></div>
                </div>

                <div>
                    <label for="edit_solutions_applied" class="block text-sm font-medium text-gray-700 mb-2">
                        Solusi yang Diterapkan
                    </label>
                    <textarea name="solutions_applied" id="edit_solutions_applied" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Cara mengatasi tantangan yang dihadapi...">{{ $activity->solutions_applied }}</textarea>
                    <div class="text-red-500 text-sm mt-1 hidden" id="edit_solutions_applied_error"></div>
                </div>
            </div>

            {{-- Weekly Summary --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex items-center mb-3">
                    <input type="checkbox" name="is_weekly_summary" id="edit_is_weekly_summary" 
                        value="1" {{ $activity->is_weekly_summary ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="edit_is_weekly_summary" class="ml-2 text-sm font-medium text-blue-800">
                        Ini adalah ringkasan mingguan
                    </label>
                </div>

                <div id="edit_weekly_summary_fields" class="{{ $activity->is_weekly_summary ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="edit_week_start_date" class="block text-sm font-medium text-blue-700 mb-2">
                                Tanggal Mulai Minggu
                            </label>
                            <input type="date" name="week_start_date" id="edit_week_start_date" 
                                value="{{ $activity->week_start_date ? $activity->week_start_date->format('Y-m-d') : '' }}"
                                class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="text-red-500 text-sm mt-1 hidden" id="edit_week_start_date_error"></div>
                        </div>

                        <div>
                            <label for="edit_week_end_date" class="block text-sm font-medium text-blue-700 mb-2">
                                Tanggal Akhir Minggu
                            </label>
                            <input type="date" name="week_end_date" id="edit_week_end_date" 
                                value="{{ $activity->week_end_date ? $activity->week_end_date->format('Y-m-d') : '' }}"
                                class="w-full px-3 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="text-red-500 text-sm mt-1 hidden" id="edit_week_end_date_error"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Current Attachments --}}
            @if($activity->attachments->isNotEmpty())
                <div class="mb-6">
                    <h4 class="font-semibold text-gray-800 mb-3">Lampiran Saat Ini</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($activity->attachments as $attachment)
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas {{ $attachment->file_type_icon }} text-xl {{ $attachment->file_type_color }}"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $attachment->original_filename }}</p>
                                            <p class="text-xs text-gray-500">{{ $attachment->formatted_file_size }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('mahasiswa.kegiatan.download-attachment', $attachment->attachment_id) }}"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <label class="flex items-center">
                                            <input type="checkbox" name="remove_attachments[]" 
                                                value="{{ $attachment->attachment_id }}"
                                                class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                            <span class="ml-1 text-xs text-red-600">Hapus</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- New Attachments --}}
            <div class="mb-6">
                <label for="edit_attachments" class="block text-sm font-medium text-gray-700 mb-2">
                    Tambah Lampiran Baru
                </label>
                <input type="file" name="attachments[]" id="edit_attachments" multiple
                    accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="text-sm text-gray-500 mt-1">
                    Format yang didukung: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX. Maksimal 10MB per file.
                </div>
                <div class="text-red-500 text-sm mt-1 hidden" id="edit_attachments_error"></div>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="flex justify-between items-center p-6 border-t border-gray-200 bg-gray-50">
            <button type="button" id="cancelEditBtn"
                class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                <i class="fas fa-times mr-2"></i>
                Batal
            </button>
            <button type="submit" id="saveEditBtn"
                class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                <i class="fas fa-save mr-2"></i>
                <span id="saveEditBtnText">Simpan Perubahan</span>
            </button>
        </div>
    </form>
</div>
