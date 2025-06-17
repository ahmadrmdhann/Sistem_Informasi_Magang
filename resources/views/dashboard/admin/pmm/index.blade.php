@extends('layouts.dashboard')

@section('title')
    <title>Kelola Status Pengajuan Magang</title>
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
                        <i class="fas fa-clipboard-list text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Kelola Status Pengajuan Magang</h1>
                        <p class="text-white/80">Kelola dan monitor status pengajuan magang mahasiswa</p>
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

        <!-- Pengajuan Table -->
        <div class="bg-white/70 backdrop-blur-xl rounded-3xl shadow-xl border border-white/50 overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Daftar Pengajuan Magang</h3>
                        <p class="text-gray-600">Kelola status pengajuan magang mahasiswa</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="pengajuanTable" class="min-w-full">
                        <thead>
                            <tr class="border-b-2 border-blue-100">
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Mahasiswa</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Lowongan</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Mitra</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Tanggal</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Pendamping</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                                </th>
                                <th class="px-6 py-5 bg-transparent text-center">
                                    <span class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($pengajuans as $index => $pengajuan)
                                <tr class="hover:bg-blue-50/30 transition-all duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-800"></td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $pengajuan->mahasiswa->user->nama ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $pengajuan->lowongan->judul ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $pengajuan->dosen->user->nama ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $pengajuan->status === 'diajukan' ? 'bg-yellow-100 text-yellow-700' :
                                                ($pengajuan->status === 'diterima' ? 'bg-green-100 text-green-700' :
                                                'bg-red-100 text-red-700') }}">
                                            {{ ucfirst($pengajuan->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            @if($pengajuan->status != 'diajukan')
                                                <button type="button" class="bg-gray-400 text-white px-3 py-1.5 rounded-lg text-sm font-medium cursor-not-allowed" disabled>
                                                    <i class="fas fa-check"></i>
                                                    <span>Updated</span>
                                                </button>
                                            @else
                                                <button type="button" onclick="openModal('{{ $pengajuan->id }}')"
                                                    class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-colors duration-200">
                                                    <i class="fas fa-edit"></i>
                                                    <span>Kelola</span>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <i class="fas fa-clipboard-list text-gray-400 text-2xl"></i>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-400 mb-1">Tidak ada data</h3>
                                            <p class="text-gray-400">Belum ada pengajuan magang yang tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Semua modal diletakkan DI BAWAH table --}}
    @foreach ($pengajuans as $pengajuan)
        <div id="modal-{{ $pengajuan->id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-900/70">
            <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-4xl p-8 relative border border-white/20">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-edit text-white text-sm"></i>
                    </div>
                    Kelola Pengajuan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-gray-200 pb-6 mb-6">
                    {{-- Detail Mahasiswa --}}
                    <div class="bg-blue-50/50 rounded-2xl p-6">
                        <h4 class="font-bold text-lg mb-4 text-blue-800 flex items-center">
                            <i class="fas fa-user-graduate mr-2"></i>
                            Detail Mahasiswa
                        </h4>
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Nama:</span>
                                <span class="text-gray-800">{{ $pengajuan->mahasiswa->user->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">NIM:</span>
                                <span class="text-gray-800">{{ $pengajuan->mahasiswa->nim ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Prodi:</span>
                                <span class="text-gray-800">{{ $pengajuan->mahasiswa->prodi->prodi_nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Keahlian:</span>
                                <span class="text-gray-800">{{ $pengajuan->mahasiswa->keahlian->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Minat:</span>
                                <span class="text-gray-800">{{ $pengajuan->mahasiswa->minat->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Lokasi:</span>
                                <span class="text-gray-800">{{ $pengajuan->mahasiswa->lokasiPreferensi->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Sertifikat:</span>
                                @if ($pengajuan->mahasiswa->sertifikat_file)
                                    <a href="{{ asset($pengajuan->mahasiswa->sertifikat_file) }}" target="_blank"
                                        class="text-red-600 hover:text-red-800 font-medium transition-colors duration-200">
                                        <i class="fa-regular fa-file-pdf mr-1"></i>Lihat Sertifikat
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">CV:</span>
                                @if ($pengajuan->mahasiswa->cv_file)
                                    <a href="{{ asset($pengajuan->mahasiswa->cv_file) }}" target="_blank"
                                        class="text-red-600 hover:text-red-800 font-medium transition-colors duration-200">
                                        <i class="fa-regular fa-file-pdf mr-1"></i>Lihat CV
                                    </a>
                                @else
                                    <span class="text-gray-500">-</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- Detail Lowongan --}}
                    <div class="bg-indigo-50/50 rounded-2xl p-6">
                        <h4 class="font-bold text-lg mb-4 text-indigo-800 flex items-center">
                            <i class="fas fa-briefcase mr-2"></i>
                            Detail Lowongan
                        </h4>
                        <div class="space-y-3">
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Judul:</span>
                                <span class="text-gray-800">{{ $pengajuan->lowongan->judul ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Mitra:</span>
                                <span class="text-gray-800">{{ $pengajuan->lowongan->partner->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Deskripsi:</span>
                                <span class="text-gray-800">{{ Str::limit($pengajuan->lowongan->deskripsi ?? '-', 100) }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Lokasi:</span>
                                <span class="text-gray-800">{{ $pengajuan->lowongan->kabupaten->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Keahlian:</span>
                                <span class="text-gray-800">{{ $pengajuan->lowongan->keahlian->nama ?? '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Mulai:</span>
                                <span class="text-gray-800">{{ $pengajuan->lowongan->tanggal_mulai ? \Carbon\Carbon::parse($pengajuan->lowongan->tanggal_mulai)->format('d/m/Y') : '-' }}</span>
                            </div>
                            <div class="flex">
                                <span class="font-semibold text-gray-700 w-32">Selesai:</span>
                                <span class="text-gray-800">{{ $pengajuan->lowongan->tanggal_akhir ? \Carbon\Carbon::parse($pengajuan->lowongan->tanggal_akhir)->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('pmm.updateStatus', $pengajuan->id) }}" method="POST" class="bg-gray-50/50 rounded-2xl p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-flag mr-1"></i>Status Pengajuan
                        </label>
                        <select name="status" id="status-{{ $pengajuan->id }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                            required onchange="toggleDosenSelect('{{ $pengajuan->id }}')">
                            <option value="diajukan" {{ $pengajuan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="diterima" {{ $pengajuan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="ditolak" {{ $pengajuan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div id="dosen-container-{{ $pengajuan->id }}"
                        class="{{ $pengajuan->status !== 'diterima' ? 'hidden' : '' }} mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-chalkboard-teacher mr-1"></i>Dosen Pendamping
                        </label>
                        <select name="dosen_id" id="dosen-select-{{ $pengajuan->id }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                            <option value="">-- Pilih Dosen --</option>
                            @foreach ($dosens as $dosen)
                                <option value="{{ $dosen->dosen_id }}" {{ $pengajuan->dosen_id == $dosen->dosen_id ? 'selected' : '' }}>
                                    {{ $dosen->user->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal('{{ $pengajuan->id }}')"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-colors duration-200">
                            <i class="fas fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-xl font-medium transition-all duration-200 transform hover:scale-105">
                            <i class="fas fa-save mr-1"></i>Update
                        </button>
                    </div>
                </form>
                <button onclick="closeModal('{{ $pengajuan->id }}')"
                    class="absolute top-4 right-4 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-500 hover:text-gray-700 transition-colors duration-200">
                    <i class="fas fa-times"></i>
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
        const dosenSelect = document.getElementById('dosen-select-' + id);

        if (status === 'diterima') {
            container.classList.remove('hidden');
            dosenSelect.setAttribute('required', 'required');
        } else {
            container.classList.add('hidden');
            dosenSelect.removeAttribute('required');
            dosenSelect.value = ''; // Clear selection when hidden
        }
    }

    $(document).ready(function () {
        const table = $('#pengajuanTable').DataTable({
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
                    "targets": [7],
                    "orderable": false
                }
            ],
            "order": [[0, "asc"]],
            "drawCallback": function(settings) {
                $('.dataTables_paginate .paginate_button').removeClass().addClass('px-4 py-2 bg-white border border-gray-200 text-sm font-medium text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 mx-1 rounded-xl shadow-sm');
                $('.dataTables_paginate .paginate_button.current').removeClass().addClass('px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-blue-600 text-sm font-medium text-white mx-1 rounded-xl shadow-md');
                $('.dataTables_paginate .paginate_button.disabled').removeClass().addClass('px-4 py-2 bg-gray-50 border border-gray-100 text-sm font-medium text-gray-400 mx-1 rounded-xl cursor-not-allowed');
                $('.dataTables_paginate').addClass('space-x-1');
            }
        });
    });
</script>
@endsection
