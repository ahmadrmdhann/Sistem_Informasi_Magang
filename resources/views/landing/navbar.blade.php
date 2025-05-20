<nav class="bg-white border-b border-gray-200 px-4 py-2.5 sticky top-0 z-50 shadow-sm">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
        <a href="{{ url('/') }}" class="flex items-center focus:outline-none" aria-label="Beranda">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="h-8 mr-3">
        </a>
        <button id="navbar-toggle" class="md:hidden text-gray-700 focus:outline-none" aria-label="Toggle menu">
            <i class="fas fa-bars text-2xl"></i>
        </button>
        <div id="navbar-menu" class="flex-col md:flex-row flex md:flex items-center w-full md:w-auto hidden">
            <a href="{{ url('/')}}" class="text-gray-700 hover:text-blue-600 px-3 py-2 transition focus:outline-none">Beranda</a>
            <a href="#features"
                class="text-gray-700 hover:text-blue-600 px-3 py-2 transition focus:outline-none">Fitur</a>
            <a href="#about"
                class="text-gray-700 hover:text-blue-600 px-3 py-2 transition focus:outline-none">Tentang</a>
            <a href="#contact"
                class="text-gray-700 hover:text-blue-600 px-3 py-2 transition focus:outline-none">Kontak</a>
            @if (!Auth::check())
                <a href="{{ route('login') }}"
                    class="ml-0 md:ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold focus:outline-none">Masuk</a>
                <a href="{{ route('register') }}"
                    class="ml-0 md:ml-4 mt-2 md:mt-0 px-4 py-2 bg-white text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold focus:outline-none">Daftar
                    Sekarang!</a>
            @else
                <div class="relative ml-0 md:ml-4 group">
                    <button id="user-menu-button" class="flex items-center gap-2 px-4 py-2 bg-white text-gray-800 rounded-full shadow hover:shadow-md hover:bg-blue-50 hover:text-blue-700 transition-all duration-150 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400" aria-haspopup="true" aria-expanded="false">
                        <span class="flex items-center justify-center w-9 h-9 bg-blue-600 text-white rounded-full mr-2 shadow-inner">
                            <i class="fa-solid fa-circle-user text-lg"></i>
                        </span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="user-dropdown" class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-2xl hidden z-50 animate-fade-in overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-blue-50 flex items-center gap-2">
                            <span class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full shadow-inner">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <span class="truncate max-w-[120px] font-semibold text-gray-800">{{ Auth::user()->username }}</span>
                        </div>
                        <a href="{{ url('/dashboard')}}" class="block px-5 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-700 transition font-semibold">Dashboard</a>
                        <form method="GET" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-5 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition font-semibold">Logout</button>
                        </form>
                    </div>
                </div>
                <style>
                    @keyframes fade-in {
                        from { opacity: 0; transform: translateY(-10px);}
                        to { opacity: 1; transform: translateY(0);}
                    }
                    .animate-fade-in {
                        animation: fade-in 0.2s ease;
                    }
                </style>
                <script>
                    // Dropdown toggle
                    document.addEventListener('DOMContentLoaded', function () {
                        const btn = document.getElementById('user-menu-button');
                        const dropdown = document.getElementById('user-dropdown');
                        btn.addEventListener('click', function (e) {
                            e.stopPropagation();
                            dropdown.classList.toggle('hidden');
                        });
                        document.addEventListener('click', function () {
                            dropdown.classList.add('hidden');
                        });
                    });
                </script>
            @endif
        </div>
    </div>
    <script>
        // Simple mobile menu toggle
        document.getElementById('navbar-toggle').onclick = function () {
            var menu = document.getElementById('navbar-menu');
            menu.classList.toggle('hidden');
        };
    </script>
</nav>
