<section class="bg-blue-50 py-12 md:py-20 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-64 h-64 bg-blue-200 rounded-full opacity-30 blur-2xl -z-10 animate-pulse"></div>
    <div class="container px-4 md:px-6 mx-auto">
        <div class="grid gap-6 lg:grid-cols-2 lg:gap-12 items-center">
            <div class="space-y-4">
                <h1 class="text-3xl font-bold tracking-tighter sm:text-4xl md:text-5xl">
                    Selamat Datang di <span class="text-blue-600">Sistem Informasi Magang</span>
                </h1>
                <p class="text-gray-600 md:text-lg">
                    Platform terbaik untuk mengelola program magang dengan mudah, efisien, dan terintegrasi.
                </p>
                <a href="fitur" id="explore-features-btn"
                    class="inline-block mt-4 px-8 py-3 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition font-semibold focus:outline-none animate-bounce">
                    Jelajahi Fitur
                </a>
            </div>
            <div class="flex justify-center">
                <img src="https://preline.co/assets/svg/illustrations/occasions.svg" width="400" height="300"
                    alt="Magang Illustration" class="rounded-lg w-full max-w-md animate-fade-in">
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const exploreBtn = document.getElementById('explore-features-btn');
            if (exploreBtn) {
                exploreBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const fiturSection = document.getElementById('fitur');
                    if (fiturSection) {
                        fiturSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            }
        });
    </script>
</section>