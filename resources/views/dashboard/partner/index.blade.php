@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4 w-auto">
            <h2 class="text-2xl font-bold">Daftar Mitra</h2>
            <a href="{{ route('partner.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-plus mr-2"></i>Tambah Mitra
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="partnerTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Nama Mitra</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Diperbarui</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300 rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($partners as $index => $partner)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $partner->nama }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $partner->email }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $partner->telepon }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $partner->alamat }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ $partner->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 text-gray-500 border-b border-r border-gray-200">{{ $partner->updated_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-3 text-center border-b border-r border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('partner.edit', $partner->partner_id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('partner.destroy', $partner->partner_id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?')">
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
                            <td colspan="8" class="px-6 py-3 text-center text-gray-500">Tidak ada data Partner</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#partnerTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>
@endsection
