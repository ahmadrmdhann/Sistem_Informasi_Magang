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

        // Toggle dropdown when clicking the button
        dropdownToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdownContainer.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Prevent clicks inside dropdown from closing it
        dropdownMenu.addEventListener('click', function (e) {
            e.stopPropagation();
        });

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
