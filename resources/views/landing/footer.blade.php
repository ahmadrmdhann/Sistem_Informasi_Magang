<footer class="relative bg-gradient-to-br from-gray-900 via-blue-900 to-indigo-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-full h-full"
            style="background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.3) 1px, transparent 0); background-size: 40px 40px;">
        </div>
    </div>

    <!-- Floating Background Elements -->
    <div class="absolute top-10 left-10 w-32 h-32 bg-blue-400 rounded-full opacity-10 blur-2xl animate-float"></div>
    <div class="absolute bottom-10 right-10 w-40 h-40 bg-purple-400 rounded-full opacity-10 blur-2xl animate-float"
        style="animation-delay: 1s;"></div>

    <div class="container px-4 md:px-6 mx-auto relative z-10">
        <!-- Main Footer Content -->
        <div class="py-16 md:py-20">
            <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">
                <!-- Company Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Logo and Brand -->
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('images/logo.svg') }}" alt="JTI Sisforma Logo"
                            class="h-10 w-10 filter brightness-0 invert">
                        <div>
                            <h3
                                class="text-2xl font-bold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                                JTI Sisforma
                            </h3>
                            <p class="text-sm text-gray-300">Sistem Informasi Magang</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-gray-300 leading-relaxed max-w-md">
                        Platform terdepan untuk mengelola program magang dengan teknologi modern,
                        memberikan pengalaman terbaik bagi peserta, pembimbing, dan institusi.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="space-y-6">
                    <h4 class="text-lg font-semibold text-white border-b border-white/20 pb-2">
                        Navigasi Cepat
                    </h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ url('/') }}"
                                class="text-gray-300 hover:text-blue-400 transition-colors duration-200 flex items-center group">
                                <i
                                    class="fa-solid fa-home mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="#fitur"
                                class="text-gray-300 hover:text-blue-400 transition-colors duration-200 flex items-center group">
                                <i
                                    class="fa-solid fa-star mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                Fitur
                            </a>
                        </li>
                        <li>
                            <a href="#tentang"
                                class="text-gray-300 hover:text-blue-400 transition-colors duration-200 flex items-center group">
                                <i
                                    class="fa-solid fa-info-circle mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                Tentang
                            </a>
                        </li>
                        @if (!Auth::check())
                            <li>
                                <a href="{{ route('login') }}"
                                    class="text-gray-300 hover:text-green-400 transition-colors duration-200 flex items-center group">
                                    <i
                                        class="fa-solid fa-sign-in-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    Masuk
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('register') }}"
                                    class="text-gray-300 hover:text-purple-400 transition-colors duration-200 flex items-center group">
                                    <i
                                        class="fa-solid fa-user-plus mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    Daftar
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ url('/dashboard') }}"
                                    class="text-gray-300 hover:text-green-400 transition-colors duration-200 flex items-center group">
                                    <i
                                        class="fa-solid fa-tachometer-alt mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    Dashboard
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Contact & Support -->
                <div class="space-y-6">
                    <h4 class="text-lg font-semibold text-white border-b border-white/20 pb-2">
                        Kontak & Dukungan
                    </h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <div class="flex items-center justify-center w-8 h-8 bg-blue-500/20 rounded-lg mt-0.5">
                                <i class="fa-solid fa-map-marker-alt text-blue-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-white font-medium">Alamat</div>
                                <div class="text-gray-300 text-sm">Jl. Soekarno Hatta No. 9, Malang</div>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="flex items-center justify-center w-8 h-8 bg-green-500/20 rounded-lg mt-0.5">
                                <i class="fa-solid fa-phone text-green-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-white font-medium">Telepon</div>
                                <a href="#"
                                    class="text-gray-300 text-sm hover:text-green-400 transition-colors duration-200">
                                    (0341) 404424
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="flex items-center justify-center w-8 h-8 bg-purple-500/20 rounded-lg mt-0.5">
                                <i class="fa-solid fa-envelope text-purple-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-white font-medium">Email</div>
                                <a href="mailto:humas@polinema.ac.id"
                                    class="text-gray-300 text-sm hover:text-purple-400 transition-colors duration-200">
                                    humas@polinema.ac.id
                                </a>
                            </div>
                        </li>
                        <li class="flex items-start space-x-3">
                            <div class="flex items-center justify-center w-8 h-8 bg-orange-500/20 rounded-lg mt-0.5">
                                <i class="fa-solid fa-clock text-orange-400 text-sm"></i>
                            </div>
                            <div>
                                <div class="text-white font-medium">Jam Operasional</div>
                                <div class="text-gray-300 text-sm">Senin - Jumat, 08:00 - 16:00</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="border-t border-white/20 py-8">
            <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
                <!-- Copyright -->
                <div class="text-center lg:text-left">
                    <p class="text-gray-300 text-sm">
                        © {{ date('Y') }}
                        <span
                            class="font-semibold bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            JTI Sisforma
                        </span>.
                        All rights reserved.
                    </p>
                    <p class="text-gray-400 text-xs mt-1">
                        Developed with ❤️ by Kelompok 3
                    </p>
                </div>

                <!-- Social Media -->
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-400 mr-2">Ikuti Kami:</span>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/polinem/" target="_blank"
                            class="group flex items-center justify-center w-10 h-10 bg-white/10 rounded-lg hover:bg-blue-500 transition-all duration-300 backdrop-blur-sm">
                            <i
                                class="fab fa-facebook text-gray-300 group-hover:text-white group-hover:scale-110 transition-all duration-200"></i>
                        </a>
                        <a href="https://www.instagram.com/polinema_campus/" target="_blank"
                            class="group flex items-center justify-center w-10 h-10 bg-white/10 rounded-lg hover:bg-pink-500 transition-all duration-300 backdrop-blur-sm">
                            <i
                                class="fab fa-instagram text-gray-300 group-hover:text-white group-hover:scale-110 transition-all duration-200"></i>
                        </a>
                        <a href="https://twitter.com/polinema_campus" target="_blank"
                            class="group flex items-center justify-center w-10 h-10 bg-white/10 rounded-lg hover:bg-blue-400 transition-all duration-300 backdrop-blur-sm">
                            <i
                                class="fab fa-x-twitter text-gray-300 group-hover:text-white group-hover:scale-110 transition-all duration-200"></i>
                        </a>
                        <a href="https://www.linkedin.com/school/polinema-joss/" target="_blank"
                            class="group flex items-center justify-center w-10 h-10 bg-white/10 rounded-lg hover:bg-blue-600 transition-all duration-300 backdrop-blur-sm">
                            <i
                                class="fab fa-linkedin text-gray-300 group-hover:text-white group-hover:scale-110 transition-all duration-200"></i>
                        </a>
                        <a href="mailto:info@jtisisforma.ac.id"
                            class="group flex items-center justify-center w-10 h-10 bg-white/10 rounded-lg hover:bg-green-500 transition-all duration-300 backdrop-blur-sm">
                            <i
                                class="fas fa-envelope text-gray-300 group-hover:text-white group-hover:scale-110 transition-all duration-200"></i>
                        </a>
                    </div>
                </div>
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
            animation: float 4s ease-in-out infinite;
        }

        /* Newsletter input focus effect */
        input[type="email"]:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
        }

        /* Smooth hover transitions for links */
        footer a {
            position: relative;
        }

        footer a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            bottom: -2px;
            left: 0;
            background: currentColor;
            transition: width 0.3s ease;
        }

        footer a:hover::after {
            width: 100%;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Newsletter subscription
            const newsletterForm = document.querySelector('footer input[type="email"]');
            const newsletterButton = document.querySelector('footer button');

            if (newsletterButton) {
                newsletterButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (newsletterForm && newsletterForm.value) {
                        // Add success animation
                        this.innerHTML = '<i class="fa-solid fa-check"></i>';
                        this.classList.add('bg-green-500');

                        setTimeout(() => {
                            this.innerHTML = '<i class="fa-solid fa-paper-plane"></i>';
                            this.classList.remove('bg-green-500');
                        }, 2000);

                        newsletterForm.value = '';
                        newsletterForm.placeholder = 'Terima kasih! 🎉';

                        setTimeout(() => {
                            newsletterForm.placeholder = 'Masukkan email Anda';
                        }, 3000);
                    }
                });
            }

            // Smooth scroll for footer links
            document.querySelectorAll('footer a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add sparkle effect to social media icons on hover
            document.querySelectorAll('footer .fab, footer .fas').forEach(icon => {
                icon.parentElement.addEventListener('mouseenter', function () {
                    // Create a subtle glow effect
                    this.style.boxShadow = '0 0 20px rgba(59, 130, 246, 0.3)';
                });

                icon.parentElement.addEventListener('mouseleave', function () {
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
</footer>
