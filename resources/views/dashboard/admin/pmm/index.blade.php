@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <h2 class="text-2xl font-bold mb-6">Kelola Status Pengajuan Magang</h2>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-xl shadow-lg">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Mahasiswa</th>
                        <th class="px-4 py-2 border">Lowongan</th>
                        <th class="px-4 py-2 border">Mitra</th>
                        <th class="px-4 py-2 border">Tanggal Pengajuan</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuans as $index => $pengajuan)
                                                <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                                    <td class="px-4 py-2 border">{{ $pengajuan->mahasiswa->nama ?? '-' }}</td>
                                                    <td class="px-4 py-2 border">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                                    <td class="px-4 py-2 border">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                                    <td class="px-4 py-2 border">
                                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="px-4 py-2 border">
                                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                                {{ $pengajuan->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' :
                        ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-700' :
                            'bg-red-100 text-red-700') }}">
                                                            {{ ucfirst($pengajuan->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 border">
                                                        <form action="{{ route('pmm.updateStatus', ['id' => $pengajuan->id]) }}" method="POST"

                                                            class="flex items-center space-x-2">
                                                            @csrf
                                                            <select name="status" class="text-sm border rounded px-2 py-1">
                                                                <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan
                                                                </option>
                                                                <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima
                                                                </option>
                                                                <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak
                                                                </option>
                                                            </select>
                                                            <button type="submit"
                                                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                                                                Update
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Belum ada data pengajuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection