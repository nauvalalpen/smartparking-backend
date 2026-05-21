<!-- Top Header -->
<header class="bg-white shadow-sm border-b border-gray-200 h-16 flex items-center">
    <div class="w-full px-4 sm:px-6 lg:px-8 flex justify-between items-center">
        <!-- Left: Hamburger Menu (Mobile Only) + Page Title -->
        <div class="flex items-center space-x-4">
            <!-- Hamburger Menu Button (Mobile) -->
            <button @click="sidebarOpen = !sidebarOpen"
                class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }" class="inline-flex"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Page Heading (if provided) -->
            @isset($header)
                <div class="text-lg font-semibold text-gray-900 hidden sm:block">
                    {{ $header }}
                </div>
            @endisset
        </div>

        <!-- Right: Profile Dropdown -->
        <div x-data="{ profileOpen: false }" class="relative">
            <!-- Profile Button -->
            <button @click="profileOpen = !profileOpen"
                class="inline-flex items-center space-x-2 px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150">
                <div
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white text-sm font-semibold">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                </div>
                <div class="hidden sm:block">
                    <div class="text-sm font-medium text-gray-900">{{ Auth::user()->nama_lengkap }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <svg class="h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="profileOpen" @click.away="profileOpen = false"
                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-40 border border-gray-200"
                style="display: none;">
                <!-- Profile Link -->
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150">
                    <div class="font-medium">{{ Auth::user()->nama_lengkap }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </a>

                <div class="border-t border-gray-200"></div>

                <!-- Settings Link -->
                <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150">
                    {{ __('Profile Settings') }}
                </a>

                <div class="border-t border-gray-200"></div>

                <!-- Logout Link -->
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition duration-150"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
