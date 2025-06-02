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
                            Pendamping</th>
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
                                                                        {{ $pengajuan->mahasiswa->user->nama ?? '-' }}</td>
                                                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                                                        {{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                                                        {{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                                                        {{ $pengajuan->dosen->user->nama ?? '-' }}
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
                                                                        
                                                                            
                                                                            <button type="button" data-modal-target="#modal-{{ $pengajuan->id }}"
                                                                                class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded shadow transition duration-150">
                                                                                Kelola
                                                                            </button>

                                                                  
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
    <!-- Modal -->
    <div id="modal-{{ $pengajuan->id }}"
        class="fixed inset-0 z-50 hidden backdrop-blur flex justify-center items-center">
        <div class="bg-white w-full max-w-md rounded-lg p-6 relative">
            <h3 class="text-lg font-semibold mb-4">Kelola Pengajuan Magang</h3>

            <form action="{{ route('pmm.updateStatus', ['id' => $pengajuan->id]) }}" method="POST">
                @csrf

                <!-- Mahasiswa -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Mahasiswa</label>
                    <input type="text" class="mt-1 block w-full rounded border-gray-300"
                        value="{{ $pengajuan->mahasiswa->user->nama }}" readonly>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                        <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Dosen -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Dosen Pendamping</label>
                    <select name="dosen_id" class="mt-1 block w-full rounded border-gray-300" required>
                        <option value="">-- Pilih Dosen --</option>
                        @foreach ($dosens as $dosen)
                            <option value="{{ $dosen->dosen_id }}" {{ $pengajuan->dosen_id == $dosen->dosen_id ? 'selected' : '' }}>
                                {{ $dosen->user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal('{{ $pengajuan->id }}')"
                        class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                </div>
            </form>

            <!-- Close icon -->
            <button onclick="closeModal('{{ $pengajuan->id }}')"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                ✕
            </button>
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
    <script>
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.querySelector(modalId).classList.remove('hidden');
            });
        });

        function closeModal(id) {
            document.querySelector(`#modal-${id}`).classList.add('hidden');
        }
    </script>

@endsection