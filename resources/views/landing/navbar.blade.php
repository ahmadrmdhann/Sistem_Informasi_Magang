<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100 transition-all duration-300"
    id="main-navbar">
    <div class="container flex items-center justify-between h-16 px-4 mx-auto md:px-6">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center focus:outline-none group" aria-label="Beranda">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo"
                class="h-8 mr-3 transition-transform duration-200 group-hover:scale-105">
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center justify-center flex-1 mx-auto">
            <div class="flex items-center space-x-8">
                <a href="{{ url('/') }}"
                    class="nav-link text-sm font-medium hover:text-blue-600 transition-all duration-200 relative group">
                    Beranda
                    <span
                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
                </a>
                <a href="#fitur"
                class="nav-link text-sm font-medium hover:text-blue-600 transition-all duration-200 relative group">
                Fitur
                <span
                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
            </a>
            <a href="#tentang"
                class="nav-link text-sm font-medium hover:text-blue-600 transition-all duration-200 relative group">
                Tentang
                <span
                    class="absolute -bottom-1 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-200 group-hover:w-full"></span>
            </a>
            </div>
        </div>

        <!-- Auth Buttons / User Menu -->
        <div class="flex items-center space-x-3">
            @if (!Auth::check())
                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm border rounded-lg border-gray-300 hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 font-medium">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    Daftar Sekarang!
                </a>
            @else
                <div class="relative ml-0 md:ml-4 group">
                    <button id="user-menu-button"
                        class="flex items-center gap-2 px-4 py-2 bg-white text-gray-800 rounded-xl shadow-md hover:shadow-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 border border-gray-200"
                        aria-haspopup="true" aria-expanded="false">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-sm">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <span class="hidden sm:block max-w-24 truncate">{{ Auth::user()->username }}</span>
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="user-dropdown"
                        class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-2xl hidden z-50 overflow-hidden transform opacity-0 scale-95 transition-all duration-200">
                        <div class="px-4 py-3 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center gap-3">
                                <span
                                    class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-sm">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-800 truncate max-w-32">{{ Auth::user()->username }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'User' }}</p>
                                </div>
                            </div>
                        </div>
                        <a href="{{ url('/dashboard')}}"
                            class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 font-medium">
                            <i class="fa-solid fa-tachometer-alt mr-3 text-blue-500"></i>
                            Dashboard
                        </a>
                        <form method="GET" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center text-left px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200 font-medium border-t border-gray-100">
                                <i class="fa-solid fa-sign-out-alt mr-3 text-red-500"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Mobile Menu Toggle -->
            <button id="navbar-toggle"
                class="md:hidden text-gray-700 focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200"
                aria-label="Toggle menu">
                <div class="w-6 h-6 flex flex-col justify-center items-center">
                    <span class="hamburger-line block w-5 h-0.5 bg-current transition-all duration-300"></span>
                    <span class="hamburger-line block w-5 h-0.5 bg-current mt-1 transition-all duration-300"></span>
                    <span class="hamburger-line block w-5 h-0.5 bg-current mt-1 transition-all duration-300"></span>
                </div>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden bg-white border-t border-gray-200 shadow-lg">
        <div class="px-4 py-2 space-y-1">
            <a href="{{ url('/') }}"
                class="block py-3 px-2 text-sm font-medium hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                Beranda
            </a>
            <a href="#fitur"
                class="block py-3 px-2 text-sm font-medium hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                Fitur
            </a>
            <a href="#tentang"
                class="block py-3 px-2 text-sm font-medium hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all duration-200">
                Tentang
            </a>
            @if (!Auth::check())
                <div class="pt-3 border-t border-gray-200 mt-3 space-y-2">
                    <a href="{{ route('login') }}"
                        class="block py-2 px-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="block py-2 px-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 text-center">
                        Daftar Sekarang!
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Mobile hamburger animation */
        #navbar-toggle.active .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(3px, 3px);
        }

        #navbar-toggle.active .hamburger-line:nth-child(2) {
            opacity: 0;
        }

        #navbar-toggle.active .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(3px, -3px);
        }

        /* Dropdown animation */
        #user-dropdown.show {
            display: block;
            opacity: 1;
            transform: scale(1);
        }

        /* Navbar scroll effect */
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Navbar scroll effect
            const navbar = document.getElementById('main-navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 10) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });

            // Dropdown toggle with improved animation
            const btn = document.getElementById('user-menu-button');
            const dropdown = document.getElementById('user-dropdown');

            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                    dropdown.classList.toggle('show');
                    btn.setAttribute('aria-expanded', !dropdown.classList.contains('hidden'));
                });

                document.addEventListener('click', function () {
                    dropdown.classList.add('hidden');
                    dropdown.classList.remove('show');
                    btn.setAttribute('aria-expanded', 'false');
                });
            }

            // Mobile menu toggle with hamburger animation
            const navbarToggle = document.getElementById('navbar-toggle');
            const mobileMenu = document.getElementById('mobile-menu');

            if (navbarToggle && mobileMenu) {
                navbarToggle.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                    navbarToggle.classList.toggle('active');
                });

                // Close mobile menu when clicking on a link
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        navbarToggle.classList.remove('active');
                    });
                });
            }

            // Active nav link highlighting
            const navLinks = document.querySelectorAll('.nav-link');
            const sections = document.querySelectorAll('section[id]');

            window.addEventListener('scroll', () => {
                const scrollPos = window.scrollY + 100;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
                        navLinks.forEach(link => {
                            link.classList.remove('text-blue-600');
                            if (link.getAttribute('href') === `#${sectionId}`) {
                                link.classList.add('text-blue-600');
                            }
                        });
                    }
                });
            });
        });
    </script>
</nav>
