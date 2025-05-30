@if (!Auth::check())
    <section class="py-12 md:py-16 bg-blue-600 text-white">
        <div class="container px-4 md:px-6 text-center mx-auto">
            <h2 class="text-3xl font-bold mb-4">Siap Memulai?</h2>
            <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                Daftar sekarang dan nikmati kemudahan mengelola program magang Anda!
            </p>
            <a href="{{ route('register') }}"
                class="inline-block px-6 py-3 bg-white text-blue-600 hover:bg-blue-100 transition font-semibold rounded-lg shadow-lg">
                Daftar Gratis
            </a>
        </div>
    </section>
@endif