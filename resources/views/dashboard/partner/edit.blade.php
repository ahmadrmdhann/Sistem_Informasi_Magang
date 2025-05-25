@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Partner</h2>
            <a href="{{ route('partner.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('partner.update', $partner->partner_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Partner <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-3 py-2 border rounded-md @error('nama') border-red-500 @enderror"
                        id="nama" name="nama" value="{{ old('nama', $partner->nama) }}"
                        placeholder="Masukkan nama partner" required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email"
                        class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @enderror"
                        id="email" name="email" value="{{ old('email', $partner->email) }}"
                        placeholder="Masukkan email partner" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">
                        Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-3 py-2 border rounded-md @error('telepon') border-red-500 @enderror"
                        id="telepon" name="telepon" value="{{ old('telepon', $partner->telepon) }}"
                        placeholder="Masukkan nomor telepon partner" required>
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        class="w-full px-3 py-2 border rounded-md @error('alamat') border-red-500 @enderror"
                        id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat partner" required>{{ old('alamat', $partner->alamat) }}</textarea>
                    @error('alamat')
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
@endsection
