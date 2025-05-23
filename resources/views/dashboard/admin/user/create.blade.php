{{-- resources/views/dashboard/admin/user/create.blade.php --}}
@extends('layouts.dashboard')

@section('title')
    <title>Tambah User</title>
@endsection

@section('content')
    <div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
        <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Tambah User</h2>
            <form id="form-create-user" action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Username</label>
                    <input type="text" name="username" class="w-full border rounded px-3 py-2 focus:outline-blue-400"
                        value="{{ old('username') }}" required>
                    @error('username') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Nama</label>
                    <input type="text" name="nama" class="w-full border rounded px-3 py-2 focus:outline-blue-400"
                        value="{{ old('nama') }}">
                    @error('nama') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Level</label>
                    <select name="level_id" class="w-full border rounded px-3 py-2 focus:outline-blue-400" required>
                        <option value="">- Pilih Level -</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                {{ $level->level_nama }}</option>
                        @endforeach
                    </select>
                    @error('level_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:outline-blue-400"
                        value="{{ old('email') }}" required>
                    @error('email') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-blue-400"
                        required>
                    @error('password') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border rounded px-3 py-2 focus:outline-blue-400" required>
                </div>
                <div class="mb-4">
                    <label class="block font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2 focus:outline-blue-400" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <a href="{{ route('user.index') }}"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">Batal</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
                        <i class="fas fa-save mr-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#form-create-user').on('submit', function (e) {
            e.preventDefault(); 
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function (res) {
                    if (res.status) {
                        Swal.fire('Berhasil', res.message, 'success').then(() => {
                            window.location.href = "{{ url('admin/user') }}";
                        });
                    } else {
                        Swal.fire('Gagal', res.message || 'Validasi gagal', 'error');
                    }
                },
                error: function (xhr) {
                    let msg = 'Terjadi kesalahan server';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    Swal.fire('Gagal', msg, 'error');
                }
            });
        });
    </script>
@endsection