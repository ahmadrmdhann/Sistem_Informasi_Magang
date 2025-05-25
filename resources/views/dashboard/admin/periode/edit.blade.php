@extends('layouts.dashboard')

@section('title')
    <title>Edit Periode</title>
@endsection

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Edit Periode</h2>
        <form action="{{ route('periode.update', $periode->periode_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Periode</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2 focus:outline-blue-400" value="{{ old('nama', $periode->nama) }}" required>
                @error('nama') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="w-full border rounded px-3 py-2 focus:outline-blue-400" value="{{ old('tanggal_mulai', $periode->tanggal_mulai) }}" required>
                @error('tanggal_mulai') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Tanggal selesai</label>
                <input type="date" name="tanggal_selesai" class="w-full border rounded px-3 py-2 focus:outline-blue-400" value="{{ old('tanggal_selesai', $periode->tanggal_selesai) }}" required>
                @error('tanggal_selesai') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            </div>
            <div class="flex justify-end space-x-2 mt-6">
                <a href="{{ route('periode.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">Batal</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                    <i class="fas fa-save mr-1"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection