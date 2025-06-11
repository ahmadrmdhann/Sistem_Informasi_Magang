<section class="relative bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-16 md:py-24 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-200 rounded-full opacity-20 blur-3xl -z-10 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-200 rounded-full opacity-20 blur-3xl -z-10 animate-pulse"
        style="animation-delay: 1s;"></div>
    <div
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-indigo-200 rounded-full opacity-10 blur-2xl -z-10">
    </div>

    <div class="container px-4 md:px-6 mx-auto relative z-10">
        <div class="grid gap-8 lg:grid-cols-2 lg:gap-16 items-center">
            <!-- Left Column - Text Content -->
            <div class="space-y-6 fade-in-section">
                <!-- Badge -->
                <div
                    class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-800 text-sm font-medium animate-slideInLeft">
                    <i class="fa-solid fa-star mr-2 text-yellow-500"></i>
                    Platform Magang Terdepan
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl font-bold tracking-tight sm:text-5xl md:text-6xl leading-tight">
                    Selamat Datang di
                    <span
                        class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 animate-gradient-x">
                        JTI Sisforma
                    </span>
                </h1>

                <!-- Description -->
                <p class="text-xl text-gray-600 leading-relaxed max-w-2xl">
                    Platform terbaik untuk mengelola program magang dengan mudah, efisien, dan terintegrasi.
                    Wujudkan pengalaman magang yang bermakna bagi semua pihak.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    @if (!Auth::check())
                        <a href="{{ route('register') }}"
                            class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 font-semibold text-lg">
                            <i class="fa-solid fa-rocket mr-2 group-hover:animate-bounce"></i>
                            Mulai Sekarang
                            <i
                                class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                        </a>
                        <a href="#fitur" id="explore-features-btn"
                            class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-800 border-2 border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:border-blue-300 transition-all duration-300 font-semibold text-lg">
                            <i class="fa-solid fa-compass mr-2 group-hover:rotate-12 transition-transform duration-200"></i>
                            Jelajahi Fitur
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}"
                            class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 font-semibold text-lg">
                            <i class="fa-solid fa-tachometer-alt mr-2"></i>
                            Ke Dashboard
                            <i
                                class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                        </a>
                        <a href="#fitur" id="explore-features-btn"
                            class="group inline-flex items-center justify-center px-8 py-4 bg-white text-gray-800 border-2 border-gray-200 rounded-xl shadow-lg hover:shadow-xl hover:border-blue-300 transition-all duration-300 font-semibold text-lg">
                            <i class="fa-solid fa-compass mr-2 group-hover:rotate-12 transition-transform duration-200"></i>
                            Lihat Fitur
                        </a>
                    @endif
                </div>
            </div>

            <!-- Right Column - Illustration -->
            <div class="flex justify-center lg:justify-end fade-in-section" style="animation-delay: 0.3s;">
                <div class="relative">
                    <!-- Floating Elements -->
                    <div class="absolute -top-4 -left-4 w-20 h-20 bg-blue-500 rounded-lg opacity-80 animate-float">
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-purple-500 rounded-full opacity-60 animate-float"
                        style="animation-delay: 1s;"></div>
                    <div class="absolute top-1/2 -left-8 w-12 h-12 bg-green-500 rounded-lg opacity-70 animate-float"
                        style="animation-delay: 2s;"></div>

                    <!-- Main Image -->
                    <div class="relative z-10 transform hover:scale-105 transition-transform duration-700">
                        <img src="{{ asset('/images/image_illustration.png') }}" width="500" height="400"
                            alt="Magang Illustration" class="rounded-2xl shadow-2xl w-full max-w-lg">
                        <!-- Overlay gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-blue-600/10 to-transparent rounded-2xl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-gradient-x {
            background-size: 200% 200%;
            animation: gradient-x 3s ease infinite;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Smooth scroll for explore button
            const exploreBtn = document.getElementById('explore-features-btn');
            if (exploreBtn) {
                exploreBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const fiturSection = document.getElementById('fitur');
                    if (fiturSection) {
                        const offsetTop = fiturSection.offsetTop - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            }
        });
    </script>
</section>
