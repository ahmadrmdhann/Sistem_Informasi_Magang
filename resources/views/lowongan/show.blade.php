<!-- filepath: /Applications/XAMPP/xamppfiles/htdocs/Sistem_Informasi_Magang/resources/views/lowongan/show.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan Magang</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $lowongan->judul_lowongan }}</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 mb-4">{{ $lowongan->deskripsi }}</p>
            <p class="text-sm text-gray-500 mb-2">
                <strong>Perusahaan:</strong> {{ $lowongan->perusahaan->nama_perusahaan }}
            </p>
            <p class="text-sm text-gray-500 mb-2">
                <strong>Batas Pendaftaran:</strong> {{ $lowongan->batas_pendaftaran }}
            </p>
            <p class="text-sm text-gray-500 mb-4">
                <strong>Kuota:</strong> {{ $lowongan->sisa_kuota }} / {{ $lowongan->kuota }}
            </p>
            <a href="{{ route('lowongan.index') }}"
                class="inline-block bg-gray-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-700 transition">
                Kembali ke Daftar Lowongan
            </a>
        </div>
    </div>
</body>

</html>