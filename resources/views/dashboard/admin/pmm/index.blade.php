@extends('layouts.dashboard')

@section('title')
    <title>Kelola Status Pengajuan Magang</title>
@endsection

@section('content')
<div id="mainContent" class="p-6 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <h2 class="text-2xl font-bold mb-6">Kelola Status Pengajuan Magang</h2>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table id="pengajuanTable" class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
            <thead class="bg-blue-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">Mahasiswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">Lowongan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">Mitra</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">Pendamping</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 border-b border-gray-300">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-700 border-b border-gray-300">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuans as $index => $pengajuan)
                    <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $pengajuan->mahasiswa->user->nama ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $pengajuan->dosen->user->nama ?? '-' }}</td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $pengajuan->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' :
                                    ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-700' :
                                    'bg-red-100 text-red-700') }}">
                                {{ ucfirst($pengajuan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                            @if($pengajuan->status != 'diajukan')
                                <button type="button" class="bg-gray-400 text-white text-xs px-3 py-1 rounded cursor-not-allowed" disabled>
                                    Updated
                                </button>
                            @else
                                <button type="button" onclick="openModal('{{ $pengajuan->id }}')"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">
                                    Kelola
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data pengajuan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Semua modal diletakkan DI BAWAH table --}}
    @foreach ($pengajuans as $pengajuan)
        <div id="modal-{{ $pengajuan->id }}" class="fixed inset-0 z-50 hidden backdrop-blur flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
                <h3 class="text-lg font-semibold mb-4">Kelola Pengajuan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-4 mb-4">
                    {{-- Detail Mahasiswa --}}
                    <div>
                        <h4 class="font-bold text-base mb-2">Detail Mahasiswa</h4>
                        <div class="mb-1">
                            <span class="font-semibold">Nama:</span>
                            {{ $pengajuan->mahasiswa->user->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">NIM:</span>
                            {{ $pengajuan->mahasiswa->nim ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Prodi:</span>
                            {{ $pengajuan->mahasiswa->prodi->prodi_nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Keahlian:</span>
                            {{ $pengajuan->mahasiswa->keahlian->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Minat:</span>
                            {{ $pengajuan->mahasiswa->minat->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Lokasi Preferensi:</span>
                            {{ $pengajuan->mahasiswa->lokasiPreferensi->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Sertifikat:</span>
                            @if ($pengajuan->mahasiswa->sertifikat)
                                <a href="{{ asset('storage/sertifikat/' . $pengajuan->mahasiswa->sertifikat) }}" target="_blank"
                                    class="text-blue-600 underline">Lihat Sertifikat</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">CV:</span>
                            @if ($pengajuan->mahasiswa->cv_file)
                                <a href="{{ $pengajuan->mahasiswa->cv_url }}" target="_blank" class="text-blue-600 underline">Lihat CV</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                    {{-- Detail Lowongan --}}
                    <div>
                        <h4 class="font-bold text-base mb-2">Detail Lowongan</h4>
                        <div class="mb-1">
                            <span class="font-semibold">Judul:</span>
                            {{ $pengajuan->lowongan->judul ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Mitra:</span>
                            {{ $pengajuan->lowongan->partner->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Deskripsi:</span>
                            {{ $pengajuan->lowongan->deskripsi ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Lokasi:</span>
                            {{ $pengajuan->lowongan->kabupaten->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Keahlian Dibutuhkan:</span>
                            {{ $pengajuan->lowongan->keahlian->nama ?? '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Tanggal Mulai:</span>
                            {{ $pengajuan->lowongan->tanggal_mulai ? \Carbon\Carbon::parse($pengajuan->lowongan->tanggal_mulai)->format('d/m/Y') : '-' }}
                        </div>
                        <div class="mb-1">
                            <span class="font-semibold">Tanggal Selesai:</span>
                            {{ $pengajuan->lowongan->tanggal_selesai ? \Carbon\Carbon::parse($pengajuan->lowongan->tanggal_selesai)->format('d/m/Y') : '-' }}
                        </div>
                    </div>
                </div>

                <form action="{{ route('pmm.updateStatus', $pengajuan->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status-{{ $pengajuan->id }}" class="mt-1 w-full rounded border-gray-300"
                            required onchange="toggleDosenSelect('{{ $pengajuan->id }}')">
                            <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div id="dosen-container-{{ $pengajuan->id }}"
                        class="{{ $pengajuan->status !== 'diterima' ? 'hidden' : '' }} mb-4">
                        <label class="text-sm font-medium text-gray-700">Dosen Pendamping</label>
                        <select name="dosen_id" class="mt-1 w-full rounded border-gray-300">
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
                <button onclick="closeModal('{{ $pengajuan->id }}')"
                    class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                    ✕
                </button>
            </div>
        </div>
    @endforeach
</div>

{{-- SCRIPT --}}
<script>
    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }

    function toggleDosenSelect(id) {
        const status = document.getElementById('status-' + id).value;
        const container = document.getElementById('dosen-container-' + id);
        if (status === 'diterima') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    $(document).ready(function () {
        $('#pengajuanTable').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            }
        });
    });
</script>
@endsection