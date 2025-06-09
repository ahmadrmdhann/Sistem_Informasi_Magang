@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar Dosen</h2>
            <button class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow"
                data-modal-target="createDosenModal" data-modal-toggle="createDosenModal">
                <i class="fas fa-plus mr-2"></i>Tambah Dosen
            </button>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table id="dosenTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Nama Dosen</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            NIDN</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Email</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Bidang Keahlian</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataDosen as $index => $dosen)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                {{ $dosen->user->nama ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $dosen->nidn }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                {{ $dosen->user->email ?? '-' }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">
                                {{ $dosen->bidang->nama?? '-' }}</td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <div class="flex justify-center space-x-2">
                                    <button type="button"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition-colors duration-150 editDosenBtn"
                                        data-dosen='@json($dosen)'>
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </button>
                                    <form action="{{ route('admin.dosen.destroy', $dosen->dosen_id) }}" method="POST"
                                        class="delete-dosen-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-dosen-id="{{ $dosen->dosen_id }}"
                                            class="btn-delete bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition-colors duration-150">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-gray-500">Tidak ada data Dosen</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah Dosen --}}
    <div id="createDosenModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Tambah Dosen</h3>
                <button type="button" data-modal-hide="createDosenModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.dosen.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="user_id" class="block text-gray-700">Pilih User</label>
                    <select name="user_id" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">-- Pilih User --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="nidn" class="block text-gray-700">NIDN</label>
                    <input type="text" name="nidn" class="w-full border border-gray-300 rounded px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="bidang_minat" class="block text-gray-700">Bidang Keahlian</label>
                    <select name="bidang_minat" class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">-- Pilih Bidang Keahlian --</option>
                        @foreach ($bidangKeahlian as $keahlian)
                            <option value="{{ $keahlian->keahlian_id }}">{{ $keahlian->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="createDosenModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Dosen --}}
    <div id="editDosenModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit Dosen</h3>
                <button type="button" data-modal-hide="editDosenModal" class="text-gray-500 hover:text-gray-700">
                    &times;
                </button>
            </div>
            <form id="editDosenForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="dosen_id" id="edit_dosen_id">
                <div class="mb-4">
                    <label class="block text-gray-700">User</label>
                    <select name="user_id" id="edit_user_id" class="w-full border border-gray-300 rounded px-3 py-2"
                        required>
                        @foreach ($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">NIDN</label>
                    <input type="text" name="nidn" id="edit_nidn" class="w-full border border-gray-300 rounded px-3 py-2"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Bidang Keahlian</label>
                    <select name="bidang_minat" id="edit_bidang_minat"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                        <option value="">-- Pilih Bidang Keahlian --</option>
                        @foreach ($bidangKeahlian as $keahlian)
                            <option value="{{ $keahlian->keahlian_id }}">{{ $keahlian->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" data-modal-hide="editDosenModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div id="deleteConfirmModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data dosen ini?</p>
            <div class="flex justify-end">
                <button type="button" id="cancelDeleteBtn"
                    class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                <button type="button" id="confirmDeleteBtn"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Hapus</button>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        $(document).ready(function () {
            $('#dosenTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>

    <script>
        // Modal toggle functionality
        document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-modal-target');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.remove('hidden');
                }
            });
        });

        document.querySelectorAll('[data-modal-hide]').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-modal-hide');
                const target = document.getElementById(targetId);
                if (target) {
                    target.classList.add('hidden');
                }
            });
        });
    </script>

    <script>
        // Delete confirmation functionality
        let formToDelete = null;

        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', () => {
                formToDelete = button.closest('form');
                document.getElementById('deleteConfirmModal').classList.remove('hidden');
            });
        });

        document.getElementById('confirmDeleteBtn').addEventListener('click', () => {
            if (formToDelete) {
                formToDelete.submit();
            }
        });

        document.getElementById('cancelDeleteBtn').addEventListener('click', () => {
            formToDelete = null;
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        });
    </script>

    <script>
        // Edit modal functionality
        document.addEventListener("DOMContentLoaded", () => {
            const editButtons = document.querySelectorAll(".editDosenBtn");
            const editForm = document.getElementById("editDosenForm");

            editButtons.forEach(btn => {
                btn.addEventListener("click", () => {
                    const dosen = JSON.parse(btn.getAttribute("data-dosen"));

                    document.getElementById("edit_dosen_id").value = dosen.dosen_id;
                    document.getElementById("edit_user_id").value = dosen.user_id;
                    document.getElementById("edit_nidn").value = dosen.nidn;
                    document.getElementById("edit_bidang_minat").value = dosen.bidang_minat;

                    // Set dynamic form action
                    editForm.action = `/Sistem_Informasi_Magang/public/admin/dosen/${dosen.dosen_id}`;

                    // Show modal
                    document.getElementById("editDosenModal").classList.remove("hidden");
                });
            });
        });
    </script>
@endsection