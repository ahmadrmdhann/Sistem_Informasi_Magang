@extends('layouts.dashboard')

@section('content')
    <div id="mainContent" class="p-3 sm:p-6 transition-all duration-300 ml-0 sm:ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-100">
        <div class="container mx-auto px-2 sm:px-4">
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
                                <img class="w-full h-full rounded-full object-cover border-4 border-white shadow-md"
                                    src="{{ asset('path/to/profile/image.jpg') }}" alt="Profile Image">
                                <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition duration-300">
                                    <span class="text-white text-xs sm:text-sm font-medium">Ubah Foto</span>
                                </div>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-800 mt-1 sm:mt-2">{{ Auth::user()->nama }}</h2>
                            <p class="text-sm text-gray-500 mb-3 sm:mb-4">{{ $mahasiswa->nim }}</p>
                            <div class="w-full mt-1 sm:mt-2">
                                <form id="avatarForm" class="space-y-3 sm:space-y-4">
                                    <div class="flex mb-2 sm:mb-3">
                                        <input type="text" class="flex-grow border border-gray-300 rounded-l-lg p-2 sm:p-3 text-xs sm:text-sm focus:outline-none focus:ring-1 focus:ring-blue-500" readonly placeholder="Pilih file foto...">
                                        <button class="bg-gray-200 px-3 py-2 sm:px-4 sm:py-3 rounded-r-lg text-xs sm:text-sm text-gray-700 hover:bg-gray-300 transition">Browse</button>
                                    </div>
                                    <button class="bg-blue-500 text-white rounded-lg py-2 px-3 sm:py-3 sm:px-4 w-full hover:bg-blue-600 transition shadow-sm font-medium text-xs sm:text-sm">
                                        <i class="fas fa-camera mr-1 sm:mr-2"></i>Ganti Foto Profil
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - User Information -->
                <div class="w-full lg:w-3/4 mt-4 lg:mt-0">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <!-- Tabs Navigation -->
                        <div class="border-b">
                            <div class="flex">
                                <button id="editProfileTab" class="tab-button relative px-4 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-medium transition focus:outline-none" onclick="showTab('profileForm')">
                                    <span>Edit Profil</span>
                                    <span id="profileTabIndicator" class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-500"></span>
                                </button>
                                <button id="editPasswordTab" class="tab-button relative px-4 sm:px-8 py-3 sm:py-4 text-sm sm:text-base font-medium transition focus:outline-none" onclick="showTab('passwordForm')">
                                    <span>Ubah Password</span>
                                    <span id="passwordTabIndicator" class="absolute bottom-0 left-0 w-full h-0.5 bg-transparent"></span>
                                </button>
                            </div>
                        </div>

                        <!-- Profile Edit Form -->
                        <div id="profileForm" class="p-4 sm:p-8 tab-content">
                            <form action="{{ route('mahasiswa.profile.update') }}" method="POST" class="space-y-4 sm:space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-8">
                                    <div class="space-y-3 sm:space-y-5">
                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Username</label>
                                            <input type="text" name="username" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" value="{{ Auth::user()->username }}" required>
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Jurusan</label>
                                            <select name="prodi_id" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition">
                                                @foreach($prodis as $prodi)
                                                    <option value="{{ $prodi->id }}" {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>
                                                        {{ $prodi->prodi_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">NIM</label>
                                            <input type="text" name="nim" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" value="{{ $mahasiswa->nim }}" required>
                                        </div>
                                    </div>

                                    <div class="space-y-3 sm:space-y-5">
                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Nama Lengkap</label>
                                            <input type="text" name="nama" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" value="{{ Auth::user()->nama }}" required>
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" value="{{ Auth::user()->email }}" required>
                                        </div>
                                    </div>

                                    <div class="space-y-3 sm:space-y-5">
                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Keahlian</label>
                                            <select name="keahlian_id" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition">
                                                <option value="" {{ $mahasiswa->keahlian_id ? '' : 'selected' }}>Pilih Keahlian</option>
                                                @foreach($keahlian as $k)
                                                    <option value="{{ $k->keahlian_id }}" {{ $mahasiswa->keahlian_id == $k->keahlian_id ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="space-y-1 sm:space-y-2">
                                            <label class="block text-xs sm:text-sm font-medium text-gray-700">Minat</label>
                                            <select name="minat_id" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition">
                                                <option value="" {{ $mahasiswa->minat_id ? '' : 'selected' }}>Pilih Minat</option>
                                                @foreach($keahlian as $k)
                                                    <option value="{{ $k->keahlian_id }}" {{ $mahasiswa->minat_id == $k->keahlian_id ? 'selected' : '' }}>
                                                        {{ $k->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end mt-4 sm:mt-8 border-t pt-4 sm:pt-6">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg hover:bg-blue-600 transition shadow-sm font-medium text-sm flex items-center">
                                        <i class="fas fa-save mr-1 sm:mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Password Change Form -->
                        <div id="passwordForm" class="p-4 sm:p-8 tab-content hidden">
                            <form action="{{ route('mahasiswa.profile.password.update') }}" method="POST" class="max-w-md mx-auto space-y-4 sm:space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="space-y-3 sm:space-y-5">
                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Password Saat Ini</label>
                                        <input type="password" name="current_password" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" required>
                                    </div>

                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Password Baru</label>
                                        <input type="password" name="password" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" required>
                                    </div>

                                    <div class="space-y-1 sm:space-y-2">
                                        <label class="block text-xs sm:text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="w-full p-2 sm:p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200 focus:border-blue-500 transition" required>
                                    </div>

                                    <div class="flex justify-end mt-4 sm:mt-8 border-t pt-4 sm:pt-6">
                                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg hover:bg-blue-600 transition shadow-sm font-medium text-sm flex items-center">
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

// Initialize the first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showTab('profileForm');
});
</script>
@endsection
