<nav class="sticky bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between shadow-sm fixed top-0 z-30 transition-all duration-300"
    id="mainNavbar" style="left: 0; right: 0; width: calc(100% - 16rem);">
    <!-- Logo and Main Nav -->
    <div class="flex items-center space-x-4">
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggleBtn" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
    <!-- User Profile -->
    <div class="flex items-center space-x-4">
        <!-- Notification Bell -->
        <div class="relative" id="notificationContainer">
            <button type="button"
                class="notification-bell-toggle relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                id="notificationBellToggle">
                <i class="fa-solid fa-bell text-xl"></i>
                <!-- Notification Badge -->
                <span id="notificationBadge"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center hidden">
                    0
                </span>
            </button>

            <!-- Notification Dropdown -->
            <div id="notificationDropdown"
                class="notification-dropdown-menu hidden absolute right-0 z-50 mt-3 w-80 bg-white shadow-xl rounded-xl border border-gray-200 max-h-96 overflow-hidden">
                <!-- Dropdown Header -->
                <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                        <button id="markAllAsRead" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                            Tandai Semua Dibaca
                        </button>
                    </div>
                </div>

                <!-- Notifications List -->
                <div id="notificationsList" class="max-h-64 overflow-y-auto">
                    <div class="flex items-center justify-center py-8">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                        <span class="ml-2 text-gray-500">Memuat notifikasi...</span>
                    </div>
                </div>

                <!-- Dropdown Footer -->
                <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('notifications.index') }}"
                        class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Semua Notifikasi
                    </a>
                </div>
            </div>
        </div>

        <!-- User Profile Dropdown -->
        <div class="relative" id="userDropdownContainer">
            <button type="button"
                class="user-dropdown-toggle flex items-center gap-3 focus:outline-none hover:bg-gray-50 px-3 py-2 rounded-full transition shadow-sm"
                id="userDropdownToggle">
                @if(Auth::user()->level_id == 3)
                    @if(Auth::user()->mahasiswa->foto_profil)
                        <img class="w-10 h-10 rounded-full border-2 border-blue-300 shadow object-cover"
                            src="{{ asset(Auth::user()->mahasiswa->foto_profil) }}">
                    @else
                        <div
                            class="w-10 h-10 rounded-full border-2 border-blue-300 shadow bg-blue-500 flex items-center justify-center">
                            <i class="fa-solid fa-user text-white text-lg"></i>
                        </div>
                    @endif
                @elseif(Auth::user()->level_id == 2)
                    @if(Auth::user()->dosen->foto_profil)
                        <img class="w-10 h-10 rounded-full border-2 border-green-300 shadow object-cover"
                            src="{{ asset(Auth::user()->dosen->foto_profil) }}">
                    @else
                        <div
                            class="w-10 h-10 rounded-full border-2 border-green-300 shadow bg-green-500 flex items-center justify-center">
                            <i class="fa-solid fa-chalkboard-teacher text-white text-lg"></i>
                        </div>
                    @endif
                @else
                    <div
                        class="w-10 h-10 rounded-full border-2 border-gray-300 shadow bg-gray-500 flex items-center justify-center">
                        <i class="fa-solid fa-user text-white text-lg"></i>
                </div> @endif
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->username }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->level->level_nama }}</p>
                </div>
                <i class="fa-solid fa-chevron-down ml-2 text-blue-400"></i>
            </button>
            <div id="userDropdownMenu"
                class="user-dropdown-menu hidden absolute right-0 z-50 mt-3 min-w-[240px] bg-white shadow-xl rounded-xl p-3 ring-1 ring-blue-200">
                <div class="px-3 py-2 border-b border-gray-200 mb-2">
                    <p class="font-medium text-gray-800">{{ Auth::user()->username }}</p>
                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                @if (Auth::user()->level_id === 1)
                    {{-- <a href="#" --}} {{--
                        class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition group">
                        --}}
                        {{-- <div
                            class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition">
                            <i class="fa-solid fa-tachometer-alt text-blue-600"></i>
                        </div> --}}
                        {{-- <div>
                            <p class="font-medium">Profile</p>
                            <p class="text-xs text-gray-500">Edit your profile</p>
                        </div> --}}
                        {{-- </a> --}}
                @elseif (Auth::user()->level_id === 3)
                    <a href="{{ route('mahasiswa.profile') }}"
                        class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition group">

                        <div>
                            <p class="font-medium">Profile</p>
                            <p class="text-xs text-gray-500">Edit Your Profile</p>
                        </div>
                    </a>
                @elseif (Auth::user()->level_id === 2)
                    <a href="{{ route('dosen.profile') }}"
                        class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition group">
                        {{-- <div
                            class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition">
                            <i class="fa-solid fa-user-tie text-blue-600"></i>
                        </div> --}}
                        <div>
                            <p class="font-medium">Profile</p>
                            <p class="text-xs text-gray-500">Edit your profile</p>
                        </div>
                    </a>
                @endif
                <!-- <a href="#"
                    class="flex items-center gap-2 px-4 py-3 text-gray-700 hover:bg-blue-50 rounded-lg transition group">
                    <div
                        class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition">
                        <i class="fa-solid fa-cog text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-medium">Settings</p>
                        <p class="text-xs text-gray-500">Configure your account</p>
                    </div>
                </a> -->
                <div class="border-t border-gray-200 my-2"></div>
                <form method="GET" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-3 w-full text-left text-gray-700 hover:bg-red-50 rounded-lg transition group">
                        {{-- <div
                            class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition">
                            <i class="fa-solid fa-right-from-bracket text-red-600"></i>
                        </div> --}}
                        <div>
                            <p class="font-medium">Logout</p>
                            <p class="text-xs text-gray-500">Sign out of your account</p>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Search Toggle - Only shows on small screens -->
