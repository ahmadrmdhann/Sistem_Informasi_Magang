<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\NotificationModel;

echo "Checking notifications in database...\n";

$notifications = NotificationModel::with('user')->orderBy('created_at', 'desc')->take(15)->get();

echo "Found " . $notifications->count() . " notifications:\n\n";

foreach($notifications as $notif) {
    $status = $notif->is_read ? 'Read' : 'Unread';
    $type = strtoupper($notif->type);
    echo "[$type] {$notif->user->nama}: {$notif->title} ({$status})\n";
    echo "  Message: {$notif->message}\n";
    echo "  Created: {$notif->created_at->format('Y-m-d H:i:s')}\n\n";
}

// Count by user
echo "Notifications by user:\n";
$notificationsByUser = $notifications->groupBy('user.nama');
foreach($notificationsByUser as $userName => $userNotifs) {
    $unreadCount = $userNotifs->where('is_read', false)->count();
    echo "- {$userName}: {$userNotifs->count()} total, {$unreadCount} unread\n";
}

echo "\nNotification system test completed!\n";

?>
