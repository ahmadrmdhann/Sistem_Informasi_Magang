@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar User</h2>
            <a href="{{ route('user.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow">
                <i class="fas fa-plus mr-2"></i>Tambah User
            </a>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="overflow-x-auto">
            <table id="userTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">Level</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $user->nama }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $user->email }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $user->level->level_nama}}</td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('user.show', $user->user_id) }}"
                                        class="bg-blue-400 hover:bg-blue-500 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                    <a href="{{ route('user.edit', $user->user_id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $user->user_id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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
                            <td colspan="7" class="px-6 py-3 text-center text-gray-500">Tidak ada data User</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>
@endsection
