@extends('layouts.app')

@section('tittle')
    <title>Sistem Informasi Magang</title>
    <meta name="description"
        content="Platform terbaik untuk mengelola program magang dengan mudah, efisien, dan terintegrasi.">
@endsection

@section('navbar')
    @include('landing.navbar')
@endsection

@section('content')
    <!-- Scroll Progress Bar -->
    <div id="scroll-progress"
        class="fixed top-0 left-0 w-0 h-1 bg-gradient-to-r from-blue-600 to-indigo-600 z-50 transition-all duration-200">
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay"
        class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-500">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mb-4"></div>
            <p class="text-gray-600">Memuat halaman...</p>
        </div>
    </div>

    <div class="flex flex-col min-h-screen">
        <main class="flex-1">
            @include('landing.content.hero')
            @include('landing.content.features')
            @include('landing.content.about')
            {{-- @include('landing.content.cta') --}}
        </main>

        @section('footer')
            @include('landing.footer')
        @endsection
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top"
        class="fixed bottom-6 right-6 w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 transform translate-y-20 opacity-0 z-[9998] flex items-center justify-center group hover:-translate-y-1 hover:scale-110">
        <i class="fas fa-arrow-up group-hover:animate-bounce"></i>
    </button>

    <style>
        /* CSS Custom Properties for theme consistency */
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --error-color: #ef4444;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f8fafc;
            --border-color: #e5e7eb;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        /* Smooth scrolling for the entire page */
        html {
            scroll-behavior: smooth;
        }

        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out;
        }

        /* Intersection Observer animations */
        .fade-in-section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .fade-in-section.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Enhanced focus styles for accessibility */
        *:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }

        /* Back to top button specific styles */
        #back-to-top {
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        #back-to-top.show {
            opacity: 1;
            transform: translateY(0) !important;
        }

        #back-to-top:hover {
            background: linear-gradient(135deg, #1d4ed8, #7c3aed);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.4);
        }

        /* Custom shadow classes */
        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Hide loading overlay
            const loadingOverlay = document.getElementById('loading-overlay');
            setTimeout(() => {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }, 800);

            // Scroll progress indicator
            const scrollProgress = document.getElementById('scroll-progress');
            window.addEventListener('scroll', () => {
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                scrollProgress.style.width = scrolled + '%';
            });

            // Back to top button with improved visibility
            const backToTop = document.getElementById('back-to-top');

            function toggleBackToTop() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 400) { // Show after scrolling 400px
                    backToTop.classList.add('show');
                    backToTop.style.opacity = '1';
                    backToTop.style.transform = 'translateY(0)';
                    backToTop.style.pointerEvents = 'auto';
                } else {
                    backToTop.classList.remove('show');
                    backToTop.style.opacity = '0';
                    backToTop.style.transform = 'translateY(20px)';
                    backToTop.style.pointerEvents = 'none';
                }
            }

            // Initial check
            toggleBackToTop();

            // Listen to scroll events
            window.addEventListener('scroll', toggleBackToTop);

            // Click handler for back to top
            backToTop.addEventListener('click', (e) => {
                e.preventDefault();

                // Add click animation
                backToTop.style.transform = 'translateY(0) scale(0.95)';

                setTimeout(() => {
                    backToTop.style.transform = 'translateY(0) scale(1)';
                }, 150);

                // Smooth scroll to top
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Add hover effect with particle animation
            backToTop.addEventListener('mouseenter', function () {
                // Create sparkle particles
                for (let i = 0; i < 6; i++) {
                    setTimeout(() => {
                        const particle = document.createElement('div');
                        particle.className = 'fixed w-1 h-1 bg-blue-400 rounded-full pointer-events-none animate-ping';
                        particle.style.left = (this.offsetLeft + Math.random() * this.offsetWidth) + 'px';
                        particle.style.top = (this.offsetTop + Math.random() * this.offsetHeight) + 'px';
                        particle.style.zIndex = '9997';

                        document.body.appendChild(particle);

                        setTimeout(() => {
                            if (particle.parentNode) {
                                particle.remove();
                            }
                        }, 1000);
                    }, i * 100);
                }
            });

            // Smooth scroll for anchor links with offset for fixed navbar
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);

                    if (targetElement) {
                        const offsetTop = targetElement.offsetTop - 80; // Account for fixed navbar
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Intersection Observer for fade-in animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, observerOptions);

            // Observe all fade-in sections
            document.querySelectorAll('.fade-in-section').forEach(section => {
                observer.observe(section);
            });

            // Add keyboard navigation support
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    // Close any open modals or dropdowns
                    const dropdown = document.getElementById('user-dropdown');
                    if (dropdown && !dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                    }
                }

                // Handle "Home" key to scroll to top
                if (e.key === 'Home' && e.ctrlKey) {
                    e.preventDefault();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            });

            // Preload critical images
            const criticalImages = [
                '{{ asset("images/logo.svg") }}',
                '{{ asset("images/image_illustration.png") }}'
            ];

            criticalImages.forEach(src => {
                const img = new Image();
                img.src = src;
            });
        });
    </script>
@endsection
