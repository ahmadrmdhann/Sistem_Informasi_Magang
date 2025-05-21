@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Program Studi</h2>
        <a href="{{ route('prodi.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow">
            <i class="fas fa-plus mr-2"></i>Tambah Prodi
        </a>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="overflow-x-auto">
        <table id="prodiTable" class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Nama Program Studi</th>
                    <th class="px-4 py-2">Dibuat</th>
                    <th class="px-4 py-2">Diperbarui</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($prodis as $index => $prodi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $prodi->prodi_kode }}</td>
                        <td class="px-4 py-2">{{ $prodi->prodi_nama }}</td>
                        <td class="px-4 py-2">{{ $prodi->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $prodi->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('prodi.edit', $prodi->prodi_id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <form action="{{ route('prodi.destroy', $prodi->prodi_id) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus prodi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center">Tidak ada data Program Studi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- DataTables CSS & JS CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#prodiTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
@endsection