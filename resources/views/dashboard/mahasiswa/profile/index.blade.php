@extends('layouts.dashboard')

@section('content')
    <div id="mainContent"
        class="p-3 sm:p-6 transition-all duration-300 ml-0 sm:ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-100">
        <div class="container mx-auto px-2 sm:px-4">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 sm:mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Profil Saya</h1>
                <p class="text-sm sm:text-base text-gray-600">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-4 sm:gap-8">
                <!-- Left Column - User Photo -->
                <div class="w-full lg:w-1/4">
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 transition hover:shadow-md">
                        <div class="flex flex-col items-center">
                            <div class="relative w-28 h-28 sm:w-40 sm:h-40 mb-3 sm:mb-4 group">
                                @if($mahasiswa->foto_profil)
                                    <img class="w-full h-full rounded-full object-cover border-4 border-white shadow-md"
                                        src="{{ asset($mahasiswa->foto_profil) }}" alt="Profile Image">
                                @else
                                    <div
                                        class="w-full h-full rounded-full bg-gray-300 border-4 border-white shadow-md flex items-center justify-center">
                                        <i class="fas fa-user text-gray-500 text-3xl sm:text-5xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300 cursor-pointer"
                                    onclick="document.getElementById('photoInput').click()">
                                    <span class="text-white text-xs sm:text-sm font-medium">Ubah Foto</span>
                                </div>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mt-1 sm:mt-2 text-center">
                                {{ Auth::user()->nama }}
                            </h2>
                            <p class="text-sm text-gray-500 mb-3 sm:mb-4">{{ $mahasiswa->nim ?? 'NIM belum diisi' }}</p>

                            <!-- Photo Upload Form -->
                            <form id="photoForm" action="{{ route('mahasiswa.profile.photo.update') }}" method="POST"
                                enctype="multipart/form-data" class="w-full">
                                @csrf
                                <input type="file" id="photoInput" name="foto_profil" accept="image/*" class="hidden"
                                    onchange="confirmPhotoUpload()">
                                <button type="button" onclick="document.getElementById('photoInput').click()"
                                    class="bg-blue-500 text-white rounded-lg py-2 px-3 sm:py-3 sm:px-4 w-full hover:bg-blue-600 transition shadow-sm font-medium text-xs sm:text-sm">
                                    <i class="fas fa-camera mr-1 sm:mr-2"></i>Ganti Foto Profil
                                </button>
                            </form>
                            @error('foto_profil')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <!-- Display current photo info -->
                            @if($mahasiswa->foto_profil)
                                <p class="text-xs text-gray-500 mt-2 text-center">
                                    Foto terakhir diupload:<br>
                                    {{ basename($mahasiswa->foto_profil) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - User Information -->
                <div class="w-full lg:w-3/4 mt-4 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Tabs Navigation -->
                        <div class="border-b">
                            <div class="flex">
                                <button id="editProfileTab"
                                    class="tab-button relative px-4 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-medium transition focus:outline-none"
                                    onclick="showTab('profileForm')">
                                    <span>Edit Profil</span>
                                    <span id="profileTabIndicator"
                                        class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500"></span>
                                </button>
                                <button id="editPasswordTab"
                                    class="tab-button relative px-4 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-medium transition focus:outline-none"
                                    onclick="showTab('passwordForm')">
                                    <span>Ubah Password</span>
                                    <span id="passwordTabIndicator"
                                        class="absolute bottom-0 left-0 w-full h-0.5 bg-transparent"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Profile Edit Form -->
                        <div id="profileForm" class="p-4 sm:p-8 tab-content">
                            <form action="{{ route('mahasiswa.profile.update') }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
                                    <div class="space-y-3 sm:space-y-5">
                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Username <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="username"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('username') border-red-500 @enderror"
                                                value="{{ old('username', Auth::user()->username) }}" required>
                                            @error('username')
                                                <p class="text-red-500 text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Jurusan <span
                                                    class="text-red-500">*</span></label>
                                            <select name="prodi_id"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('prodi_id') border-red-500 @enderror"
                                                required>
                                                <option value="">Pilih Jurusan</option>
                                                @foreach($prodis as $prodi)
                                                    <option value="{{ $prodi->prodi_id }}" {{ old('prodi_id', $mahasiswa->prodi_id) == $prodi->prodi_id ? 'selected' : '' }}>
                                                        {{ $prodi->prodi_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('prodi_id')
                                                <p class="text-red-500 text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">NIM <span
                                                    class="text-red-500">*</span></label>
                                            <input type="number" name="nim"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('nim') border-red-500 @enderror"
                                                value="{{ old('nim', $mahasiswa->nim) }}" required>
                                            @error('nim')
                                                <p class="text-red-500 text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">No.
                                                Telepon</label>
                                            <input type="text" name="no_telepon"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('no_telepon') border-red-500 @enderror"
                                                value="{{ old('no_telepon', $mahasiswa->no_telepon) }}"
                                                placeholder="08123456789">
                                            @error('no_telepon')
                                                <p class="text-red-500 text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="space-y-3 sm:space-y-5">
                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Nama Lengkap
                                                <span class="text-red-500">*</span></label>
                                            <input type="text" name="nama"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('nama') border-red-500 @enderror"
                                                value="{{ old('nama', Auth::user()->nama) }}" required>
                                            @error('nama')
                                                <p class="text-red-500 text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Email <span
                                                    class="text-red-500">*</span></label>
                                            <input type="email" name="email"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                                                value="{{ old('email', Auth::user()->email) }}" required>
                                            @error('email')
                                                <p class="text-red-500 text-xs">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label
                                                class="block text-xs sm:text-sm font-medium text-gray-700">Keahlian</label>
                                            <select name="keahlian_id"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition">
                                                <option value="">Pilih Keahlian</option>
                                                @foreach($keahlian as $k)
                                                    <option value="{{ $k->keahlian_id }}" {{ old('keahlian_id', $mahasiswa->keahlian_id) == $k->keahlian_id ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Minat</label>
                                            <select name="minat_id"
                                                class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition">
                                                <option value="">Pilih Minat</option>
                                                @foreach($keahlian as $k)
                                                    <option value="{{ $k->keahlian_id }}" {{ old('minat_id', $mahasiswa->minat_id) == $k->keahlian_id ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Tentang
                                            Saya</label>
                                        <textarea name="tentang_saya" rows="4"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition"
                                            placeholder="Ceritakan tentang diri Anda...">{{ old('tentang_saya', $mahasiswa->tentang_saya) }}</textarea>
                                    </div>

                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Lokasi
                                            Preferensi</label>
                                        <select name="lokasi_preferensi"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('lokasi_preferensi') border-red-500 @enderror">
                                            <option value="">Pilih Lokasi Preferensi</option>
                                            @foreach($kotaKabupaten as $kota)
                                                <option value="{{ $kota->kabupaten_id }}" {{ old('lokasi_preferensi', $mahasiswa->lokasi_preferensi) == $kota->kabupaten_id ? 'selected' : '' }}>
                                                    {{ $kota->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('lokasi_preferensi')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Upload CV
                                            (PDF)</label>
                                        <input type="file" name="cv_file" accept=".pdf"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition">
                                        @if($mahasiswa->cv_file)
                                            <div class="mt-2 p-2 bg-gray-50 rounded-lg">
                                                <p class="text-xs text-gray-600 flex items-center">
                                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                                    File CV saat ini:
                                                    <a href="{{ asset($mahasiswa->cv_file) }}" target="_blank"
                                                        class="text-blue-600 hover:underline ml-1">
                                                        {{ basename($mahasiswa->cv_file) }}
                                                    </a>
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-xs text-gray-500 mt-1">Belum ada file CV yang diupload</p>
                                        @endif
                                        @error('cv_file')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Upload
                                            Sertifikat</label>
                                        <input type="file" name="sertifikat_file" accept=".pdf,.jpg,.jpeg,.png"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('sertifikat_file') border-red-500 @enderror">
                                        @if($mahasiswa->sertifikat_file)
                                            <div class="mt-2 p-2 bg-gray-50 rounded-lg">
                                                <p class="text-xs text-gray-600 flex items-center">
                                                    <i class="fas fa-certificate text-yellow-500 mr-2"></i>
                                                    File sertifikat saat ini:
                                                    <a href="{{ asset($mahasiswa->sertifikat_file) }}" target="_blank"
                                                        class="text-blue-600 hover:underline ml-1">
                                                        {{ basename($mahasiswa->sertifikat_file) }}
                                                    </a>
                                                </p>
                                            </div>
                                        @else
                                            <p class="text-xs text-gray-500 mt-1">Belum ada file sertifikat yang diupload</p>
                                        @endif
                                        @error('sertifikat_file')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end mt-4 sm:mt-8 border-t pt-4 sm:pt-6">
                                    <button type="submit"
                                        class="bg-blue-500 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg hover:bg-blue-600 transition shadow-sm font-medium text-sm flex items-center">
                                        <i class="fas fa-save mr-1 sm:mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Password Change Form -->
                        <div id="passwordForm" class="p-4 sm:p-8 tab-content hidden">
                            <form action="{{ route('mahasiswa.profile.password.update') }}" method="POST"
                                class="max-w-md mx-auto space-y-4 sm:space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="space-y-3 sm:space-y-5">
                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Password Saat Ini
                                            <span class="text-red-500">*</span></label>
                                        <input type="password" name="current_password"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('current_password') border-red-500 @enderror"
                                            required>
                                        @error('current_password')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Password Baru
                                            <span class="text-red-500">*</span></label>
                                        <input type="password" name="password"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                                            required>
                                        @error('password')
                                            <p class="text-red-500 text-xs">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Konfirmasi
                                            Password <span class="text-red-500">*</span></label>
                                        <input type="password" name="password_confirmation"
                                            class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition"
                                            required>
                                    </div>

                                    <div class="flex justify-end mt-4 sm:mt-8 border-t pt-4 sm:pt-6">
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg hover:bg-blue-600 transition shadow-sm font-medium text-sm flex items-center">
                                            <i class="fas fa-key mr-1 sm:mr-2"></i> Ubah Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Reset tab indicators
            document.getElementById('profileTabIndicator').classList.remove('bg-blue-500');
            document.getElementById('profileTabIndicator').classList.add('bg-transparent');
            document.getElementById('passwordTabIndicator').classList.remove('bg-blue-500');
            document.getElementById('passwordTabIndicator').classList.add('bg-transparent');

            document.getElementById('editProfileTab').classList.remove('text-blue-600', 'font-semibold');
            document.getElementById('editPasswordTab').classList.remove('text-blue-600', 'font-semibold');

            // Show selected tab content
            document.getElementById(tabId).classList.remove('hidden');

            // Highlight active tab
            if (tabId === 'profileForm') {
                document.getElementById('profileTabIndicator').classList.add('bg-blue-500');
                document.getElementById('profileTabIndicator').classList.remove('bg-transparent');
                document.getElementById('editProfileTab').classList.add('text-blue-600', 'font-semibold');
            } else {
                document.getElementById('passwordTabIndicator').classList.add('bg-blue-500');
                document.getElementById('passwordTabIndicator').classList.remove('bg-transparent');
                document.getElementById('editPasswordTab').classList.add('text-blue-600', 'font-semibold');
            }
        }

        function confirmPhotoUpload() {
            const fileInput = document.getElementById('photoInput');
            const file = fileInput.files[0];

            if (file) {
                // Check file size (2MB limit)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    fileInput.value = '';
                    return;
                }

                // Check file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPEG, JPG, atau PNG.');
                    fileInput.value = '';
                    return;
                }

                // Show loading state
                const button = document.querySelector('#photoForm button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengupload...';
                button.disabled = true;

                // Submit form
                document.getElementById('photoForm').submit();
            }
        }

        // Initialize the first tab as active
        document.addEventListener('DOMContentLoaded', function () {
            showTab('profileForm');

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('[class*="bg-green-100"], [class*="bg-red-100"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });
    </script>
@endsection
