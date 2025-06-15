<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\PengajuanMagangModel;

echo "=== VERIFIKASI DATA PENGAJUAN MAGANG ===\n\n";

try {
    $count = PengajuanMagangModel::count();
    
    if ($count == 0) {
        echo "✅ BERHASIL: Tidak ada data pengajuan magang otomatis.\n";
        echo "   Mahasiswa harus mengajukan magang secara manual.\n\n";
    } else {
        echo "⚠️  MASIH ADA: {$count} data pengajuan magang ditemukan.\n";
        
        $pengajuans = PengajuanMagangModel::with(['mahasiswa.user', 'lowongan'])->get();
        foreach ($pengajuans as $pengajuan) {
            echo "- ID: {$pengajuan->id}, Mahasiswa: " . ($pengajuan->mahasiswa->user->nama ?? 'N/A') . "\n";
        }
    }
    
    // Cek data lain yang masih ada
    echo "DATA LAIN YANG TERSEDIA:\n";
    echo "- Total User: " . \App\Models\UserModel::count() . "\n";
    echo "- Total Mahasiswa: " . \App\Models\MahasiswaModel::count() . "\n";
    echo "- Total Dosen: " . \App\Models\DosenModel::count() . "\n";
    echo "- Total Lowongan: " . \App\Models\LowonganModel::count() . "\n";
    echo "- Total Partner: " . \App\Models\PartnerModel::count() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
