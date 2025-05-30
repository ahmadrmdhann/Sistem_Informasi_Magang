<nav class="sticky top-0 z-10 bg-white shadow-sm">
    <div class="container flex items-center justify-between h-16 px-4 mx-auto md:px-6">
        <a href="{{ url('/') }}" class="flex items-center focus:outline-none" aria-label="Beranda">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 mr-3">
        </a>
        <div class="hidden md:flex items-center justify-center flex-1 mx-auto">
            <div class="flex items-center space-x-6 ml-26">
                <a href="{{ url('/') }}" class="text-sm font-medium hover:text-blue-600 transition-colors">
                    Beranda
                </a>
                <a href="#fitur" class="text-sm font-medium hover:text-blue-600 transition-colors">
                    Fitur
                </a>
                <a href="#tentang" class="text-sm font-medium hover:text-blue-600 transition-colors">
                    Tentang
                </a>
                <a href="#kontak" class="text-sm font-medium hover:text-blue-600 transition-colors">
                    Kontak
                </a>
            </div>
        </div>
        <div class="flex items-center space-x-2">
            @if (!Auth::check())
                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm border rounded-md border-gray-300 hover:bg-gray-100">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Daftar Sekarang!
                </a>
            @else
                <div class="relative ml-0 md:ml-4 group">
                    <button id="user-menu-button"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-800 rounded-full shadow hover:shadow-md hover:bg-blue-50 hover:text-blue-700 transition-all duration-150 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400"
                        aria-haspopup="true" aria-expanded="false">
                        <span
                            class="flex items-center justify-center w-9 h-9 bg-blue-600 text-white rounded-full mr-2 shadow-inner">
                            <i class="fa-solid fa-circle-user text-lg"></i>
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="user-dropdown"
                        class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-2xl hidden z-50 animate-fade-in overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-blue-50 flex items-center gap-2">
                            <span
                                class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full shadow-inner">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span
                                class="truncate max-w-[120px] font-semibold text-gray-800">{{ Auth::user()->username }}</span>
                        </div>
                        <a href="{{ url('/dashboard')}}"
                            class="block px-5 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition font-semibold">Dashboard</a>
                        <form method="GET" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-5 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition font-semibold">Logout</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <button id="navbar-toggle" class="md:hidden text-gray-700 focus:outline-none absolute right-4 top-4"
        aria-label="Toggle menu">
        <i class="fas fa-bars text-2xl"></i>
    </button>
    <div id="mobile-menu" class="md:hidden hidden px-4 py-2 bg-white border-t">
        <a href="{{ url('/') }}" class="block py-2 text-sm font-medium hover:text-blue-600">
            Beranda
        </a>
        <a href="#fitur" class="block py-2 text-sm font-medium hover:text-blue-600">
            Fitur
        </a>
        <a href="#tentang" class="block py-2 text-sm font-medium hover:text-blue-600">
            Tentang
        </a>
        <a href="#kontak" class="block py-2 text-sm font-medium hover:text-blue-600">
            Kontak
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dropdown toggle untuk profil user
            const btn = document.getElementById('user-menu-button');
            const dropdown = document.getElementById('user-dropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function () {
                    dropdown.classList.add('hidden');
                });
            }

            // Toggle untuk menu mobile
            const navbarToggle = document.getElementById('navbar-toggle');
            const mobileMenu = document.getElementById('mobile-menu');

            if (navbarToggle && mobileMenu) {
                navbarToggle.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</nav>