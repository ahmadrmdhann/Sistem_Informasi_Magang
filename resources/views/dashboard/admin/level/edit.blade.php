@extends('layouts.dashboard')

@section('content')
    <div class="p-6 w-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Level</h2>
            <a href="{{ route('level.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('level.update', $level->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama_level" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Level <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                        class="w-full px-3 py-2 border rounded-md @error('nama_level') border-red-500 @enderror"
                        id="nama_level" name="nama_level" value="{{ old('nama_level', $level->nama_level) }}"
                        placeholder="Masukkan nama level" required>
                    @error('nama_level')
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
