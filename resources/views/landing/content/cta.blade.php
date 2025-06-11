@if (!Auth::check())
    <section
        class="relative py-20 md:py-28 bg-gradient-to-br from-blue-600 via-purple-600 to-indigo-700 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full"
                style="background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.3) 1px, transparent 0); background-size: 50px 50px;">
            </div>
        </div>

        <!-- Floating Background Elements -->
        <div class="absolute top-10 left-10 w-40 h-40 bg-white rounded-full opacity-10 blur-2xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-yellow-300 rounded-full opacity-20 blur-2xl animate-float"
            style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-pink-300 rounded-full opacity-15 blur-xl animate-float"
            style="animation-delay: 2s;"></div>

        <div class="container px-4 md:px-6 mx-auto text-center relative z-10 max-w-5xl">
            <!-- Badge -->
            <div
                class="inline-flex items-center px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-semibold mb-8 border border-white/30">
                <i class="fa-solid fa-rocket mr-2 text-yellow-300"></i>
                Bergabung Dengan Ribuan Peserta Lainnya
            </div>

            <!-- Main Heading -->
            <h2 class="text-4xl md:text-6xl font-bold mb-8 leading-tight">
                Siap Memulai
                <span
                    class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-pink-300 to-white animate-gradient-x">
                    Perjalanan Magang Anda?
                </span>
            </h2>

            <!-- Description -->
            <p class="text-xl md:text-2xl text-blue-100 mb-12 max-w-4xl mx-auto leading-relaxed">
                Daftar sekarang dan nikmati kemudahan mengelola program magang dengan teknologi terdepan.
                <span class="font-semibold text-white">Gratis untuk 30 hari pertama!</span>
            </p>

            <!-- Features Pills -->
            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium border border-white/30">
                    <i class="fa-solid fa-check mr-2 text-green-300"></i>
                    Setup Instan
                </span>
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium border border-white/30">
                    <i class="fa-solid fa-shield-alt mr-2 text-blue-300"></i>
                    100% Aman
                </span>
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium border border-white/30">
                    <i class="fa-solid fa-headset mr-2 text-purple-300"></i>
                    Support 24/7
                </span>
                <span
                    class="inline-flex items-center px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium border border-white/30">
                    <i class="fa-solid fa-mobile-alt mr-2 text-pink-300"></i>
                    Mobile Friendly
                </span>
            </div>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mb-12">
                <a href="{{ route('register') }}"
                    class="group relative inline-flex items-center justify-center px-12 py-5 bg-white text-blue-600 rounded-2xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 transition-all duration-300 font-bold text-lg overflow-hidden">
                    <!-- Shimmer Effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                    </div>

                    <i class="fa-solid fa-rocket mr-3 group-hover:animate-bounce text-xl"></i>
                    Daftar Sekarang - GRATIS!
                    <i
                        class="fa-solid fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-200 text-xl"></i>
                </a>

                <a href="#fitur"
                    class="group inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/50 rounded-2xl hover:bg-white/10 hover:border-white transition-all duration-300 font-semibold backdrop-blur-sm">
                    <i class="fa-solid fa-play mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                    Lihat Demo
                </a>
            </div>

            <!-- Social Proof -->
            <div class="flex flex-col md:flex-row items-center justify-center space-y-4 md:space-y-0 md:space-x-12 mb-8">
                <!-- User Avatars -->
                <div class="flex items-center space-x-4">
                    <div class="flex -space-x-3">
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-500 border-3 border-white flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-user text-white text-sm"></i>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-green-400 to-green-500 border-3 border-white flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-user text-white text-sm"></i>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-500 border-3 border-white flex items-center justify-center shadow-lg">
                            <i class="fa-solid fa-user text-white text-sm"></i>
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-500 border-3 border-white flex items-center justify-center shadow-lg">
                            <span class="text-white text-sm font-bold">+</span>
                        </div>
                    </div>
                    <div class="text-left">
                        <p class="text-white font-semibold">
                            <span class="text-2xl font-bold">500+</span> Pengguna Aktif
                        </p>
                        <p class="text-blue-200 text-sm">Bergabung minggu ini</p>
                    </div>
                </div>

                <!-- Rating -->
                <div class="flex items-center space-x-3">
                    <div class="flex space-x-1">
                        <i class="fa-solid fa-star text-yellow-300 text-xl"></i>
                        <i class="fa-solid fa-star text-yellow-300 text-xl"></i>
                        <i class="fa-solid fa-star text-yellow-300 text-xl"></i>
                        <i class="fa-solid fa-star text-yellow-300 text-xl"></i>
                        <i class="fa-solid fa-star text-yellow-300 text-xl"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-white font-semibold">4.9/5 Rating</p>
                        <p class="text-blue-200 text-sm">Dari 200+ review</p>
                    </div>
                </div>
            </div>

            <!-- Trust Indicators -->
            <div class="flex flex-wrap justify-center items-center gap-8 opacity-70">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-shield-alt text-green-300"></i>
                    <span class="text-sm">SSL Encrypted</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-lock text-blue-300"></i>
                    <span class="text-sm">GDPR Compliant</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-check-circle text-purple-300"></i>
                    <span class="text-sm">ISO 27001</span>
                </div>
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-award text-yellow-300"></i>
                    <span class="text-sm">Best Practice</span>
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
                    transform: translateY(-15px);
                }
            }

            @keyframes gradient-x {

                0%,
                100% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }
            }

            .animate-float {
                animation: float 4s ease-in-out infinite;
            }

            .animate-gradient-x {
                background-size: 200% 200%;
                animation: gradient-x 3s ease infinite;
            }

            .shadow-3xl {
                box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
            }

            /* Pulse animation for floating elements */
            .animate-float:nth-child(1) {
                animation-duration: 4s;
            }

            .animate-float:nth-child(2) {
                animation-duration: 5s;
            }

            .animate-float:nth-child(3) {
                animation-duration: 6s;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Add sparkle effect to CTA button
                const ctaButton = document.querySelector('a[href="{{ route('register') }}"]');

                if (ctaButton) {
                    ctaButton.addEventListener('mouseenter', function () {
                        // Create sparkle elements
                        for (let i = 0; i < 6; i++) {
                            setTimeout(() => {
                                const sparkle = document.createElement('div');
                                sparkle.className = 'absolute w-1 h-1 bg-yellow-300 rounded-full animate-ping';
                                sparkle.style.left = Math.random() * 100 + '%';
                                sparkle.style.top = Math.random() * 100 + '%';
                                this.appendChild(sparkle);

                                setTimeout(() => {
                                    if (sparkle.parentNode) {
                                        sparkle.remove();
                                    }
                                }, 1000);
                            }, i * 100);
                        }
                    });
                }

                // Smooth scroll for demo button
                const demoButton = document.querySelector('a[href="#fitur"]');
                if (demoButton) {
                    demoButton.addEventListener('click', function (e) {
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
@else
    <section class="relative py-16 md:py-20 bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-green-200 rounded-full opacity-20 blur-2xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-40 h-40 bg-blue-200 rounded-full opacity-20 blur-2xl animate-float"
            style="animation-delay: 1s;"></div>

        <div class="container px-4 md:px-6 mx-auto text-center relative z-10 max-w-4xl">
            <!-- Welcome Back Section -->
            <div
                class="inline-flex items-center px-6 py-3 rounded-full bg-gradient-to-r from-green-100 to-blue-100 text-green-800 text-sm font-semibold mb-8 border border-green-200">
                <i class="fa-solid fa-user-check mr-2"></i>
                Selamat Datang Kembali, {{ Auth::user()->username }}!
            </div>

            <h2
                class="text-4xl md:text-5xl font-bold mb-6 bg-gradient-to-r from-green-600 via-blue-600 to-purple-600 bg-clip-text text-transparent leading-tight">
                Dashboard Anda Menanti
            </h2>

            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
                Lanjutkan perjalanan magang Anda dan akses semua fitur yang tersedia di dashboard.
            </p>

            <a href="{{ url('/dashboard') }}"
                class="group inline-flex items-center justify-center px-10 py-4 bg-gradient-to-r from-green-600 to-blue-600 text-white rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 font-semibold text-lg">
                <i class="fa-solid fa-tachometer-alt mr-3 group-hover:animate-bounce"></i>
                Masuk ke Dashboard
                <i class="fa-solid fa-arrow-right ml-3 group-hover:translate-x-1 transition-transform duration-200"></i>
            </a>
        </div>
    </section>
@endif
