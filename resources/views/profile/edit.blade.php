<x-app-layout>
    <x-slot name="header">Pengaturan Akun</x-slot>

    <div x-data="{
        activeTab: 'profile',
        showDelete: false,
        setTab(tab) {
            this.activeTab = tab;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }" @keydown.escape.window="showDelete = false">

        {{-- FLASH TOASTS --}}
        @if (session('status') === 'profile-updated')
            <div class="ps-toast ps-toast--success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="ps-toast-enter" x-transition:leave="ps-toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Profil berhasil diperbarui!
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="ps-toast ps-toast--success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="ps-toast-enter" x-transition:leave="ps-toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Password berhasil diubah!
            </div>
        @endif

        @if (session('status') === 'verification-link-sent')
            <div class="ps-toast ps-toast--success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="ps-toast-enter" x-transition:leave="ps-toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Link verifikasi telah dikirim ke email Anda!
            </div>
        @endif

        {{-- PAGE HEADER --}}
        <div class="ps-page-header">
            <h1 class="ps-page-title">Pengaturan Akun</h1>
            <p class="ps-page-sub">Kelola profil, keamanan, dan preferensi akun Anda.</p>
        </div>

        {{-- LAYOUT: SIDEBAR + CONTENT --}}
        <div class="ps-layout">

            {{-- SIDEBAR --}}
            <aside class="ps-sidebar">
                <nav class="ps-nav">
                    <button @click="setTab('profile')"
                        :class="activeTab === 'profile' ? 'ps-nav__item ps-nav__item--active' : 'ps-nav__item'">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Informasi Profil</span>
                    </button>

                    <button @click="setTab('security')"
                        :class="activeTab === 'security' ? 'ps-nav__item ps-nav__item--active' : 'ps-nav__item'">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Keamanan</span>
                    </button>

                    <div class="ps-nav__divider"></div>

                    <button @click="setTab('danger')"
                        :class="activeTab === 'danger' ? 'ps-nav__item ps-nav__item--danger ps-nav__item--active' :
                            'ps-nav__item ps-nav__item--danger'">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus Akun</span>
                    </button>
                </nav>
            </aside>

            {{-- MAIN CONTENT --}}
            <main class="ps-content">

                {{-- TAB: PROFIL --}}
                <div x-show="activeTab === 'profile'" x-transition style="display:none;">
                    <div class="ps-section-header">
                        <h2 class="ps-section-title">Informasi Profil</h2>
                        <p class="ps-section-sub">Perbarui nama dan email akun Anda.</p>
                    </div>
                    <div class="ps-card">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- TAB: KEAMANAN --}}
                <div x-show="activeTab === 'security'" x-transition style="display:none;">
                    <div class="ps-section-header">
                        <h2 class="ps-section-title">Keamanan Akun</h2>
                        <p class="ps-section-sub">Kelola password dan preferensi keamanan login Anda.</p>
                    </div>

                    <div class="ps-card ps-card--mb">
                        <div class="ps-card-header">
                            <div class="ps-card-icon ps-card-icon--blue">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="ps-card-title">Ubah Password</h3>
                                <p class="ps-card-desc">Gunakan password yang kuat dan unik.</p>
                            </div>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="ps-info-card">
                        <div class="ps-info-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="ps-info-title">Tips Keamanan</h4>
                            <ul class="ps-info-list">
                                <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                                <li>Hindari menggunakan nama pribadi atau tanggal lahir</li>
                                <li>Password minimal 8 karakter</li>
                                <li>Jangan bagikan password dengan siapa pun</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- TAB: DANGER --}}
                <div x-show="activeTab === 'danger'" x-transition style="display:none;">
                    <div class="ps-section-header">
                        <h2 class="ps-section-title">Zona Berbahaya</h2>
                        <p class="ps-section-sub">Tindakan di area ini bersifat permanen dan tidak dapat dibatalkan.
                        </p>
                    </div>

                    <div class="ps-card ps-card--danger">
                        <div class="ps-card-header">
                            <div class="ps-card-icon ps-card-icon--red">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="ps-card-title">Hapus Akun Secara Permanen</h3>
                                <p class="ps-card-desc">Semua data Anda akan dihapus dan tidak bisa dipulihkan.</p>
                            </div>
                        </div>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </main>
        </div>

        {{-- MODAL: KONFIRMASI HAPUS --}}
        <div x-show="showDelete" class="ps-modal-backdrop" @click.self="showDelete = false" style="display:none;"
            x-transition:enter="ps-fade" x-transition:enter-start="ps-opacity-0"
            x-transition:enter-end="ps-opacity-100" x-transition:leave="ps-fade"
            x-transition:leave-start="ps-opacity-100" x-transition:leave-end="ps-opacity-0">

            <div class="ps-modal" x-transition:enter="ps-pop" x-transition:enter-start="ps-pop-out"
                x-transition:enter-end="ps-pop-in" x-transition:leave="ps-pop" x-transition:leave-start="ps-pop-in"
                x-transition:leave-end="ps-pop-out">

                <div class="ps-modal__body">
                    <div class="ps-modal__icon">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="ps-modal__title">Hapus Akun?</h3>
                    <p class="ps-modal__desc">Akun Anda akan dihapus secara permanen. Masukkan password untuk
                        mengkonfirmasi.</p>
                    <p class="ps-modal__warn">Tindakan ini tidak dapat dibatalkan.</p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="ps-modal__field">
                        <label class="ps-label">Password <span class="ps-required">*</span></label>
                        <input type="password" name="password" class="ps-input" placeholder="Masukkan password Anda"
                            required autofocus>
                        @if ($errors->userDeletion->has('password'))
                            <p class="ps-error">
                                @foreach ($errors->userDeletion->get('password') as $error)
                                    {{ $error }}
                                @endforeach
                            </p>
                        @endif
                    </div>

                    <div class="ps-modal__footer">
                        <button type="button" @click="showDelete = false"
                            class="ps-btn ps-btn--ghost">Batal</button>
                        <button type="submit" class="ps-btn ps-btn--danger">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Ya, Hapus Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- end x-data --}}

    @include('layouts.table-styles')

    <style>
        /* ═══════════════════════════════════
           PREFIXED: ps- (profile-settings)
           Semua class pakai prefix agar tidak
           bentrok dengan global styles.
        ═══════════════════════════════════ */

        /* PAGE HEADER */
        .ps-page-header {
            margin-bottom: 28px;
        }

        .ps-page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .ps-page-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 3px;
        }

        /* TOAST */
        .ps-toast {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .ps-toast--success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #15803D;
        }

        .ps-toast-enter {
            transition: opacity 200ms ease, transform 200ms ease;
        }

        .ps-toast-leave {
            transition: opacity 150ms ease;
        }

        /* LAYOUT */
        .ps-layout {
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 24px;
            align-items: start;
        }

        /* SIDEBAR */
        .ps-sidebar {
            position: sticky;
            top: 16px;
        }

        .ps-nav {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .ps-nav__item {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-left: 3px solid transparent;
            background: none;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            transition: all 120ms ease;
        }

        .ps-nav__item:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        .ps-nav__item--active {
            background: rgba(217, 119, 6, .06);
            color: var(--accent);
            border-left-color: var(--accent);
            font-weight: 600;
        }

        .ps-nav__item--danger {
            color: #DC2626;
        }

        .ps-nav__item--danger:hover {
            background: #FEF2F2;
        }

        .ps-nav__item--danger.ps-nav__item--active {
            background: #FEF2F2;
            border-left-color: #DC2626;
        }

        .ps-nav__divider {
            height: 1px;
            background: var(--border-soft, #eee);
        }

        /* CONTENT */
        .ps-content {
            min-width: 0;
        }

        .ps-section-header {
            margin-bottom: 16px;
        }

        .ps-section-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ps-section-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* CARD */
        .ps-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px 24px;
        }

        .ps-card--mb {
            margin-bottom: 16px;
        }

        .ps-card--danger {
            border-color: #FCA5A5;
            background: #FFFBFB;
        }

        /* CARD HEADER (icon + title row) */
        .ps-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-soft, #eee);
        }

        .ps-card-icon {
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ps-card-icon--blue {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .ps-card-icon--red {
            background: #FEE2E2;
            color: #DC2626;
        }

        .ps-card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ps-card-desc {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 1px;
        }

        /* INFO CARD */
        .ps-info-card {
            display: flex;
            gap: 12px;
            padding: 14px 16px;
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 10px;
        }

        .ps-info-icon {
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #15803D;
        }

        .ps-info-title {
            font-size: 13px;
            font-weight: 700;
            color: #15803D;
            margin-bottom: 6px;
        }

        .ps-info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .ps-info-list li {
            font-size: 12px;
            color: #166534;
            line-height: 1.5;
        }

        /* FORM */
        .ps-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .ps-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ps-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .ps-required {
            color: #DC2626;
        }

        .ps-input {
            height: 36px;
            padding: 0 12px;
            border: 1px solid var(--border);
            border-radius: 7px;
            font-size: 13px;
            font-family: inherit;
            background: var(--bg-base);
            color: var(--text-primary);
            transition: border-color 120ms ease, box-shadow 120ms ease;
            width: 100%;
            box-sizing: border-box;
        }

        .ps-input:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--bg-surface);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, .12);
        }

        .ps-hint {
            font-size: 11px;
            color: var(--text-muted, #9ca3af);
        }

        .ps-error {
            font-size: 11px;
            color: #DC2626;
        }

        /* BUTTONS */
        .ps-btn-group {
            display: flex;
            gap: 10px;
            margin-top: 6px;
        }

        .ps-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 34px;
            padding: 0 14px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 120ms ease;
            white-space: nowrap;
        }

        .ps-btn--primary {
            background: var(--accent);
            color: white;
        }

        .ps-btn--primary:hover {
            background: var(--accent-hover, #b45309);
            transform: translateY(-1px);
        }

        .ps-btn--primary:active {
            transform: translateY(0);
        }

        .ps-btn--ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            flex: 1;
            justify-content: center;
        }

        .ps-btn--ghost:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        .ps-btn--danger {
            background: #DC2626;
            color: white;
            flex: 1;
            justify-content: center;
        }

        .ps-btn--danger:hover {
            background: #B91C1C;
        }

        .ps-btn--danger-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 34px;
            padding: 0 14px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid #DC2626;
            background: transparent;
            color: #DC2626;
            transition: all 120ms ease;
        }

        .ps-btn--danger-outline:hover {
            background: #FEF2F2;
        }

        /* DANGER LIST */
        .ps-danger-desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .ps-danger-list {
            list-style: none;
            padding: 0;
            margin: 0 0 18px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .ps-danger-list li {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* VERIFY NOTICE */
        .ps-verify {
            margin-top: 10px;
            padding: 10px 12px;
            background: #FEF3C7;
            border: 1px solid #FCD34D;
            border-radius: 7px;
        }

        .ps-verify p {
            font-size: 12px;
            color: #92400E;
            margin: 0 0 8px;
        }

        /* MODAL */
        .ps-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 60;
            background: rgba(15, 15, 15, .4);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .ps-fade {
            transition: opacity 180ms ease;
        }

        .ps-opacity-0 {
            opacity: 0;
        }

        .ps-opacity-100 {
            opacity: 1;
        }

        .ps-pop {
            transition: transform 200ms cubic-bezier(.4, 0, .2, 1), opacity 200ms ease;
        }

        .ps-pop-out {
            transform: scale(.94) translateY(6px);
            opacity: 0;
        }

        .ps-pop-in {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .ps-modal {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .15), 0 4px 12px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .ps-modal__body {
            padding: 28px 24px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .ps-modal__icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #FEE2E2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DC2626;
            margin-bottom: 2px;
        }

        .ps-modal__title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .ps-modal__desc {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .ps-modal__warn {
            font-size: 12px;
            color: #DC2626;
            font-weight: 600;
        }

        .ps-modal__field {
            padding: 0 24px 20px;
        }

        .ps-modal__footer {
            display: flex;
            gap: 10px;
            padding: 14px 24px;
            border-top: 1px solid var(--border-soft, #eee);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .ps-layout {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .ps-sidebar {
                position: static;
            }

            .ps-nav {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
            }

            .ps-nav__item {
                padding: 9px 8px;
                font-size: 12px;
                border-left: none;
                border-bottom: 3px solid transparent;
                justify-content: center;
            }

            .ps-nav__item--active {
                border-bottom-color: var(--accent);
                border-left: none;
            }

            .ps-nav__item--danger.ps-nav__item--active {
                border-bottom-color: #DC2626;
                border-left: none;
            }

            .ps-nav__divider {
                display: none;
            }
        }
    </style>
</x-app-layout>
