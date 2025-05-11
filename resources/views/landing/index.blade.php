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
                {{-- Nanti logo taruh sini --}}
                Sisforma
            </a>
            <div class="hidden md:flex items-center gap-2">
                <a href="#"
                    class="px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition active-link">Beranda</a>
                <a href="#features"
                    class="px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Fitur</a>
                <a href="#about"
                    class="px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Tentang</a>
                <a href="{{ route('login') }}"
                    class="ml-4 px-4 py-2 rounded-lg font-semibold text-blue-600 border border-blue-600 bg-white shadow hover:bg-blue-50 transition">Masuk</a>
                <a href="{{ route('register') }}"
                    class="ml-2 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow hover:bg-blue-700 transition">Mulai
                    Sekarang</a>
            </div>
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-blue-700 focus:outline-none">
                    <i class="fa-solid fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
            <a href="#"
                class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Beranda</a>
            <a href="#features"
                class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Fitur</a>
            <a href="#about"
                class="block px-4 py-2 rounded-lg text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-700 transition">Tentang</a>
            <a href="{{ route('login') }}"
                class="block mt-2 px-4 py-2 rounded-lg font-semibold text-blue-600 border border-blue-600 bg-white shadow hover:bg-blue-50 transition">Masuk</a>
            <a href="{{ route('register') }}"
                class="block mt-2 px-4 py-2 rounded-lg font-semibold bg-blue-600 text-white shadow hover:bg-blue-700 transition">Mulai
                Sekarang</a>
        </div>
    </nav>

    <section
        class="hero-bg container mx-auto px-4 py-20 flex flex-col md:flex-row items-center rounded-b-3xl shadow animate-fade-in">
        <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 animate-fade-in"
                style="animation-delay:0.2s;">
                Sistem Informasi Magang
            </h1>
            <p class="text-lg text-gray-700 mb-8 animate-fade-in" style="animation-delay:0.4s;">
                Temukan peluang magang yang dirancang khusus untuk Anda — sesuai minat, keahlian, dan lokasi. Bangun
                karier impian Anda mulai dari sini.
            </p>
            <div class="flex gap-4 animate-fade-in" style="animation-delay:0.6s;">
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
                alt="Internship" class="rounded-lg shadow-lg w-full max-w-md animate-fade-in"
                style="animation-delay:0.8s;">
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="container mx-auto px-4 py-24">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Fitur Unggulan</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div
                class="feature-card bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300">
                <div class="flex justify-center mb-4">
                    <i class="fa-solid fa-location-crosshairs text-blue-600 text-4xl"></i>
                </div>
                <h3 class="font-semibold text-xl mb-2">Rekomendasi Magang</h3>
                <p class="text-gray-600">Sistem cerdas memberikan rekomendasi magang yang paling relevan sesuai dengan
                    profil, minat, dan keahlian Anda.</p>
            </div>
            <div
                class="feature-card bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300">
                <div class="flex justify-center mb-4">
                    <i class="fa-regular fa-user text-blue-600 text-4xl"></i>
                </div>
                <h3 class="font-semibold text-xl mb-2">Dashboard Personal</h3>
                <p class="text-gray-600">Pantau status lamaran, jadwal interview, dan seluruh progress magang Anda
                    secara real-time melalui dashboard personal.</p>
            </div>
            <div
                class="feature-card bg-white rounded-lg shadow p-6 text-center hover:shadow-lg transition duration-300">
                <div class="flex justify-center mb-4">
                    <i class="fa-solid fa-chalkboard-user text-blue-600 text-4xl"></i>
                </div>
                <h3 class="font-semibold text-xl mb-2">Bimbingan Aktif</h3>
                <p class="text-gray-600">Dapatkan arahan langsung dari dosen pembimbing yang ditugaskan untuk memantau,
                    mengevaluasi, dan membimbing setiap langkah magang Anda. </p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="container mx-auto px-4 py-24">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-10">Tentang Sisforma</h2>
        <div class="max-w-3xl mx-auto text-center text-gray-700">
            <p class="mb-6">
                Sisforma adalah platform Sistem Informasi Magang yang dirancang untuk memudahkan mahasiswa dalam
                menemukan, melamar, dan mengelola program magang sesuai minat dan keahlian. Kami berkomitmen untuk
                menjadi jembatan antara mahasiswa, universitas, dan dunia industri melalui fitur-fitur inovatif dan
                kemudahan akses informasi.
            </p>
            <p>
                Dengan Sisforma, proses magang menjadi lebih terstruktur, transparan, dan terpantau secara real-time.
                Kami percaya, pengalaman magang yang baik adalah langkah awal menuju karir yang sukses.
            </p>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section py-16 text-center text-white">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Siap Memulai Karir Impian Anda?</h2>
        <p class="mb-8 text-lg">Gabung bersama ribuan mahasiswa lain yang telah sukses menemukan magang terbaik mereka.
        </p>
        <a href="{{ route('register') }}"
            class="inline-block bg-white text-blue-700 px-8 py-3 rounded-lg font-bold shadow hover:bg-blue-100 transition">Daftar
            Sekarang</a>
    </section>

    <footer class="bg-white border-t mt-20">
        <div class="container mx-auto px-4 py-6 text-center text-gray-500">
            &copy; {{ date('Y') }} Sisforma. All rights reserved.
        </div>
    </footer>
</body>

</html>
