<!-- Call to Action -->
@if (!Auth::check())
<section class="py-16 bg-blue-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Siap Memulai?</h2>
        <p class="text-blue-100 mb-8">Daftar sekarang dan nikmati kemudahan mengelola program magang Anda!</p>
        <a href="{{ route('register') }}"
            class="inline-block px-8 py-3 bg-white text-blue-600 rounded-lg shadow-lg hover:bg-blue-100 transition font-semibold focus:outline-none">
            Daftar Gratis
        </a>
    </div>
</section>

@endif
