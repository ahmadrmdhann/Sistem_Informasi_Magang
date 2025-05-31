@extends('layouts.dashboard')

@section('title')
    <title>Tambah Lowongan Magang</title>
@endsection

@section('content')
    <div id="mainContent"
        class="p-6 w-auto pt-[109px] md:pt-[61px] min-h-screen bg-gray-50 transition-all duration-300 ml-64">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Tambah Lowongan</h2>
            <a href="{{ route('lowongan.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('lowongan.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="partner_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Partner <span class="text-red-500">*</span>
                    </label>
                    <select name="partner_id" id="partner_id"
                        class="w-full px-3 py-2 border rounded-md @error('partner_id') border-red-500 @enderror" required>
                        <option value="">Pilih Partner</option>
                        @foreach($partners as $partner)
                            <option value="{{ $partner->partner_id }}" {{ old('partner_id') == $partner->partner_id ? 'selected' : '' }}>{{ $partner->nama }}</option>
                        @endforeach
                    </select>
                    @error('partner_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                        Judul <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" id="judul"
                        class="w-full px-3 py-2 border rounded-md @error('judul') border-red-500 @enderror"
                        value="{{ old('judul') }}" placeholder="Masukkan judul lowongan" required>
                    @error('judul')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi"
                        class="w-full px-3 py-2 border rounded-md @error('deskripsi') border-red-500 @enderror"
                        placeholder="Masukkan deskripsi lowongan" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="persyaratan" class="block text-sm font-medium text-gray-700 mb-1">
                        Persyaratan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="persyaratan" id="persyaratan"
                        class="w-full px-3 py-2 border rounded-md @error('persyaratan') border-red-500 @enderror"
                        placeholder="Masukkan persyaratan lowongan" required>{{ old('persyaratan') }}</textarea>
                    @error('persyaratan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <select name="lokasi" id="lokasi"
                    class="w-full px-3 py-2 border rounded-md @error('lokasi') border-red-500 @enderror" required>
                    <option value="">Pilih Lokasi</option>
                    @foreach($lokasis as $lokasi)
                        <option value="{{ $lokasi->kabupaten_id }}" {{ old('kabupaten_id') == $lokasi->kabupaten_id ? 'selected' : '' }}>
                            {{ $lokasi->nama }}</option>
                    @endforeach
                </select>

                <div class="mb-4">
                    <label for="bidang_keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                        Bidang Keahlian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bidang_keahlian" id="bidang_keahlian"
                        class="w-full px-3 py-2 border rounded-md @error('bidang_keahlian') border-red-500 @enderror"
                        value="{{ old('bidang_keahlian') }}" placeholder="Masukkan bidang keahlian" required>
                    @error('bidang_keahlian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Periode <span class="text-red-500">*</span>
                    </label>
                    <select name="periode_id" id="periode_id"
                        class="w-full px-3 py-2 border rounded-md @error('periode_id') border-red-500 @enderror" required>
                        <option value="">Pilih Periode</option>
                        @foreach($periodes as $periode)
                            <option value="{{ $periode->periode_id }}" {{ old('periode_id') == $periode->periode_id ? 'selected' : '' }}>{{ $periode->nama }}</option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_mulai') border-red-500 @enderror"
                        value="{{ old('tanggal_mulai') }}" required>
                    @error('tanggal_mulai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Akhir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                        class="w-full px-3 py-2 border rounded-md @error('tanggal_akhir') border-red-500 @enderror"
                        value="{{ old('tanggal_akhir') }}" required>
                    @error('tanggal_akhir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md font-medium">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection