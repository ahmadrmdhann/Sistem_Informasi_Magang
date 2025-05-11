<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/Sistem_Informasi_Magang/resources/views/lowongan/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Lowongan Magang</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    @include('layouts.navbar')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Daftar Lowongan Magang</h1>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach ($lowonganMagang as $lowongan)
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $lowongan->judul_lowongan }}</h2>
                    <p class="text-gray-600 mb-4">{{ Str::limit($lowongan->deskripsi, 100) }}</p>
                    <p class="text-sm text-gray-500 mb-2">
                        <strong>Perusahaan:</strong> {{ $lowongan->perusahaan->nama_perusahaan }}
                    </p>
                    <p class="text-sm text-gray-500 mb-2">
                        <strong>Batas Pendaftaran:</strong> {{ $lowongan->batas_pendaftaran }}
                    </p>
                    <p class="text-sm text-gray-500 mb-4">
                        <strong>Kuota:</strong> {{ $lowongan->sisa_kuota }} / {{ $lowongan->kuota }}
                    </p>
                    <a href="javascript:void(0)"
                        class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition"
                        onclick="loadLowonganDetail({{ $lowongan->id }})">
                        Lihat Detail
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="lowonganModal" class="fixed inset-0 flex items-center justify-center hidden">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-white bg-opacity-50" onclick="closeModal()"></div>

        <!-- Modal Content -->
        <div class="relative bg-white rounded-lg shadow-lg w-3/4 md:w-1/2 p-6 z-10">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                <i class="fa-solid fa-times"></i>
            </button>
            <div id="lowonganDetailContent">
                <!-- Detail lowongan akan dimuat di sini -->
            </div>
        </div>
    </div>

    <script>
        function loadLowonganDetail(id) {
            // Tampilkan modal
            const modal = document.getElementById('lowonganModal');
            modal.classList.remove('hidden');

            // Tampilkan loading sementara
            document.getElementById('lowonganDetailContent').innerHTML = '<p class="text-center">Loading...</p>';

            // Kirim permintaan AJAX
            fetch(`/lowongan/${id}`)
                .then(response => response.text())
                .then(data => {
                    // Masukkan data ke dalam modal
                    document.getElementById('lowonganDetailContent').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('lowonganDetailContent').innerHTML = '<p class="text-center text-red-500">Gagal memuat detail lowongan.</p>';
                });
        }

        function closeModal() {
            const modal = document.getElementById('lowonganModal');
            modal.classList.add('hidden');
        }
    </script>
</body>

</html>