<section id="tentang"
    class="py-20 md:py-28 bg-gradient-to-br from-white via-gray-50 to-blue-50 scroll-mt-16 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-full h-full"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(59, 130, 246, 0.15) 1px, transparent 0); background-size: 40px 40px;">
        </div>
    </div>

    <!-- Floating Background Elements -->
    <div class="absolute top-20 left-10 w-32 h-32 bg-blue-200 rounded-full opacity-20 blur-2xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-40 h-40 bg-purple-200 rounded-full opacity-20 blur-2xl animate-float"
        style="animation-delay: 1s;"></div>

    <div class="container px-4 md:px-6 mx-auto relative z-10">
        <div class="grid gap-16 lg:grid-cols-2 items-center max-w-7xl mx-auto">
            <!-- Left Column - Image/Logo -->
            <div class="flex justify-center lg:justify-start fade-in-section">
                <div class="relative group">
                    <!-- Decorative Elements -->
                    <div
                        class="absolute -top-6 -left-6 w-24 h-24 bg-blue-500 rounded-2xl opacity-20 group-hover:opacity-30 transition-opacity duration-300 rotate-12">
                    </div>
                    <div
                        class="absolute -bottom-6 -right-6 w-20 h-20 bg-purple-500 rounded-full opacity-20 group-hover:opacity-30 transition-opacity duration-300">
                    </div>

                    <!-- Main Logo Container -->
                    <div
                        class="relative bg-white p-12 rounded-3xl shadow-2xl group-hover:shadow-3xl transition-all duration-500 border border-gray-100">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 rounded-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <img src="{{ asset('/images/logo.svg') }}" width="300" height="240" alt="JTI Sisforma Logo"
                            class="relative z-10 w-full max-w-xs mx-auto transform group-hover:scale-105 transition-transform duration-500">

                        <!-- Floating Icons -->
                        <div
                            class="absolute top-4 right-4 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 animate-bounce">
                            <i class="fa-solid fa-graduation-cap text-white text-sm"></i>
                        </div>
                        <div class="absolute bottom-4 left-4 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 animate-bounce"
                            style="animation-delay: 0.2s;">
                            <i class="fa-solid fa-briefcase text-white text-sm"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Content -->
            <div class="space-y-8 fade-in-section" style="animation-delay: 0.2s;">
                <!-- Badge -->
                <div
                    class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 text-sm font-semibold border border-blue-200">
                    <i class="fa-solid fa-info-circle mr-2"></i>
                    Tentang Platform
                </div>

                <!-- Main Heading -->
                <div>
                    <h2
                        class="text-4xl md:text-5xl font-bold tracking-tight mb-6 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent leading-tight">
                        Tentang JTI Sisforma
                    </h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-8"></div>
                </div>

                <!-- Description -->
                <div class="space-y-6">
                    <p class="text-lg text-gray-600 leading-relaxed">
                        JTI Sisforma adalah <span class="font-semibold text-gray-800">solusi digital revolusioner</span>
                        untuk memudahkan pengelolaan program magang di Jurusan Teknologi Informasi, Politeknik Negeri
                        Malang.
                    </p>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Dengan fitur lengkap dan antarmuka yang ramah pengguna, JTI Sisforma membantu Anda mengelola
                        peserta, jadwal, rekomendasi, dan laporan dengan <span
                            class="font-semibold text-gray-800">efisiensi
                            maksimal</span>.
                    </p>
                </div>

                <!-- Feature List -->
                <div class="space-y-4 mt-8">
                    <div class="flex items-start group cursor-pointer">
                        <div
                            class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-4 mt-1 group-hover:scale-110 transition-transform duration-200">
                            <i class="fa-solid fa-users text-white text-xs"></i>
                        </div>
                        <div>
                            <h4
                                class="font-semibold text-gray-800 group-hover:text-blue-600 transition-colors duration-200">
                                Integrasi Data Peserta & Mentor
                            </h4>
                            <p class="text-gray-600 text-sm mt-1">Sinkronisasi otomatis data peserta dan mentor dalam
                                satu platform terpadu
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start group cursor-pointer">
                        <div
                            class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mr-4 mt-1 group-hover:scale-110 transition-transform duration-200">
                            <i class="fa-solid fa-chart-line text-white text-xs"></i>
                        </div>
                        <div>
                            <h4
                                class="font-semibold text-gray-800 group-hover:text-green-600 transition-colors duration-200">
                                Monitoring Progress Real-time
                            </h4>
                            <p class="text-gray-600 text-sm mt-1">Pantau perkembangan magang secara real-time dengan
                                dashboard interaktif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start group cursor-pointer">
                        <div
                            class="flex-shrink-0 w-6 h-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mr-4 mt-1 group-hover:scale-110 transition-transform duration-200">
                            <i class="fa-solid fa-brain text-white text-xs"></i>
                        </div>
                        <div>
                            <h4
                                class="font-semibold text-gray-800 group-hover:text-purple-600 transition-colors duration-200">
                                Rekomendasi Cerdas DSS
                            </h4>
                            <p class="text-gray-600 text-sm mt-1">Sistem rekomendasi tempat magang menggunakan Decision
                                Support System untuk hasil yang optimal
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA Button -->
                @if (!Auth::check())
                    <div class="pt-6">
                        <a href="{{ route('register') }}"
                            class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 font-semibold">
                            <i class="fa-solid fa-rocket mr-2 group-hover:animate-bounce"></i>
                            Mulai Perjalanan Anda
                            <i
                                class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200">
                            </i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
    </style>
</section>
