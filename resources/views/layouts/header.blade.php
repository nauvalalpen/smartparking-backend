<!-- Top Header -->
<header class="sp-header">
    <div class="sp-header-inner">

        <!-- Left: Mobile hamburger + breadcrumb/title -->
        <div class="sp-header-left">
            <!-- Hamburger (mobile) -->
            <button @click="sidebarOpen = !sidebarOpen" class="sp-hamburger" aria-label="Toggle sidebar">
                <span :class="sidebarOpen ? 'sp-ham-open' : 'sp-ham-closed'" class="sp-ham-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </span>
                <span :class="sidebarOpen ? 'sp-ham-open' : 'sp-ham-closed'" class="sp-ham-icon" style="display:none">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </button>

            <!-- Page heading -->
            @isset($header)
                <div class="sp-page-title">{{ $header }}</div>
            @endisset
        </div>

        <!-- Right: Actions + Profile -->
        <div class="sp-header-right">

            <!-- Timestamp chip -->
            <div class="sp-time-chip" x-data="{ time: '' }" x-init="const pad = n => String(n).padStart(2, '0');
            const tick = () => {
                const d = new Date();
                time = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
            };
            tick();
            setInterval(tick, 1000);">
                <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke-width="2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                </svg>
                <span x-text="time" class="sp-time-text"></span>
            </div>

            <!-- Profile dropdown -->
            <div x-data="{ profileOpen: false }" class="sp-profile-wrap">
                <button @click="profileOpen = !profileOpen" class="sp-profile-btn">
                    <div class="sp-avatar">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                    </div>
                    <div class="sp-profile-info">
                        <span class="sp-profile-name">{{ Auth::user()->nama_lengkap }}</span>
                        <span class="sp-profile-role">Administrator</span>
                    </div>
                    <svg class="sp-chevron" width="14" height="14" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" :style="profileOpen ? 'transform:rotate(180deg)' : ''">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div x-show="profileOpen" @click.away="profileOpen = false" x-transition:enter="sp-drop-enter"
                    x-transition:enter-start="sp-drop-enter-start" x-transition:enter-end="sp-drop-enter-end"
                    x-transition:leave="sp-drop-enter" x-transition:leave-start="sp-drop-enter-end"
                    x-transition:leave-end="sp-drop-enter-start" class="sp-dropdown" style="display:none;">

                    <div class="sp-dropdown-header">
                        <div class="sp-avatar sp-avatar-lg">
                            {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                        </div>
                        <div>
                            <div class="sp-dd-name">{{ Auth::user()->nama_lengkap }}</div>
                            <div class="sp-dd-email">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="sp-dropdown-divider"></div>

                    <a href="{{ route('profile.edit') }}" class="sp-dropdown-item">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile Settings
                    </a>

                    <div class="sp-dropdown-divider"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sp-dropdown-item sp-dropdown-danger">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    .sp-header {
        background: var(--bg-surface);
        border-bottom: 1px solid var(--border);
        height: 60px;
        flex-shrink: 0;
        position: sticky;
        top: 0;
        z-index: 20;
    }

    .sp-header-inner {
        height: 100%;
        padding: 0 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .sp-header-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .sp-header-right {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Hamburger */
    .sp-hamburger {
        display: none;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: transparent;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all var(--transition);
    }

    .sp-hamburger:hover {
        background: var(--bg-base);
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .sp-hamburger {
            display: flex;
        }
    }

    /* Page title */
    .sp-page-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-primary);
        letter-spacing: -0.01em;
    }

    /* Time chip */
    .sp-time-chip {
        display: flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        background: var(--bg-base);
        border: 1px solid var(--border);
        border-radius: 99px;
        color: var(--text-muted);
    }

    .sp-time-text {
        font-family: var(--font-mono);
        font-size: 11px;
        letter-spacing: 0.04em;
    }

    @media (max-width: 640px) {
        .sp-time-chip {
            display: none;
        }
    }

    /* Profile button */
    .sp-profile-wrap {
        position: relative;
    }

    .sp-profile-btn {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 5px 10px 5px 5px;
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        background: transparent;
        cursor: pointer;
        transition: all var(--transition);
    }

    .sp-profile-btn:hover {
        background: var(--bg-base);
        border-color: var(--text-muted);
    }

    .sp-avatar {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--accent), #F59E0B);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        letter-spacing: 0.02em;
    }

    .sp-avatar-lg {
        width: 36px;
        height: 36px;
        font-size: 14px;
        border-radius: 10px;
    }

    .sp-profile-info {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .sp-profile-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        line-height: 1.2;
    }

    .sp-profile-role {
        font-size: 11px;
        color: var(--text-muted);
    }

    @media (max-width: 640px) {
        .sp-profile-info {
            display: none;
        }
    }

    .sp-chevron {
        color: var(--text-muted);
        transition: transform var(--transition);
        flex-shrink: 0;
    }

    /* Dropdown */
    .sp-dropdown {
        position: absolute;
        right: 0;
        top: calc(100% + 8px);
        width: 220px;
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        z-index: 50;
    }

    .sp-dropdown-header {
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sp-dd-name {
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
    }

    .sp-dd-email {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .sp-dropdown-divider {
        height: 1px;
        background: var(--border-soft);
        margin: 0;
    }

    .sp-dropdown-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        width: 100%;
        font-size: 13px;
        color: var(--text-secondary);
        text-decoration: none;
        background: none;
        border: none;
        cursor: pointer;
        text-align: left;
        transition: all var(--transition);
    }

    .sp-dropdown-item:hover {
        background: var(--bg-base);
        color: var(--text-primary);
    }

    .sp-dropdown-danger:hover {
        color: #DC2626;
        background: #FEF2F2;
    }

    /* Transition helpers */
    .sp-drop-enter {
        transition: opacity 120ms ease, transform 120ms ease;
    }

    .sp-drop-enter-start {
        opacity: 0;
        transform: translateY(-6px);
    }

    .sp-drop-enter-end {
        opacity: 1;
        transform: translateY(0);
    }
</style>
