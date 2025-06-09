@extends('layouts.dashboard')

@section('title')
    <title>Input IPK Mahasiswa</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Daftar IPK Mahasiswa</h2>
            <!-- Tidak ada tombol tambah, karena entry IPK dilakukan via edit -->
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-4 flex max-w-md">
            <input type="text" name="q" value="{{ old('q', $q ?? '') }}" class="w-full border rounded-l px-3 py-2"
                placeholder="Cari NIM atau Nama...">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r">Cari</button>
        </form>

        <div class="overflow-x-auto">
            <table id="ipkTable"
                class="min-w-full bg-white border border-gray-300 border-separate border-spacing-0 rounded-xl shadow-lg overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-200 to-blue-100">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tl-xl border-b border-r border-gray-300">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            NIM</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Nama</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            Prodi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-b border-r border-gray-300">
                            IPK</th>
                        <th
                            class="px-6 py-3 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider rounded-tr-xl border-b border-gray-300">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $index => $mhs)
                        <tr class="even:bg-blue-50 hover:bg-blue-100 transition-colors">
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $mhs->nim }}</td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $mhs->user->nama ?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200">{{ $mhs->prodi->prodi_nama?? '-' }}
                            </td>
                            <td class="px-6 py-3 text-gray-700 border-b border-r border-gray-200"
                                id="ipk-cell-{{$mhs->mahasiswa_id}}">{{ $mhs->ipk ?? '-' }}</td>
                            <td class="px-6 py-3 text-center border-b border-gray-200">
                                <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded openIpkModalBtn"
                                    data-id="{{ $mhs->mahasiswa_id }}" data-nim="{{ $mhs->nim }}"
                                    data-nama="{{ $mhs->user->nama ?? '-' }}" data-prodi="{{ $mhs->prodi->prodi_nama ?? '-' }}"
                                    data-ipk="{{ $mhs->ipk }}">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-3 text-center text-gray-500">Tidak ada data mahasiswa</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Edit IPK --}}
    <div id="ipkModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-700">Edit IPK Mahasiswa</h3>
                <button type="button" id="closeIpkModal" class="text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
            </div>
            <form id="ipkForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="modal_mahasiswa_id" name="mahasiswa_id">
                <div class="mb-2">
                    <b>NIM:</b> <span id="modal_nim"></span><br>
                    <b>Nama:</b> <span id="modal_nama"></span><br>
                    <b>Prodi:</b> <span id="modal_prodi"></span>
                </div>
                <div class="mb-4">
                    <label for="modal_ipk" class="block text-gray-700 mb-1">IPK</label>
                    <input type="number" step="0.01" min="0" max="4" name="ipk" id="modal_ipk"
                        class="w-full border border-gray-300 rounded px-3 py-2" required>
                    <div id="modal_ipk_error" class="text-red-600 text-sm mt-1 hidden"></div>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelIpkModal"
                        class="mr-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        $(document).ready(function () {
            $('#ipkTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                }
            });
        });
    </script>

    <script>
        // Modal open/close functionality
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("ipkModal");
            const closeModalBtn = document.getElementById("closeIpkModal");
            const cancelModalBtn = document.getElementById("cancelIpkModal");
            const ipkForm = document.getElementById("ipkForm");
            let currentId = null;

            // Open modal and fill data
            document.querySelectorAll(".openIpkModalBtn").forEach(btn => {
                btn.addEventListener("click", () => {
                    currentId = btn.getAttribute("data-id");
                    document.getElementById("modal_mahasiswa_id").value = currentId;
                    document.getElementById("modal_nim").innerText = btn.getAttribute("data-nim") || '-';
                    document.getElementById("modal_nama").innerText = btn.getAttribute("data-nama") || '-';
                    document.getElementById("modal_prodi").innerText = btn.getAttribute("data-prodi") || '-';
                    document.getElementById("modal_ipk").value = btn.getAttribute("data-ipk") || '';
                    document.getElementById("modal_ipk_error").classList.add('hidden');
                    modal.classList.remove("hidden");
                    modal.classList.add("flex");
                });
            });

            // Close modal
            function closeModal() {
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            }
            closeModalBtn.addEventListener("click", closeModal);
            cancelModalBtn.addEventListener("click", closeModal);
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // AJAX submit IPK update
            ipkForm.addEventListener("submit", function (e) {
                e.preventDefault();
                const id = document.getElementById("modal_mahasiswa_id").value;
                const ipk = document.getElementById("modal_ipk").value;
                const token = document.querySelector('input[name="_token"]').value;

                fetch(`{{ url('admin/ipk') }}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ ipk })
                })
                    .then(async response => {
                        if (response.status === 422) {
                            const data = await response.json();
                            let msg = data.errors && data.errors.ipk ? data.errors.ipk.join(', ') : 'Validasi gagal';
                            document.getElementById("modal_ipk_error").innerText = msg;
                            document.getElementById("modal_ipk_error").classList.remove('hidden');
                            return;
                        }
                        if (!response.ok) throw new Error(await response.text());
                        return response.json();
                    })
                    .then(data => {
                        if (data && data.success) {
                            document.getElementById(`ipk-cell-${id}`).innerText = ipk;
                            closeModal();
                        }
                    })
                    .catch(err => {
                        document.getElementById("modal_ipk_error").innerText = "Gagal menyimpan data.";
                        document.getElementById("modal_ipk_error").classList.remove('hidden');
                    });
            });
        });
    </script>
@endsection