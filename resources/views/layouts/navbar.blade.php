<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/Sistem_Informasi_Magang/resources/views/layouts/navbar.blade.php -->
<nav class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}"
            class="flex items-center gap-2 text-2xl font-extrabold text-blue-700 tracking-tight hover:text-blue-800 transition">
            <img src="" alt="">
            Sisforma
        </a>
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ url('/') }}"
                class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg font-medium transition">Beranda</a>
            <a href="#features"
                class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg font-medium transition">Fitur</a>
            <a href="#about"
                class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg font-medium transition">Tentang</a>
            <a href="{{ route('lowongan.index') }}"
                class="text-gray-700 hover:text-blue-600 px-4 py-2 rounded-lg font-medium transition">Lowongan</a>
        </div>
        <div class="hidden md:flex items-center gap-4">
            @if (Auth::check())
                <div class="relative group" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 focus:outline-none px-3 py-2 rounded-lg hover:bg-blue-50 transition">
                        @if (Auth::user()->image)
                            <img src="{{ Auth::user()->image }}" alt="Profile"
                                class="w-9 h-9 rounded-full object-cover border-2 border-blue-200 shadow">
                        @else
                            <span class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-100 border-2 border-blue-200 shadow">
                                <i class="fa-solid fa-user text-blue-500 text-xl"></i>
                            </span>
                        @endif
                        <span class="font-semibold text-gray-800">{{ Auth::user()->nama }}</span>
                        <i class="fa-solid fa-chevron-down text-blue-600 transition-transform" 
                           :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div class="absolute right-0 mt-2 bg-white rounded-xl shadow-2xl py-2 z-50 border border-blue-100 transition-all duration-200"
                         :class="{ 'opacity-100 visible': open, 'opacity-0 invisible': !open }">
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition rounded-lg font-medium">
                            <i class="fa-solid fa-gauge text-lg"></i>
                            Dashboard
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="mt-1">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2 w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition rounded-lg font-medium">
                                <i class="fa-solid fa-right-from-bracket text-lg"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                    class="ml-4 px-4 py-2 rounded-lg font-semibold text-blue-600 border border-blue-600 bg-white shadow hover:bg-blue-50 transition">Masuk</a>
                <a href="{{ route('register') }}"
                    class="ml-2 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow hover:bg-blue-700 transition">Mulai
                    Sekarang</a>
            @endif
        </div>
        <div class="md:hidden flex items-center">
            <button id="mobile-menu-button" class="text-blue-700 focus:outline-none">
                <i class="fa-solid fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Tambahkan Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</nav>