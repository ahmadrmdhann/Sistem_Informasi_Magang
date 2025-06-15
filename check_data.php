<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PengajuanMagangModel;

echo "=== PENGAJUAN MAGANG DATA ===\n\n";

try {
    $pengajuans = PengajuanMagangModel::with(['mahasiswa.user', 'dosen.user', 'lowongan.partner'])->get();
    
    if ($pengajuans->count() == 0) {
        echo "Tidak ada data pengajuan magang.\n";
    } else {
        foreach ($pengajuans as $pengajuan) {
            echo "ID: " . $pengajuan->id . "\n";
            echo "Mahasiswa: " . ($pengajuan->mahasiswa->user->nama ?? 'N/A') . "\n";
            echo "Lowongan: " . ($pengajuan->lowongan->judul ?? 'N/A') . "\n";
            echo "Partner: " . ($pengajuan->lowongan->partner->nama ?? 'N/A') . "\n";
            echo "Dosen ID: " . ($pengajuan->dosen_id ?? 'NULL') . "\n";
            echo "Dosen: " . ($pengajuan->dosen->user->nama ?? 'TIDAK ADA') . "\n";
            echo "Status: " . $pengajuan->status . "\n";
            echo "Tanggal: " . $pengajuan->tanggal_pengajuan . "\n";
            echo "---\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
