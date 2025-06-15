@extends('layouts.dashboard')

@section('content')
<div id="mainContent" class="p-6 transition-all duration-300 ml-64 pt-[109px] md:pt-[61px] min-h-screen bg-gray-50">
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Notifikasi</h1>
                <p class="text-gray-600 mt-1">Kelola dan lihat semua notifikasi Anda</p>
            </div>
            
            <div class="flex space-x-3">
                <button id="markAllAsReadBtn"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-check-double mr-2"></i>
                    Tandai Semua Dibaca
                </button>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-lg shadow">
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <div class="notification-item p-4 hover:bg-gray-50 transition-colors {{ $notification->is_read ? 'opacity-75' : '' }}" 
                         data-notification-id="{{ $notification->notification_id }}">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas {{ $notification->icon }} {{ $notification->color }} text-lg"></i>
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-sm font-medium text-gray-900 mb-1">
                                            {{ $notification->title }}
                                            @if(!$notification->is_read)
                                                <span class="inline-block w-2 h-2 bg-blue-500 rounded-full ml-2"></span>
                                            @endif
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-2">
                                            {{ $notification->message }}
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ $notification->time_ago }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex space-x-2 ml-4">
                                        @if(!$notification->is_read)
                                            <button onclick="markAsRead({{ $notification->notification_id }})"
                                                    class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                                Tandai Dibaca
                                            </button>
                                        @endif
                                        <button onclick="deleteNotification({{ $notification->notification_id }})"
                                                class="text-red-600 hover:text-red-800 text-xs font-medium">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="flex items-center justify-center py-12">
                <div class="text-center">
                    <i class="fas fa-bell-slash text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Notifikasi</h3>
                    <p class="text-gray-600">Belum ada notifikasi untuk ditampilkan.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark all as read
    document.getElementById('markAllAsReadBtn').addEventListener('click', function() {
        fetch('/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
                setTimeout(() => window.location.reload(), 1000);
            } else {
                showAlert('error', 'Gagal menandai notifikasi sebagai dibaca.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan.');
        });
    });
});

// Mark single notification as read
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.add('opacity-75');
                // Remove unread indicator and mark as read button
                const unreadDot = notificationItem.querySelector('.bg-blue-500.rounded-full');
                const markReadBtn = notificationItem.querySelector('button[onclick*="markAsRead"]');
                if (unreadDot) unreadDot.remove();
                if (markReadBtn) markReadBtn.remove();
            }
            showAlert('success', 'Notifikasi telah ditandai sebagai dibaca.');
        } else {
            showAlert('error', 'Gagal menandai notifikasi sebagai dibaca.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan.');
    });
}

// Delete notification
function deleteNotification(notificationId) {
    if (!confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')) {
        return;
    }
    
    fetch(`/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.remove();
            }
            showAlert('success', 'Notifikasi berhasil dihapus.');
        } else {
            showAlert('error', 'Gagal menghapus notifikasi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan.');
    });
}

// Show alert function
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

    const alertHtml = `
        <div class="${alertClass} border-l-4 p-4 mb-4 rounded alert-message" role="alert">
            <div class="flex items-center">
                <i class="fas ${iconClass} mr-2"></i>
                ${message}
            </div>
        </div>
    `;

    // Remove existing alerts
    document.querySelectorAll('.alert-message').forEach(alert => alert.remove());

    // Add new alert at the top
    document.getElementById('mainContent').insertAdjacentHTML('afterbegin', alertHtml);

    // Auto-hide after 5 seconds
    setTimeout(() => {
        const alertElement = document.querySelector('.alert-message');
        if (alertElement) {
            alertElement.style.transition = 'opacity 0.5s';
            alertElement.style.opacity = '0';
            setTimeout(() => alertElement.remove(), 500);
        }
    }, 5000);

    // Scroll to top to show alert
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
