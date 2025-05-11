<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sisforma</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/landing/script.js')
    @vite('resources/css/landing/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body class="bg-gray-50">
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="#"
                class="flex items-center gap-2 text-2xl font-extrabold text-blue-700 tracking-tight hover:text-blue-800 transition">
                <img src="" alt="">
                Sisforma
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="#"
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
                    <div class="relative group">
                        <button
                            class="flex items-center gap-2 focus:outline-none px-3 py-2 rounded-lg hover:bg-blue-50 transition">
                            @if (Auth::user()->image)
                                <img src="{{ Auth::user()->image }}" alt="Profile"
                                    class="w-9 h-9 rounded-full object-cover border-2 border-blue-200 shadow">
                            @else
                                <span
                                    class="w-9 h-9 flex items-center justify-center rounded-full bg-blue-100 border-2 border-blue-200 shadow">
                                    <i class="fa-solid fa-user text-blue-500 text-xl"></i>
                                </span>
                            @endif
                            <span class="font-semibold text-gray-800">{{ Auth::user()->nama }}</span>
                            <i
                                class="fa-solid fa-chevron-down text-blue-600 transition-transform group-[.open]:rotate-180"></i>
                        </button>
                        <div
                            class="absolute right-0 mt-2 bg-white rounded-xl shadow-2xl py-2 z-50 border border-blue-100 opacity-0 pointer-events-none group-[.open]:opacity-100 group-[.open]:pointer-events-auto transition-all duration-200">
                            <div class="px-4 py-3 border-b border-gray-100 mb-2 flex items-center gap-3">
                                @if (Auth::user()->image)
                                    <img src="{{ Auth::user()->image }}" alt="Profile"
                                        class="w-10 h-10 rounded-full object-cover border-2 border-blue-200 shadow">
                                @else
                                    <span
                                        class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 border-2 border-blue-200 shadow">
                                        <i class="fa-solid fa-user text-blue-500 text-xl"></i>
                                    </span>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-900 leading-tight">
                                        {{ Auth::user()->nama }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
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
        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4 space-y-2">
            <a href="#"
                class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Beranda</a>
            <a href="#features"
                class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Fitur</a>
            <a href="#about"
                class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Tentang</a>

            <div class="border-t border-gray-100 my-3"></div>

            @if (Auth::check())
                <div class="py-2">
                    <div class="flex items-center gap-3 px-4 py-2 mb-2">
                        @if (Auth::user()->image)
                            <img src="{{ Auth::user()->image }}" alt="Profile"
                                class="w-8 h-8 rounded-full object-cover border border-gray-200">
                        @else
                            <span
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 border border-blue-200">
                                <i class="fa-solid fa-user text-blue-500"></i>
                            </span>
                        @endif
                        <span class="font-medium text-gray-800">{{ Auth::user()->nama }}</span>
                    </div>
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">
                        <i class="fa-solid fa-gauge mr-2"></i>Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">
                            <i class="fa-solid fa-right-from-bracket mr-2"></i>Keluar
                        </button>
                    </form>
                </div>
            @else
                <div class="flex flex-col space-y-2 mt-3">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-lg font-semibold text-blue-600 border border-blue-600 bg-white shadow hover:bg-blue-50 transition text-center">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow hover:bg-blue-700 transition text-center">Mulai
                        Sekarang</a>
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="hero-bg container mx-auto px-4 py-16 md:py-20 flex flex-col md:flex-row items-center rounded-b-3xl shadow animate-fade-in">
        <div class="md:w-1/2 mb-10 md:mb-0 md:pr-8">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 animate-fade-in"
                style="animation-delay:0.2s;">
                Sistem Informasi Magang
            </h1>
            <p class="text-lg text-gray-700 mb-8 animate-fade-in" style="animation-delay:0.4s;">
                Temukan peluang magang yang dirancang khusus untuk Anda — sesuai minat, keahlian, dan lokasi. Bangun
                karier impian Anda mulai dari sini.
            </p>
            <div class="flex flex-wrap gap-4 animate-fade-in" style="animation-delay:0.6s;">
                <a href="{{ route('register') }}"
                    class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-700 transition">
                    Mulai Sekarang
                </a>
                <a href="#features"
                    class="inline-block bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded-lg font-semibold shadow hover:bg-blue-50 transition">
                    Lihat Fitur
                </a>
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80"
                alt="Internship" class="rounded-lg shadow-lg w-full max-w-md object-cover animate-fade-in"
                style="animation-delay:0.8s;">
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="container mx-auto px-4 py-24">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Fitur Unggulan</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <div
                class="feature-card bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300 flex flex-col h-full">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-location-crosshairs text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <h3 class="font-semibold text-xl mb-3">Rekomendasi Magang</h3>
                <p class="text-gray-600 flex-grow">Sistem cerdas memberikan rekomendasi magang yang paling relevan
                    sesuai dengan
                    profil, minat, dan keahlian Anda.</p>
            </div>
            <div
                class="feature-card bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300 flex flex-col h-full">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-regular fa-user text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <h3 class="font-semibold text-xl mb-3">Dashboard Personal</h3>
                <p class="text-gray-600 flex-grow">Pantau status lamaran, jadwal interview, dan seluruh progress magang
                    Anda
                    secara real-time melalui dashboard personal.</p>
            </div>
            <div
                class="feature-card bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300 flex flex-col h-full sm:col-span-2 md:col-span-1">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-chalkboard-user text-blue-600 text-3xl"></i>
                    </div>
                </div>
                <h3 class="font-semibold text-xl mb-3">Bimbingan Aktif</h3>
                <p class="text-gray-600 flex-grow">Dapatkan arahan langsung dari dosen pembimbing yang ditugaskan untuk
                    memantau,
                    mengevaluasi, dan membimbing setiap langkah magang Anda.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="container mx-auto px-4 py-24">
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-3xl shadow-lg p-10 md:p-16 max-w-4xl mx-auto">
            <h2
                class="text-3xl md:text-4xl font-extrabold text-center text-blue-700 mb-8 tracking-tight animate-fade-in">
                Tentang Sisforma
            </h2>
            <div class="max-w-3xl mx-auto text-center text-gray-700 text-lg leading-relaxed animate-fade-in"
                style="animation-delay:0.2s;">
                <p class="mb-6">
                    <span class="font-semibold text-blue-600">Sisforma</span> adalah platform Sistem Informasi Magang
                    yang dirancang untuk memudahkan mahasiswa dalam
                    menemukan, melamar, dan mengelola program magang sesuai minat dan keahlian. Kami berkomitmen untuk
                    menjadi jembatan antara mahasiswa, universitas, dan dunia industri melalui fitur-fitur inovatif dan
                    kemudahan akses informasi.
                </p>
                <p>
                    Dengan <span class="font-semibold text-blue-600">Sisforma</span>, proses magang menjadi lebih
                    terstruktur, transparan, dan terpantau secara real-time.
                    Kami percaya, pengalaman magang yang baik adalah langkah awal menuju karir yang sukses.
                </p>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section py-16 text-center text-white mx-auto px-4">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Memulai Karir Impian Anda?</h2>
            <p class="mb-8 text-lg max-w-2xl mx-auto">
                Gabung bersama ribuan mahasiswa lain yang telah sukses menemukan magang terbaik mereka.
            </p>
            <a href="{{ route('register') }}"
                class="inline-block bg-white text-blue-700 px-8 py-3 rounded-lg font-bold shadow hover:bg-blue-100 transition">
                Daftar Sekarang
            </a>
        </div>
    </section>

    <footer class="bg-gray-700 mt-20">
        <div
            class="container mx-auto px-4 py-14 flex flex-col md:flex-row gap-10 md:gap-0 justify-between items-center md:items-start">
            <!-- Contact Info -->
            <div class="w-full md:w-1/2 mb-8 md:mb-0">
                <h3 class="text-3xl font-bold text-white mb-6">Contact</h3>
                <div class="flex items-center text-lg text-gray-200 mb-4">
                    <i class="fa-solid fa-location-dot mr-4 text-2xl"></i>
                    <span>Jl. Soekarno-Hatta No.9 Malang</span>
                </div>
                <div class="flex items-center text-lg text-gray-200 mb-4">
                    <i class="fa-solid fa-phone mr-4 text-2xl"></i>
                    <span>+62 341 404424</span>
                </div>
                <div class="flex items-center text-lg text-gray-200 mb-4">
                    <i class="fa-solid fa-envelope mr-4 text-2xl"></i>
                    <span>sisforma@polinema.ac.id</span>
                </div>
                <div class="flex items-center gap-6 mt-6">
                    <a href="#" aria-label="Twitter"
                        class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-400 hover:bg-blue-600 hover:border-blue-600 transition">
                        <i class="fab fa-twitter text-2xl text-white"></i>
                    </a>
                    <a href="#" aria-label="Facebook"
                        class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-400 hover:bg-blue-600 hover:border-blue-600 transition">
                        <i class="fab fa-facebook-f text-2xl text-white"></i>
                    </a>
                    <a href="#" aria-label="YouTube"
                        class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-400 hover:bg-blue-600 hover:border-blue-600 transition">
                        <i class="fab fa-youtube text-2xl text-white"></i>
                    </a>
                    <a href="#" aria-label="Instagram"
                        class="w-12 h-12 flex items-center justify-center rounded-full border border-gray-400 hover:bg-blue-600 hover:border-blue-600 transition">
                        <i class="fab fa-instagram text-2xl text-white"></i>
                    </a>
                </div>
            </div>
            <!-- Google Maps -->
            <div class="w-full md:w-1/2">
                <div class="h-64 md:h-[250px] w-full">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7903.01775762196!2d112.6059767603874!3d-7.946247626910479!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78827687d272e7%3A0x789ce9a636cd3aa2!2sState%20Polytechnic%20of%20Malang!5e0!3m2!1sen!2sid!4v1688792717811!5m2!1sen!2sid"
                        class="w-full h-full rounded-lg" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" title="Politeknik Negeri Malang Map Location">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="text-center text-gray-400 py-6 border-t border-gray-600 text-sm">
            &copy; {{ date('Y') }} Sisforma. All rights reserved.
        </div>
    </footer>
</body>

</html>