@extends('layouts.dashboard')

@section('title')
    <title>Kelola Status Pengajuan Magang</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <h2 class="text-2xl font-bold mb-6">Kelola Status Pengajuan Magang</h2>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="pengajuanTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Mahasiswa</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Lowongan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Mitra</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Tanggal Pengajuan</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Status</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengajuans as $index => $pengajuan)
                                <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                        {{ $pengajuan->mahasiswa->nama ?? '-' }}</td>
                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                        {{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                        {{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $pengajuan->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' :
                        ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-700' :
                            'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-center border-b border-gray-200">
                                        <form action="{{ route('pmm.updateStatus', ['id' => $pengajuan->id]) }}" method="POST"
                                            class="flex justify-center items-center space-x-2">
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
                                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition duration-150">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-3 text-center text-gray-500">Belum ada data pengajuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#pengajuanTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>
@endsection