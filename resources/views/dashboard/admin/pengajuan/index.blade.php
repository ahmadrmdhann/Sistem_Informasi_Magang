@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <h2 class="text-2xl font-bold mb-6">Pengajuan Magang</h2>

        {{-- Tampilkan notifikasi sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Daftar Lowongan --}}
        <div class="mb-10">
            <h3 class="text-xl font-semibold mb-2">Pilih Lowongan</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse ($lowongans as $lowongan)
                    <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                        <h4 class="text-lg font-bold text-blue-700">{{ $lowongan->judul }}</h4>
                        <p class="text-gray-600 text-sm">Mitra: <strong>{{ $lowongan->partner->nama }}</strong></p>
                        <p class="text-gray-600 text-sm">Periode: {{ $lowongan->periode->nama }}</p>
                        <p class="text-gray-600 text-sm mb-3">Tanggal:
                            {{ \Carbon\Carbon::parse($lowongan->tanggal_mulai)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($lowongan->tanggal_akhir)->format('d M Y') }}</p>
                        <form action="{{ route('pengajuan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lowongan_id" value="{{ $lowongan->lowongan_id }}">
                            <button type="submit"
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold">
                                Ajukan
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada lowongan tersedia.</p>
                @endforelse
            </div>
        </div>

        {{-- Daftar Pengajuan --}}
        <div>
            <h3 class="text-xl font-semibold mb-2">Riwayat Pengajuan</h3>
            <div class="overflow-x-auto">
                <table
                    class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                    <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase border-b border-r">
                                No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase border-b border-r">
                                Lowongan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase border-b border-r">
                                Mitra</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase border-b border-r">
                                Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase border-b border-r">
                                Tanggal Pengajuan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase border-b">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengajuans as $index => $pengajuan)
                            <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                <td class="px-6 py-3 text-gray-700 border-b border-r">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 text-gray-700 border-b border-r">{{ $pengajuan->lowongan->judul }}</td>
                                <td class="px-6 py-3 text-gray-700 border-b border-r">{{ $pengajuan->lowongan->partner->nama }}
                                </td>
                                <td class="px-6 py-3 text-gray-700 border-b border-r">{{ $pengajuan->periode->nama }}</td>
                                <td class="px-6 py-3 text-gray-500 border-b border-r">
                                    {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-gray-700 border-b">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $pengajuan->status == 'diajukan' ? 'bg-yellow-100 text-yellow-700' : ($pengajuan->status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700') }}">
                                        {{ ucfirst($pengajuan->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-3 text-center text-gray-500">Belum ada pengajuan magang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection