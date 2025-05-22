<div id="sidebar"
    class="fixed left-0 top-[61px] h-[calc(100vh-61px)] bg-white border-r border-gray-200 w-64 transition-all duration-300 z-20 shadow-md overflow-hidden">
    <div class="flex justify-center border-b border-gray-100">
        <img src="{{asset('images/logo.svg')}}" alt="Logo" class="w-40 mx-auto mb-6">
    </div>

    <!-- Close button for mobile -->
    <button id="closeSidebarBtn" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 md:hidden">
        <i class="fa-solid fa-times text-lg"></i>
    </button>

    <!-- Navigation -->
    <div class="py-4 px-3 overflow-y-auto h-[calc(100%-80px)]">
        <!-- Dashboard -->
        <div class="mb-3">
            <a href="{{ url('/dashboard') }}"
                class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                <div
                    class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600 {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}">
                    <i class="fa-solid fa-home"></i>
                </div>
                <span class="text-sm">Dashboard</span>
            </a>
        </div>

        @if (Auth::user()->level->level_kode == 'ADM')
            <div class="mb-4">
                <p class="px-4 mt-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Administrasi
                </p>
                <a href="{{ route('level.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <span class="text-sm">Manajemen Level</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-file-alt"></i>
                    </div>
                    <span class="text-sm">Manajemen Pengguna</span>
                </a>
                <a href="{{ route('prodi.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="text-sm">Manajemen Program Studi</span>
                </a>
            </div>

            <div class="mb-4">
                <p class="px-4 mt-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Manajemen Magang
                </p>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-building"></i>
                    </div>
                    <span class="text-sm">Manajemen Mitra</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="text-sm">Manajemen Periode Magang</span>
                </a>
                <a href="{{ route('lowongan.index') }}"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="text-sm">Manajemen Lowongan Magang</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="text-sm">Pengajuan Magang Mahasiswa</span>
                </a>
            </div>
        @elseif (Auth::user()->level->level_kode == 'DSN')
            <div class="mb-4">
                <p class="px-4 mt-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Bimbingan
                </p>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-user-graduate"></i>
                    </div>
                    <span class="text-sm">Mahasiswa Bimbingan</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-tasks"></i>
                    </div>
                    <span class="text-sm">Monitoring Progres</span>
                </a>
            </div>
        @elseif (Auth::user()->level->level_kode == 'MHS')
            <!-- Internship Section -->
            <div class="mb-4">
                <p class="px-4 mt-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Manajemen Magang
                </p>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group mb-1">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-file-alt"></i>
                    </div>
                    <span class="text-sm">Rekomendasi Magang</span>
                </a>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-briefcase"></i>
                    </div>
                    <span class="text-sm">Pengajuan Magang</span>
                </a>
            </div>

            <!-- Progress Section -->
            <div class="mb-4">
                <p class="px-4 mt-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    Log Kegiatan
                </p>
                <a href="#"
                    class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-blue-50 rounded-lg transition-all duration-200 group">
                    <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-blue-600">
                        <i class="fa-solid fa-tasks"></i>
                    </div>
                    <span class="text-sm">Kegiatan Magang</span>
                </a>
            </div>
        @endif

        <!-- User section at bottom -->
        <div class="mt-auto pt-4 border-t border-gray-100">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-red-50 rounded-lg transition-all duration-200 group">
                <div class="w-5 h-5 mr-3 text-center text-gray-500 group-hover:text-red-600">
                    <i class="fa-solid fa-sign-out-alt"></i>
                </div>
                <span class="text-sm">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</div>

<!-- Mobile Sidebar Overlay -->
<div id="sidebarOverlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden md:hidden"></div>

<!-- Mobile Toggle Button -->
<button id="openSidebarBtn"
    class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg md:hidden z-10 hover:bg-blue-700 focus:outline-none">
    <i class="fa-solid fa-bars"></i>
</button>

<style>
    /* Sidebar collapsed state for desktop */
    @media (min-width: 768px) {
        #sidebar.collapsed {
            width: 0;
            overflow: hidden;
        }

        /* Adjust main content when sidebar is collapsed */
        .content-expanded {
            margin-left: 0 !important;
            width: 100% !important;
        }
    }

    /* For mobile - different collapse behavior */
    @media (max-width: 767px) {
        #sidebar.collapsed {
            transform: translateX(-100%);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const closeSidebarBtn = document.getElementById('closeSidebarBtn');
        const mainNavbar = document.getElementById('mainNavbar');

        // Check if we're on mobile
        const isMobile = window.innerWidth < 768;

        // Initially hide sidebar on mobile
        if (isMobile) {
            sidebar.classList.add('-translate-x-full');
        }

        // Open sidebar on mobile
        openSidebarBtn.addEventListener('click', function () {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.remove('collapsed'); // Ensure collapsed state is removed
            sidebarOverlay.classList.remove('hidden');

            // Update navbar if we're on desktop
            if (window.innerWidth >= 768) {
                mainNavbar.style.width = 'calc(100% - 16rem)';
                mainNavbar.style.left = '16rem';
            }

            // Set proper top position for mobile
            if (window.innerWidth < 768) {
                const navbarHeight = document.querySelector('nav').offsetHeight;
                const mobileSearchHeight = document.querySelector('.md\\:hidden.bg-white.border-b').offsetHeight || 0;
                sidebar.style.top = (navbarHeight + mobileSearchHeight) + 'px';
                sidebar.style.height = `calc(100vh - ${navbarHeight + mobileSearchHeight}px)`;
            }
        });

        // Close sidebar when clicking the close button or overlay
        function closeSidebar() {
            if (window.innerWidth < 768) {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        }

        closeSidebarBtn.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Handle window resize
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
                sidebar.style.top = '61px'; // Reset to default for desktop
                sidebar.style.height = 'calc(100vh - 61px)'; // Reset to default for desktop

                // Update navbar width based on sidebar state
                if (sidebar.classList.contains('collapsed')) {
                    mainNavbar.style.width = '100%';
                    mainNavbar.style.left = '0';
                } else {
                    mainNavbar.style.width = 'calc(100% - 16rem)';
                    mainNavbar.style.left = '16rem';
                }
            } else {
                // Only add -translate-x-full if the sidebar should be hidden on mobile
                if (!sidebar.classList.contains('collapsed')) {
                    sidebar.classList.add('-translate-x-full');
                }

                // On mobile, navbar is always full width
                mainNavbar.style.width = '100%';
                mainNavbar.style.left = '0';
            }
        });
    });
</script>