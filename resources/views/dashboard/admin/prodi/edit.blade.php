@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Edit Program Studi</h2>
        <a href="{{ route('prodi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('prodi.update', $prodi->prodi_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="prodi_kode" class="block text-sm font-medium text-gray-700 mb-1">
                    Kode Program Studi <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       class="w-full px-3 py-2 border rounded-md @error('prodi_kode') border-red-500 @enderror" 
                       id="prodi_kode" 
                       name="prodi_kode" 
                       value="{{ old('prodi_kode', $prodi->prodi_kode) }}" 
                       placeholder="Masukkan kode program studi" 
                       required>
                @error('prodi_kode')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="prodi_nama" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Program Studi <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       class="w-full px-3 py-2 border rounded-md @error('prodi_nama') border-red-500 @enderror" 
                       id="prodi_nama" 
                       name="prodi_nama" 
                       value="{{ old('prodi_nama', $prodi->prodi_nama) }}" 
                       placeholder="Masukkan nama program studi" 
                       required>
                @error('prodi_nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium">
                    <i class="fas fa-save mr-2"></i>Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection