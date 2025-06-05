<!-- @extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Level</h2>
            <a href="{{ route('level.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('level.update', $level->level_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="level_kode" class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Level <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-3 py-2 border rounded-md @error('level_kode') border-red-500 @enderror"
                        id="level_kode" name="level_kode" value="{{ old('level_kode', $level->level_kode) }}"
                        placeholder="Masukkan kode level" required>
                    @error('level_kode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="level_nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Level <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-3 py-2 border rounded-md @error('level_nama') border-red-500 @enderror"
                        id="level_nama" name="level_nama" value="{{ old('level_nama', $level->level_nama) }}"
                        placeholder="Masukkan nama level" required>
                    @error('level_nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium">
                        <i class="fas fa-save mr-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Dinamiskan mainContent dengan sidebar jika ingin collapse/expand
        document.addEventListener('DOMContentLoaded', function () {
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            if (sidebarToggle && sidebar && mainContent) {
                sidebarToggle.addEventListener('click', function () {
                    setTimeout(function() {
                        if (sidebar.classList.contains('sidebar-collapsed')) {
                            mainContent.classList.remove('ml-64');
                        } else {
                            mainContent.classList.add('ml-64');
                        }
                    }, 100);
                });
            }
        });
    </script>
@endsection -->
