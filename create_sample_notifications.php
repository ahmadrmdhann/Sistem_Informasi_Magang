<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\NotificationService;
use App\Models\UserModel;
use App\Models\MahasiswaModel;
use App\Models\DosenModel;
use App\Models\PengajuanMagangModel;
use App\Models\ActivityLogModel;

echo "Creating sample notifications...\n";

// Get some users
$users = UserModel::with('level')->limit(10)->get();
echo "Found " . $users->count() . " users in the system:\n";

foreach($users as $user) {
    echo "- ID: {$user->user_id}, Name: {$user->nama}, Level: {$user->level->level_nama}\n";
}

// Get a mahasiswa user
$mahasiswa = MahasiswaModel::with('user')->first();
if ($mahasiswa) {
    echo "\nFound mahasiswa: {$mahasiswa->user->nama} (ID: {$mahasiswa->user->user_id})\n";
    
    // Create welcome notification
    NotificationService::createWelcomeNotification($mahasiswa->user->user_id, 'MHS');
    echo "Created welcome notification for mahasiswa\n";
    
    // Create sample general notifications
    NotificationService::create(
        $mahasiswa->user->user_id,
        'Sistem Maintenance',
        'Sistem akan mengalami maintenance pada hari Minggu dari pukul 02:00 - 04:00 WIB.',
        'warning',
        ['maintenance_date' => '2025-06-15']
    );
    echo "Created maintenance notification\n";
    
    NotificationService::create(
        $mahasiswa->user->user_id,
        'Update Profil',
        'Lengkapi profil Anda untuk mendapatkan rekomendasi lowongan magang yang lebih baik.',
        'info',
        ['action' => 'update_profile']
    );
    echo "Created profile update notification\n";
}

// Get a dosen user
$dosen = DosenModel::with('user')->first();
if ($dosen) {
    echo "\nFound dosen: {$dosen->user->nama} (ID: {$dosen->user->user_id})\n";
    
    // Create welcome notification
    NotificationService::createWelcomeNotification($dosen->user->user_id, 'DSN');
    echo "Created welcome notification for dosen\n";
    
    // Create sample notifications
    NotificationService::create(
        $dosen->user->user_id,
        'Mahasiswa Bimbingan Baru',
        'Anda telah ditugaskan untuk membimbing 3 mahasiswa magang baru.',
        'success',
        ['new_students' => 3]
    );
    echo "Created new students notification\n";
    
    NotificationService::create(
        $dosen->user->user_id,
        'Kegiatan Perlu Review',
        'Terdapat 5 kegiatan mahasiswa yang menunggu review Anda.',
        'info',
        ['pending_reviews' => 5]
    );
    echo "Created pending reviews notification\n";
}

// Get admin user
$adminUser = UserModel::whereHas('level', function($query) {
    $query->where('level_kode', 'ADM');
})->first();

if ($adminUser) {
    echo "\nFound admin: {$adminUser->nama} (ID: {$adminUser->user_id})\n";
    
    // Create welcome notification
    NotificationService::createWelcomeNotification($adminUser->user_id, 'ADM');
    echo "Created welcome notification for admin\n";
    
    // Create sample notifications
    NotificationService::create(
        $adminUser->user_id,
        'Pengajuan Magang Baru',
        'Terdapat 10 pengajuan magang baru yang perlu diproses.',
        'info',
        ['new_applications' => 10]
    );
    echo "Created new applications notification\n";
    
    NotificationService::create(
        $adminUser->user_id,
        'Laporan Bulanan',
        'Laporan aktivitas magang bulan ini telah siap untuk direview.',
        'success',
        ['report_month' => 'Juni 2025']
    );
    echo "Created monthly report notification\n";
}

// Create some notifications for different scenarios
if ($mahasiswa && $dosen) {
    // Simulate pengajuan status change
    $pengajuan = PengajuanMagangModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->first();
    if ($pengajuan) {
        NotificationService::notifyPengajuanStatusChange($pengajuan, 'diajukan', 'diterima');
        echo "Created pengajuan status change notification\n";
    }
    
    // Simulate activity submission
    $activity = ActivityLogModel::where('mahasiswa_id', $mahasiswa->mahasiswa_id)->first();
    if ($activity) {
        NotificationService::notifyNewActivityForReview($activity);
        echo "Created new activity for review notification\n";
    }
}

echo "\nSample notifications created successfully!\n";
echo "You can now test the notification system in the application.\n";

?>
