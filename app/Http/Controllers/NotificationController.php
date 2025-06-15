<?php

namespace App\Http\Controllers;

use App\Models\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $notifications = NotificationModel::forUser($user->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'notifications' => $notifications->items(),
                'unread_count' => NotificationModel::forUser($user->user_id)->unread()->count(),
            ]);
        }

        return view('dashboard.notifications.index', compact('notifications'));
    }    /**
     * Get unread notifications for navbar dropdown.
     */
    public function getUnread()
    {
        $user = Auth::user();
        
        $notifications = NotificationModel::forUser($user->user_id)
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'notification_id' => $notification->notification_id,
                    'title' => $notification->title,
                    'message' => $notification->message,
                    'type' => $notification->type,
                    'is_read' => $notification->is_read,
                    'icon' => $this->getNotificationIcon($notification->type),
                    'color' => $this->getNotificationColor($notification->type),
                    'time_ago' => $notification->created_at->diffForHumans(),
                    'created_at' => $notification->created_at,
                ];
            });

        $unreadCount = NotificationModel::forUser($user->user_id)->unread()->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead($id)
    {
        $user = Auth::user();
        
        $notification = NotificationModel::forUser($user->user_id)
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read.',
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        $user = Auth::user();
        
        NotificationModel::forUser($user->user_id)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read.',
        ]);
    }

    /**
     * Delete a notification.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        $notification = NotificationModel::forUser($user->user_id)
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted.',
        ]);
    }

    /**
     * Create a new notification.
     */
    public static function create($userId, $title, $message, $type = 'info', $data = null)
    {
        return NotificationModel::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
        ]);
    }

    /**
     * Send notification to multiple users.
     */
    public static function createForUsers($userIds, $title, $message, $type = 'info', $data = null)
    {
        $notifications = [];
        
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'data' => $data,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        NotificationModel::insert($notifications);
    }

    /**
     * Get icon for notification type.
     */
    private function getNotificationIcon($type)
    {
        $icons = [
            'success' => 'fa-check-circle',
            'info' => 'fa-info-circle',
            'warning' => 'fa-exclamation-triangle',
            'error' => 'fa-times-circle',
        ];

        return $icons[$type] ?? 'fa-bell';
    }

    /**
     * Get color class for notification type.
     */
    private function getNotificationColor($type)
    {
        $colors = [
            'success' => 'text-green-500',
            'info' => 'text-blue-500',
            'warning' => 'text-yellow-500',
            'error' => 'text-red-500',
        ];

        return $colors[$type] ?? 'text-gray-500';
    }
}
