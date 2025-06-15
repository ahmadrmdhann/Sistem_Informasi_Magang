<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NotificationModel;
use App\Models\UserModel;

echo "Testing notification system...\n";

// Get first user
$user = UserModel::first();
if ($user) {
    echo "Found user: {$user->nama} (ID: {$user->user_id})\n";
    
    // Get unread notifications
    $notifications = NotificationModel::forUser($user->user_id)
        ->unread()
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();
    
    echo "Unread notifications count: " . $notifications->count() . "\n";
    
    if ($notifications->count() > 0) {
        echo "Notifications:\n";
        foreach ($notifications as $notif) {
            echo "- {$notif->title} ({$notif->type})\n";
            echo "  Message: {$notif->message}\n";
            echo "  Created: {$notif->created_at}\n\n";
        }
    } else {
        echo "No unread notifications found\n";
    }
} else {
    echo "No users found\n";
}

echo "Test completed!\n";

?>