<div class="bg-white border-b border-gray-200 md:hidden px-4 py-2 fixed top-[61px] left-0 right-0 z-30">
    <div class="relative">
        <input type="text"
            class="bg-gray-100 rounded-full w-full py-2 pl-10 pr-4 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:bg-white transition"
            placeholder="Search...">
        <div class="absolute left-3 top-2.5 text-gray-400">
            <i class="fa-solid fa-search"></i>
        </div>
    </div>
</div>

<script>
    // Simplified dropdown functionality
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggle = document.getElementById('userDropdownToggle');
        const dropdownMenu = document.getElementById('userDropdownMenu');
        const dropdownContainer = document.getElementById('userDropdownContainer');
        const sidebar = document.getElementById('sidebar');
        const mainNavbar = document.getElementById('mainNavbar');
        const mainContent = document.getElementById('mainContent'); // Will need to be added to your main layout

        // Notification elements
        const notificationBell = document.getElementById('notificationBellToggle');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const notificationContainer = document.getElementById('notificationContainer');
        const notificationBadge = document.getElementById('notificationBadge');
        const notificationsList = document.getElementById('notificationsList');
        const markAllAsRead = document.getElementById('markAllAsRead');

        // Toggle user dropdown when clicking the button
        dropdownToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
            // Close notification dropdown if open
            notificationDropdown.classList.add('hidden');
        });

        // Toggle notification dropdown when clicking the bell
        notificationBell.addEventListener('click', function (e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            // Close user dropdown if open
            dropdownMenu.classList.add('hidden');

            if (!notificationDropdown.classList.contains('hidden')) {
                loadNotifications();
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdownContainer.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
            if (!notificationContainer.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });

        // Prevent clicks inside dropdowns from closing them
        dropdownMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        notificationDropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Mark all notifications as read
        markAllAsRead.addEventListener('click', function () {
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
                        updateNotificationBadge(0);
                        loadNotifications();
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        // Load notifications function
        function loadNotifications() {
            console.log('Loading notifications...');

            fetch('/notifications/unread', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    return response.json();
                })
                .then(data => {
                    console.log('Notifications data:', data);

                    if (data.success) {
                        updateNotificationsList(data.notifications);
                        updateNotificationBadge(data.unread_count);
                    } else {
                        throw new Error(data.message || 'Failed to load notifications');
                    }
                })
                .catch(error => {
                    console.error('Error loading notifications:', error);
                    notificationsList.innerHTML = `
                        <div class="flex items-center justify-center py-8">
                            <div class="text-center">
                                <i class="fas fa-exclamation-triangle text-red-500 text-2xl mb-2"></i>
                                <p class="text-red-500 text-sm">Gagal memuat notifikasi</p>
                                <p class="text-red-400 text-xs">${error.message}</p>
                            </div>
                        </div>
                    `;
                });
        }

        // Update notifications list
        function updateNotificationsList(notifications) {
            if (notifications.length === 0) {
                notificationsList.innerHTML = `
                    <div class="flex items-center justify-center py-8">
                        <div class="text-center">
                            <i class="fas fa-bell-slash text-gray-400 text-2xl mb-2"></i>
                            <p class="text-gray-500 text-sm">Tidak ada notifikasi baru</p>
                        </div>
                    </div>
                `;
                return;
            }

            let html = '';
            notifications.forEach(notification => {
                html += `
                    <div class="notification-item border-b border-gray-100 hover:bg-gray-50 transition-colors" 
                         data-notification-id="${notification.notification_id}">
                        <div class="px-4 py-3 cursor-pointer" onclick="markNotificationAsRead(${notification.notification_id})">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <i class="fas ${notification.icon} ${notification.color} text-lg"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 mb-1">
                                        ${notification.title}
                                    </p>
                                    <p class="text-sm text-gray-600 mb-1">
                                        ${notification.message}
                                    </p>
                                    <p class="text-xs text-gray-400">
                                        ${notification.time_ago}
                                    </p>
                                </div>
                                ${!notification.is_read ? '<div class="flex-shrink-0"><div class="w-2 h-2 bg-blue-500 rounded-full"></div></div>' : ''}
                            </div>
                        </div>
                    </div>
                `;
            });
            notificationsList.innerHTML = html;
        }

        // Update notification badge
        function updateNotificationBadge(count) {
            if (count > 0) {
                notificationBadge.textContent = count > 99 ? '99+' : count;
                notificationBadge.classList.remove('hidden');
            } else {
                notificationBadge.classList.add('hidden');
            }
        }

        // Mark notification as read function
        window.markNotificationAsRead = function (notificationId) {
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
                        // Remove the notification item or mark as read visually
                        const notificationItem = document.querySelector(`[data-notification-id="${notificationId}"]`);
                        if (notificationItem) {
                            notificationItem.remove();
                        }

                        // Update badge count
                        const currentBadge = notificationBadge.textContent;
                        const currentCount = currentBadge === '99+' ? 99 : parseInt(currentBadge) || 0;
                        updateNotificationBadge(Math.max(0, currentCount - 1));
                    }
                })
                .catch(error => console.error('Error:', error));
        };

        // Load initial notification count
        loadNotifications();

        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);

        // Add sidebar toggle functionality
        const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');

        sidebarToggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');

            // Update navbar and content
            if (sidebar.classList.contains('collapsed')) {
                if (window.innerWidth >= 768) { // Only on desktop
                    mainNavbar.style.width = '100%';
                    mainNavbar.style.left = '0';
                    if (mainContent) mainContent.classList.add('content-expanded');
                }
                localStorage.setItem('sidebarState', 'collapsed');
            } else {
                if (window.innerWidth >= 768) { // Only on desktop
                    mainNavbar.style.width = 'calc(100% - 16rem)'; // 16rem is the width of sidebar (64px)
                    mainNavbar.style.left = '16rem';
                    if (mainContent) mainContent.classList.remove('content-expanded');
                }
                localStorage.setItem('sidebarState', 'expanded');
            }
        });

        // Check stored sidebar state on page load
        const storedSidebarState = localStorage.getItem('sidebarState');
        if (storedSidebarState === 'collapsed') {
            sidebar.classList.add('collapsed');
            if (window.innerWidth >= 768) { // Only on desktop
                mainNavbar.style.width = '100%';
                mainNavbar.style.left = '0';
                if (mainContent) mainContent.classList.add('content-expanded');
            }
        } else {
            if (window.innerWidth >= 768) {
                mainNavbar.style.width = 'calc(100% - 16rem)';
                mainNavbar.style.left = '16rem';
            }
        }

        // Handle window resize to adjust navbar position
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                if (sidebar.classList.contains('collapsed')) {
                    mainNavbar.style.width = '100%';
                    mainNavbar.style.left = '0';
                } else {
                    mainNavbar.style.width = 'calc(100% - 16rem)';
                    mainNavbar.style.left = '16rem';
                }
            } else {
                // On mobile, navbar is always full width
                mainNavbar.style.width = '100%';
                mainNavbar.style.left = '0';
            }
        });
    });
</script>