@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Lowongan</h2>
            <a href="{{ route('lowongan.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-plus mr-2"></i>Tambah Lowongan
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="lowonganTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Judul</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Mitra</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Periode</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Tanggal Mulai</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Tanggal Akhir</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lowongans as $index => $lowongan)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->judul }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->partner->nama }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $lowongan->periode->nama }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ \Carbon\Carbon::parse($lowongan->tanggal_mulai)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ \Carbon\Carbon::parse($lowongan->tanggal_akhir)->format('d/m/Y') }}</td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('lowongan.edit', $lowongan->lowongan_id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('lowongan.destroy', $lowongan->lowongan_id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-3 text-center text-gray-500">Tidak ada data Lowongan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#lowonganTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>
@endsection
