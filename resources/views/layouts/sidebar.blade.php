<!-- Sidebar -->
<aside :class="{ '-translate-x-full md:translate-x-0': !sidebarOpen, 'translate-x-0': sidebarOpen }" class="sp-sidebar">

    <!-- Branding -->
    <a href="{{ route('dashboard') }}" class="sp-sidebar-brand">
        <div class="sp-brand-logo">PNP</div>
        <div class="sp-brand-text">
            <span class="sp-brand-name">Smart Parking</span>
        </div>
    </a>

    <!-- Nav section label -->
    <div class="sp-nav-section-label">Menu Utama</div>

    <!-- Navigation -->
    <nav class="sp-nav">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="sp-nav-item {{ request()->routeIs('dashboard') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                    <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                    <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                    <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                </svg>
            </span>
            <span class="sp-nav-label">Dashboard</span>
            @if (request()->routeIs('dashboard'))
                <span class="sp-nav-dot"></span>
            @endif
        </a>

        <!-- Area Parkiran -->
        <a href="{{ route('area.index') }}"
            class="sp-nav-item {{ request()->routeIs('area.*') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </span>
            <span class="sp-nav-label">Area Parkiran</span>
            @if (request()->routeIs('area.*'))
                <span class="sp-nav-dot"></span>
            @endif
        </a>

        <!-- Kamera CCTV -->
        <a href="{{ route('kamera.index') }}"
            class="sp-nav-item {{ request()->routeIs('kamera.*') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
            <span class="sp-nav-label">Kamera CCTV</span>
            @if (request()->routeIs('kamera.*'))
                <span class="sp-nav-dot"></span>
            @endif
        </a>

        <!-- Konfigurasi RoI -->
        <a href="{{ route('roi.index') }}" class="sp-nav-item {{ request()->routeIs('roi.*') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 20v-4m0 4h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                </svg>
            </span>
            <span class="sp-nav-label">Konfigurasi RoI</span>
            @if (request()->routeIs('roi.*'))
                <span class="sp-nav-dot"></span>
            @endif
        </a>

        <!-- Manajemen Petugas -->
        <a href="{{ route('pengguna.index') }}"
            class="sp-nav-item {{ request()->routeIs('pengguna.*') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </span>
            <span class="sp-nav-label">Manajemen Petugas</span>
            @if (request()->routeIs('pengguna.*'))
                <span class="sp-nav-dot"></span>
            @endif
        </a>

        <!-- Laporan Data -->
        <a href="{{ route('laporan.index') }}"
            class="sp-nav-item {{ request()->routeIs('laporan.*') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </span>
            <span class="sp-nav-label">Laporan Data</span>
            @if (request()->routeIs('laporan.*'))
                <span class="sp-nav-dot"></span>
            @endif
        </a>
    </nav>

    <!-- Bottom section -->
    <div class="sp-sidebar-bottom">
        <div class="sp-nav-section-label">Akun</div>

        <a href="{{ route('profile.edit') }}"
            class="sp-nav-item {{ request()->routeIs('profile.*') ? 'sp-nav-active' : '' }}">
            <span class="sp-nav-icon">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </span>
            <span class="sp-nav-label">Pengaturan</span>
        </a>

        <!-- System status indicator -->
        {{-- <div class="sp-system-status">
            <span class="sp-status-dot"></span>
            <span class="sp-status-text">Sistem Aktif</span>
        </div> --}}
    </div>
</aside>

<!-- Mobile overlay -->
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="sp-overlay" style="display:none;"></div>

<style>
    .sp-sidebar {
        width: 240px;
        flex-shrink: 0;
        background: var(--sidebar-bg);
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        overflow-x: hidden;
        transition: transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        z-index: 30;
    }

    /* Scrollbar inside sidebar */
    .sp-sidebar::-webkit-scrollbar {
        width: 3px;
    }

    .sp-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sp-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.08);
        border-radius: 99px;
    }

    /* Branding */
    .sp-sidebar-brand {
        padding: 20px 20px 18px;
        display: flex;
        align-items: center;
        gap: 11px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        flex-shrink: 0;
    }

    .sp-brand-logo {
        width: 36px;
        height: 36px;
        background: var(--accent);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-mono);
        font-size: 12px;
        font-weight: 500;
        color: #fff;
        letter-spacing: 0.04em;
        flex-shrink: 0;
    }

    .sp-brand-text {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .sp-brand-name {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
        line-height: 1.2;
    }

    .sp-brand-sub {
        font-size: 11px;
        color: var(--sidebar-muted);
    }

    /* Section labels */
    .sp-nav-section-label {
        padding: 18px 20px 6px;
        font-size: 10px;
        font-weight: 600;
        color: var(--sidebar-muted);
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* Nav items */
    .sp-nav {
        padding: 4px 12px;
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .sp-nav-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 10px;
        border-radius: var(--radius-sm);
        color: var(--sidebar-text);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 450;
        transition: all var(--transition);
        position: relative;
    }

    .sp-nav-item:hover {
        background: var(--sidebar-hover-bg);
        color: #fff;
    }

    .sp-nav-active {
        background: var(--sidebar-active-bg) !important;
        color: var(--sidebar-active-text) !important;
    }

    .sp-nav-active .sp-nav-icon {
        color: var(--accent);
    }

    .sp-nav-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--sidebar-muted);
        transition: color var(--transition);
    }

    .sp-nav-item:hover .sp-nav-icon {
        color: rgba(255, 255, 255, 0.7);
    }

    .sp-nav-label {
        flex: 1;
    }

    .sp-nav-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--accent);
        flex-shrink: 0;
    }

    /* Bottom section */
    .sp-sidebar-bottom {
        margin-top: auto;
        padding-bottom: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.06);
    }

    .sp-sidebar-bottom .sp-nav {
        padding-top: 4px;
    }

    /* Status indicator */
    .sp-system-status {
        margin: 8px 20px 0;
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 8px 10px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: var(--radius-sm);
    }

    .sp-status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #22C55E;
        flex-shrink: 0;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        animation: sp-pulse 2s ease-in-out infinite;
    }

    @keyframes sp-pulse {

        0%,
        100% {
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        50% {
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
        }
    }

    .sp-status-text {
        font-size: 11px;
        color: var(--sidebar-muted);
    }

    /* Mobile overlay */
    .sp-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.55);
        backdrop-filter: blur(2px);
        z-index: 20;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .sp-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 30;
        }
    }
</style>
