@extends('layouts.dashboard')

@section('title')
    <title>Tambah Periode</title>
@endsection

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Tambah Periode</h2>
        <form action="{{ route('periode.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Periode</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2 focus:outline-blue-400" value="{{ old('nama') }}" required>
                @error('nama') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="w-full border rounded px-3 py-2 focus:outline-blue-400" value="{{ old('tanggal_mulai') }}" required>
                @error('tanggal_mulai') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="w-full border rounded px-3 py-2 focus:outline-blue-400" value="{{ old('tanggal_seleasi') }}" required>
                @error('tanggal_selesai') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                <a href="{{ route('periode.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                    <i class="fas fa-save mr-1"></i>Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection