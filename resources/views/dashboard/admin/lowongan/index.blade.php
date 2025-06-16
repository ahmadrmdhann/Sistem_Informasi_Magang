@extends('layouts.dashboard')

@section('title')
    <title>Manajemen Lowongan</title>
@endsection

@section('content')
    <div id="mainContent" class="transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="container mx-auto px-6 py-8">
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 rounded-3xl p-8 mb-8 overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-10 rounded-full -mr-48 -mt-48"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-10 rounded-full -ml-32 -mb-32"></div>
                <div class="relative z-10">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mr-4 backdrop-blur-sm">
                            <i class="fas fa-briefcase text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">Manajemen Lowongan</h1>
                            <p class="text-white/80">Kelola informasi lowongan magang dalam sistem</p>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-2xl mb-6 shadow-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-2xl mr-4"></i>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="mb-12">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Statistik Lowongan</h3>
                    <p class="text-gray-600">Overview data lowongan dalam sistem</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Total Lowongan -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-briefcase text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $lowongans->count() }}</h4>
                                <p class="text-blue-500 text-xs">Lowongan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lowongan Aktif -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-check-circle text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Status</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $lowongans->filter(function($lowongan) {
                                    $now = \Carbon\Carbon::now();
                                    $startDate = \Carbon\Carbon::parse($lowongan->tanggal_mulai);
                                    $endDate = \Carbon\Carbon::parse($lowongan->tanggal_akhir);
                                    return $now->between($startDate, $endDate);
                                })->count() }}</h4>
                                <p class="text-green-500 text-xs">Aktif</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Partner -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-building text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Partner</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $lowongans->unique('partner_id')->count() }}</h4>
                                <p class="text-purple-500 text-xs">Perusahaan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Kuota -->
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl p-6 border border-gray-100 transform hover:-translate-y-2 transition-all duration-300">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total</p>
                                <h4 class="font-bold text-2xl text-gray-800">{{ $lowongans->sum('kuota') }}</h4>
                                <p class="text-orange-500 text-xs">Kuota</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lowongan Table -->
            <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Lowongan</h3>
                            <p class="text-gray-600">Kelola lowongan magang</p>
                        </div>
                        <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 shadow-lg flex items-center gap-2"
                            data-modal-target="createLowonganModal" data-modal-toggle="createLowonganModal">
                            <i class="fas fa-plus-circle"></i>
                            <span>Tambah Lowongan</span>
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="lowonganTable" class="min-w-full">
                            <thead>
                                <tr class="border-b-2 border-blue-100">
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Partner</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Lowongan</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                                    </th>
                                    <th class="px-6 py-5 bg-transparent">
                                        <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($lowongans as $lowongan)
                                    <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                                                    <i class="fas fa-building text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-800">{{ $lowongan->partner->nama }}</div>
                                                    <div class="text-sm text-gray-500">{{ $lowongan->lokasi->nama ?? 'Lokasi tidak tersedia' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-800">{{ $lowongan->judul }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $lowongan->periode->nama }} ({{ $lowongan->kuota }} posisi)
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $now = \Carbon\Carbon::now();
                                                $startDate = \Carbon\Carbon::parse($lowongan->tanggal_mulai);
                                                $endDate = \Carbon\Carbon::parse($lowongan->tanggal_akhir);
                                            @endphp
                                            @if($now->lt($startDate))
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <div class="w-2 h-2 bg-blue-400 rounded-full mr-2"></div>
                                                    Akan Datang
                                                </span>
                                            @elseif($now->gt($endDate))
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                                    Selesai
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                                                    Aktif
                                                </span>
                                            @endif
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <button class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1.5 showLowonganBtn"
                                                    data-lowongan='@json($lowongan)'
                                                    data-partner-nama="{{ $lowongan->partner->nama ?? '-' }}"
                                                    data-lokasi-nama="{{ $lowongan->kabupaten->nama ?? '-' }}"
                                                    data-keahlian-nama="{{ $lowongan->keahlian->nama ?? '-' }}"
                                                    data-periode-nama="{{ $lowongan->periode->nama ?? '-' }}">
                                                    <i class="fas fa-eye"></i>
                                                    <span>Lihat</span>
                                                </button>
                                                
                                                <button class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1.5 editLowonganBtn"
                                                    data-lowongan='@json($lowongan)'>
                                                    <i class="fas fa-edit"></i>
                                                    <span>Edit</span>
                                                </button>
                                                
                                                <form action="{{ route('lowongan.destroy', $lowongan->lowongan_id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1.5 btn-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-briefcase text-gray-400 text-xl"></i>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-500 mb-1">Tidak ada lowongan</h3>
                                                <p class="text-gray-400">Belum ada data lowongan yang tersedia</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Information -->
            <div class="mt-8 bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl p-8 border border-white/50">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Status Lowongan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                            <h4 class="font-semibold text-green-800">Lowongan Aktif</h4>
                        </div>
                        <p class="text-green-700 text-sm">Lowongan yang sedang berlangsung dan dapat diajukan oleh mahasiswa.</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-clock text-blue-600 text-xl mr-3"></i>
                            <h4 class="font-semibold text-blue-800">Akan Datang</h4>
                        </div>
                        <p class="text-blue-700 text-sm">Lowongan yang sudah terdaftar tetapi belum memasuki periode pendaftaran.</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-calendar-check text-gray-600 text-xl mr-3"></i>
                            <h4 class="font-semibold text-gray-800">Selesai</h4>
                        </div>
                        <p class="text-gray-700 text-sm">Lowongan yang sudah melewati periode pendaftaran dan tidak dapat diajukan lagi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- modalista --}}
    <div id="createLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah Lowongan</h3>
                <button type="button" data-modal-hide="createLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <form action="{{ route('lowongan.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="partner_id" class="block text-gray-700">Partner</label>
                        <select name="partner_id" id="partner_id"
                            class="w-full px-3 py-2 border rounded-md @error('partner_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Partner</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->partner_id }}" {{ old('partner_id') == $partner->partner_id ? 'selected' : '' }}>
                                    {{ $partner->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="judul" class="block text-gray-700">Judul</label>
                        <input type="text" name="judul" class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="2"
                            class="w-full border border-gray-300 rounded px-3 py-2 resize-y"
                            required>{{ old('deskripsi') }}</textarea>
                    </div>
                    <div>
                        <label for="persyaratan" class="block text-gray-700">Persyaratan</label>
                        <input type="text" name="persyaratan" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                    </div>
                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <select name="lokasi" id="lokasi"
                            class="w-full px-3 py-2 border rounded-md @error('lokasi') border-red-500 @enderror" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($kabupatens as $lokasi)
                                <option value="{{ $lokasi->kabupaten_id }}" {{ old('kabupaten_id') == $lokasi->kabupaten_id ? 'selected' : '' }}>
                                    {{ $lokasi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-1">
                            Keahlian <span class="text-red-500">*</span>
                        </label>
                        <select name="keahlian" id="keahlian"
                            class="w-full px-3 py-2 border rounded-md @error('keahlian') border-red-500 @enderror" required>
                            <option value="">Pilih Bidang Keahlian</option>
                            @foreach($keahlians as $keahlian)
                                <option value="{{ $keahlian->keahlian_id }}" {{ old('keahlian_id') == $keahlian->keahlian_id ? 'selected' : '' }}>
                                    {{ $keahlian->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Periode <span class="text-red-500">*</span>
                        </label>
                        <select name="periode_id" id="periode_id"
                            class="w-full px-3 py-2 border rounded-md @error('periode_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->periode_id }}" {{ old('periode_id') == $periode->periode_id ? 'selected' : '' }}>
                                    {{ $periode->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="kuota" class="block text-gray-700">Kuota</label>
                        <input type="number" name="kuota" id="kuota"
                            class="w-full border border-gray-300 rounded px-3 py-2 resize-y" required
                            value="{{ old('kuota') }}">
                    </div>
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                            class="w-full px-3 py-2 border rounded-md @error('tanggal_mulai') border-red-500 @enderror"
                            value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div>
                        <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-1">
                            Tanggal Akhir <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_akhir" id="tanggal_akhir"
                            class="w-full px-3 py-2 border rounded-md @error('tanggal_akhir') border-red-500 @enderror"
                            value="{{ old('tanggal_akhir') }}" required>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" data-modal-hide="createLowonganModal"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        <i class="fas fa-save mr-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus Lowongan ini?</p>
            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelDeleteBtn"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="button" id="confirmDeleteBtn"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
    {{-- Modal Show Lowongan --}}
    <div id="showLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Detail Lowongan</h3>
                <button type="button" data-modal-hide="showLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Partner</label>
                    <p id="show_partner" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Judul</label>
                    <p id="show_judul" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Deskripsi</label>
                    <p id="show_deskripsi" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50 min-h-[100px]">
                    </p>
                </div>
                <div>
                    <label class="block text-gray-700">Persyaratan</label>
                    <p id="show_persyaratan" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Lokasi</label>
                    <p id="show_lokasi" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Bidang Keahlian</label>
                    <p id="show_keahlian" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Periode</label>
                    <p id="show_periode" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Tanggal Mulai</label>
                    <p id="show_tanggal_mulai" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Tanggal Akhir</label>
                    <p id="show_tanggal_akhir" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
                <div>
                    <label class="block text-gray-700">Kuota</label>
                    <p id="show_kuota" class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-50"></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="mt-6 flex justify-end">
                <button type="button" data-modal-hide="showLowonganModal"
                    class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                    <i class="fas fa-times mr-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Edit Lowongan --}}
    <div id="editLowonganModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit Lowongan</h3>
                <button type="button" data-modal-hide="editLowonganModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <form id="editLowonganForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="lowongan_id" id="edit_lowongan_id">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="edit_partner_id" class="block text-gray-700">Partner</label>
                        <select name="partner_id" id="edit_partner_id"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="">Pilih Partner</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->partner_id }}">{{ $partner->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_judul" class="block text-gray-700">Judul</label>
                        <input type="text" name="judul" id="edit_judul"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_deskripsi" class="block text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" id="edit_deskripsi" rows="2"
                            class="w-full border border-gray-300 rounded px-3 py-2 resize-y" required></textarea>
                    </div>
                    <div>
                        <label for="edit_persyaratan" class="block text-gray-700">Persyaratan</label>
                        <input type="text" name="persyaratan" id="edit_persyaratan"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_lokasi" class="block text-gray-700">Lokasi</label>
                        <select name="lokasi" id="edit_lokasi" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($kabupatens as $lokasi)
                                <option value="{{ $lokasi->kabupaten_id }}">{{ $lokasi->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_keahlian" class="block text-gray-700">Bidang Keahlian</label>
                        <select name="keahlian" id="edit_keahlian" class="w-full border border-gray-300 rounded px-3 py-2"
                            required>
                            <option value="">Pilih Keahlian</option>
                            @foreach($keahlians as $keahlian)
                                <option value="{{ $keahlian->keahlian_id }}">{{ $keahlian->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_periode_id" class="block text-gray-700">Periode</label>
                        <select name="periode_id" id="edit_periode_id"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $periode)
                                <option value="{{ $periode->periode_id }}">{{ $periode->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="edit_kuota" class="block text-gray-700">Kuota</label>
                        <input type="number" name="kuota" id="edit_kuota"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_tanggal_mulai" class="block text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label for="edit_tanggal_akhir" class="block text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" id="edit_tanggal_akhir"
                            class="w-full border border-gray-300 rounded px-3 py-2" required>
                    </div>
                </div>
                <div class="mt-6 col-span-2 flex justify-end space-x-3">
                    <button type="button" data-modal-hide="editLowonganModal"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1">
                        <i class="fas fa-times mr-2"></i>Batal
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Custom Styling for Enhanced Button Appearance --}}
    <style>
        /* Enhanced button hover effects */
        .btn-action {
            position: relative;
            overflow: hidden;
            transform: translateZ(0);
        }

        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-action:hover::before {
            left: 100%;
        }

        /* Button loading state */
        .btn-loading {
            position: relative;
            pointer-events: none;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: button-loading-spinner 1s ease infinite;
        }

        @keyframes button-loading-spinner {
            from {
                transform: rotate(0turn);
            }
            to {
                transform: rotate(1turn);
            }
        }

        /* Enhanced focus states */
        .btn-focus:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.5);
        }

        /* Improved table row hover */
        .table-row-hover:hover {
            background-color: #eff6ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease-in-out;
        }
    </style>

    {{-- Update the show modal JavaScript --}}
    <script>
        // Show Modal JavaScript
        document.addEventListener("DOMContentLoaded", () => {
            const showButtons = document.querySelectorAll(".showLowonganBtn");

            showButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Update show modal fields
                    document.getElementById("show_partner").textContent = btn.getAttribute("data-partner-nama");
                    document.getElementById("show_judul").textContent = lowongan.judul;
                    document.getElementById("show_deskripsi").textContent = lowongan.deskripsi;
                    document.getElementById("show_persyaratan").textContent = lowongan.persyaratan;
                    document.getElementById("show_lokasi").textContent = btn.getAttribute("data-lokasi-nama");
                    document.getElementById("show_keahlian").textContent = btn.getAttribute("data-keahlian-nama");
                    document.getElementById("show_periode").textContent = btn.getAttribute("data-periode-nama");
                    document.getElementById("show_tanggal_mulai").textContent =
                        new Date(lowongan.tanggal_mulai).toLocaleDateString('id-ID');
                    document.getElementById("show_tanggal_akhir").textContent =
                        new Date(lowongan.tanggal_akhir).toLocaleDateString('id-ID');
                    document.getElementById("show_kuota").textContent = lowongan.kuota;

                    document.getElementById("showLowonganModal").classList.remove("hidden");
                });
            });

            // Close modal handler
            document.querySelectorAll('[data-modal-hide="showLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("showLowonganModal").classList.add("hidden");
                });
            });
        });

        // Edit Modal JavaScript
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".editLowonganBtn");
            const editForm = document.getElementById("editLowonganForm");

            editButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Update form fields
                    document.getElementById("edit_lowongan_id").value = lowongan.lowongan_id;
                    document.getElementById("edit_partner_id").value = lowongan.partner_id;
                    document.getElementById("edit_judul").value = lowongan.judul;
                    document.getElementById("edit_deskripsi").value = lowongan.deskripsi;
                    document.getElementById("edit_persyaratan").value = lowongan.persyaratan;
                    document.getElementById("edit_lokasi_id").value = lowongan.kabupaten_id;
                    document.getElementById("edit_keahlian_id").value = lowongan.keahlian_id;
                    document.getElementById("edit_periode_id").value = lowongan.periode_id;
                    document.getElementById("edit_tanggal_mulai").value = lowongan.tanggal_mulai;
                    document.getElementById("edit_tanggal_akhir").value = lowongan.tanggal_akhir;
                    document.getElementById("edit_kuota").value = lowongan.kuota;

                    editForm.action = `/admin/lowongan/${lowongan.lowongan_id}`;
                    document.getElementById("editLowonganModal").classList.remove("hidden");
                });
            });

            // Close modal handler
            document.querySelectorAll('[data-modal-hide="editLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("editLowonganModal").classList.add("hidden");
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            const table = $('#lowonganTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "pageLength": 7,
                "ordering": true,
                "responsive": true,
                "dom": "<'overflow-x-auto'rt><'flex flex-col md:flex-row justify-center items-center gap-4 mt-6'<'flex items-center'p>>",
                "searching": false,
                "info": false,
                "columnDefs": [
                    {
                        "targets": [0],
                        "searchable": false,
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "targets": [4],
                        "orderable": false
                    }
                ],
                "order": [[0, "asc"]],
                "drawCallback": function(settings) {
                    // Style pagination buttons
                    $('.dataTables_paginate .paginate_button').removeClass().addClass('px-4 py-2 bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 mx-1 rounded-xl shadow-sm');
                    $('.dataTables_paginate .paginate_button.current').removeClass().addClass('px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 text-sm font-medium text-white mx-1 rounded-xl shadow-md');
                    $('.dataTables_paginate .paginate_button.disabled').removeClass().addClass('px-4 py-2 bg-gray-50 border border-gray-100 text-sm font-medium text-gray-400 mx-1 rounded-xl cursor-not-allowed');
                    $('.dataTables_paginate').addClass('space-x-1');
                }
            });
    </script>
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-modal-target');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.remove('hidden');
                }
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-modal-hide');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.add('hidden');
                }
            });
        });

    </script>
    <script>
        let formToDelete = null;


        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                formToDelete = button.closest('form');
                document.getElementById('deleteConfirmModal').classList.remove('hidden');
            });
        });


        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
            if (formToDelete) {
                formToDelete.submit();
            }
        });


        document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
            formToDelete = null;
            document.getElementById('deleteConfirmModal').classList.add('hidden'); // Sembunyikan modal
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".editLowonganBtn");
            const editForm = document.getElementById("editLowonganForm");

            editButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    document.getElementById("edit_lowongan_id").value = lowongan.lowongan_id;
                    document.getElementById("edit_partner_id").value = lowongan.partner_id;
                    document.getElementById("edit_judul").value = lowongan.judul;
                    document.getElementById("edit_deskripsi").value = lowongan.deskripsi;
                    document.getElementById("edit_persyaratan").value = lowongan.persyaratan;
                    document.getElementById("edit_lokasi").value = lowongan.kabupaten_id;
                    document.getElementById("edit_keahlian").value = lowongan.keahlian_id; // field ID, bukan relasi
                    document.getElementById("edit_periode_id").value = lowongan.periode_id;
                    document.getElementById("edit_tanggal_mulai").value = lowongan.tanggal_mulai;
                    document.getElementById("edit_tanggal_akhir").value = lowongan.tanggal_akhir;
                    document.getElementById("edit_kuota").value = lowongan.kuota;

                    editForm.action = `/admin/lowongan/${lowongan.lowongan_id}`;
                    document.getElementById("editLowonganModal").classList.remove("hidden");
                });
            });

            // Handler untuk menutup modal
            document.querySelectorAll('[data-modal-hide="editLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("editLowonganModal").classList.add("hidden");
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const showButtons = document.querySelectorAll(".showLowonganBtn");

            showButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const lowongan = JSON.parse(btn.getAttribute("data-lowongan"));

                    // Mapping nama partner, lokasi, periode dari ID ke teks
                    const partner = btn.getAttribute("data-partner-nama");
                    const lokasi = btn.getAttribute("data-lokasi-nama");
                    const periode = btn.getAttribute("data-periode-nama");

                    document.getElementById("show_partner").textContent = partner || '';
                    document.getElementById("show_judul").textContent = lowongan.judul || '';
                    document.getElementById("show_deskripsi").textContent = lowongan.deskripsi || '';
                    document.getElementById("show_persyaratan").textContent = lowongan.persyaratan || '';
                    document.getElementById("show_lokasi").textContent = lokasi || '';
                    document.getElementById("show_bidang_keahlian").textContent = lowongan.bidang_keahlian || '';
                    document.getElementById("show_periode").textContent = periode || '';
                    document.getElementById("show_tanggal_mulai").textContent = lowongan.tanggal_mulai || '';
                    document.getElementById("show_tanggal_akhir").textContent = lowongan.tanggal_akhir || '';

                    document.getElementById("showLowonganModal").classList.remove("hidden");
                });
            });

            // Close modal
            document.querySelectorAll('[data-modal-hide="showLowonganModal"]').forEach(btn => {
                btn.addEventListener("click", () => {
                    const fields = document.querySelectorAll('#showLowonganForm p');
                    fields.forEach(p => p.textContent = '');
                    document.getElementById("showLowonganModal").classList.add("hidden");
                });
            });
        });

@endsection