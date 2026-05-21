<!-- Sidebar -->
<div :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }"
    class="fixed left-0 top-0 h-screen w-64 bg-gray-900 text-white overflow-y-auto transition-transform duration-300 ease-in-out z-30 md:relative md:translate-x-0">
    <!-- Logo / Branding -->
    <div class="p-6 border-b border-gray-800 flex items-center space-x-2">
        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-lg">
            SP
        </div>
        <div>
            <h1 class="text-xl font-bold">Smart Parking</h1>
            <p class="text-xs text-gray-400">PNP System</p>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="p-4 space-y-2">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l4-8m-4 8l-4-8" />
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <!-- Area Parkiran -->
        <a href="{{ route('area.index') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('area.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-medium">Area Parkiran</span>
        </a>

        <!-- Kamera CCTV -->
        <a href="{{ route('kamera.index') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('kamera.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium">Kamera CCTV</span>
        </a>

        <!-- Konfigurasi RoI -->
        <a href="{{ route('roi.index') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('roi.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 20v-4m0 4h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
            </svg>
            <span class="font-medium">Konfigurasi RoI</span>
        </a>

        <!-- Manajemen Petugas -->
        <a href="{{ route('pengguna.index') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('pengguna.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3.615a2.385 2.385 0 01-2.372-2.372V10.257A2.385 2.385 0 013.615 7.885h16.77a2.384 2.384 0 012.368 2.372v8.371a2.385 2.385 0 01-2.368 2.372z" />
            </svg>
            <span class="font-medium">Manajemen Petugas</span>
        </a>

        <!-- Laporan Data -->
        <a href="{{ route('laporan.index') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors duration-200 {{ request()->routeIs('laporan.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span class="font-medium">Laporan Data</span>
        </a>
    </nav>

    <!-- Divider -->
    <div class="border-t border-gray-800"></div>

    <!-- Additional Links (Optional) -->
    <div class="p-4 space-y-2">
        <a href="{{ route('profile.edit') }}"
            class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span class="font-medium">Settings</span>
        </a>
    </div>
</div>

<!-- Overlay for Mobile -->
<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden transition-opacity duration-300" style="display: none;">
</div>
