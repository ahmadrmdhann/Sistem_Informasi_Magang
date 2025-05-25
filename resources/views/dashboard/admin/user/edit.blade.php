@extends('layouts.dashboard')

@section('content')
    <div id="mainContent"
        class="p-6 w-auto pt-[109px] md:pt-[61px] min-h-screen bg-gray-50 transition-all duration-300 ml-64">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit User</h2>
            <a href="{{ route('user.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('user.update', $user->user_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                        Username <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="username" id="username"
                        class="w-full px-3 py-2 border rounded-md @error('username') border-red-500 @enderror"
                        value="{{ old('username', $user->user_username) }}" required>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password <span class="text-gray-400">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password" id="password"
                        class="w-full px-3 py-2 border rounded-md @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password baru">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email"
                        class="w-full px-3 py-2 border rounded-md @error('email') border-red-500 @enderror"
                        value="{{ old('email', $user->user_email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama"
                        class="w-full px-3 py-2 border rounded-md @error('nama') border-red-500 @enderror"
                        value="{{ old('nama', $user->user_nama) }}" required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="level_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Level <span class="text-red-500">*</span>
                    </label>
                    <select name="level_id" id="level_id"
                        class="w-full px-3 py-2 border rounded-md @error('level_id') border-red-500 @enderror" required>
                        <option value="">Pilih Level</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->level_id }}" {{ old('level_id', $user->level_id) == $level->level_id ? 'selected' : '' }}>
                                {{ $level->level_nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('level_id')
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
@endsection
