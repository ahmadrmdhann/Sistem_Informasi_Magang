<section id="kontak" class="py-16 md:py-24 scroll-mt-16">
    <div class="container px-4 md:px-6 mx-auto">
        <div class="flex flex-col items-center justify-center mb-12 text-center">
            <h2 class="text-3xl font-bold tracking-tight mb-4">Kontak Kami</h2>
            <div class="w-20 h-1 bg-blue-600 mb-4"></div>
            <p class="text-gray-600 max-w-2xl">
                Punya pertanyaan atau butuh bantuan? Hubungi kami melalui formulir di bawah ini.
            </p>
        </div>
        <div class="max-w-md mx-auto">
            <form class="space-y-4 bg-blue-50 p-8 rounded-lg shadow-sm">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">
                        Nama
                    </label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama Anda"
                        class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email Anda"
                        class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required>
                </div>
                <div>
                    <label for="pesan" class="block text-sm font-medium text-gray-700 mb-1">
                        Pesan
                    </label>
                    <textarea id="pesan" name="pesan" placeholder="Tulis pesan Anda di sini" rows="4"
                        class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:outline-none"
                        required></textarea>
                </div>
                <button type="submit"
                    class="w-full py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</section>