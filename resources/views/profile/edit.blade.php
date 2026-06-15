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

        {{-- ══════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════ --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Pengaturan Akun</h1>
                <p class="page-sub">Kelola profil, keamanan, dan preferensi akun Anda.</p>
            </div>
        </div>

        {{-- ══════════════════════════════════════════
         FLASH TOASTS
    ══════════════════════════════════════════ --}}
        @if (session('status') === 'profile-updated')
            <div class="toast toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="toast-enter" x-transition:leave="toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Profil berhasil diperbarui!
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="toast toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="toast-enter" x-transition:leave="toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Password berhasil diubah!
            </div>
        @endif

        @if (session('status') === 'verification-link-sent')
            <div class="toast toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="toast-enter" x-transition:leave="toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Link verifikasi telah dikirim ke email Anda!
            </div>
        @endif

        {{-- ══════════════════════════════════════════
         SETTINGS LAYOUT — SIDEBAR + CONTENT
    ══════════════════════════════════════════ --}}
        <div class="settings-layout">
            {{-- SIDEBAR NAVIGATION --}}
            <aside class="settings-sidebar">
                <nav class="settings-nav">
                    {{-- Profile Section --}}
                    <button @click="setTab('profile')"
                        :class="{ 'nav-item active': activeTab === 'profile', 'nav-item': activeTab !== 'profile' }">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Informasi Profil</span>
                    </button>

                    {{-- Security Section --}}
                    <button @click="setTab('security')"
                        :class="{ 'nav-item active': activeTab === 'security', 'nav-item': activeTab !== 'security' }">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Keamanan</span>
                    </button>

                    {{-- Danger Zone --}}
                    <div class="nav-divider"></div>
                    <button @click="setTab('danger')"
                        :class="{ 'nav-item active danger': activeTab === 'danger', 'nav-item danger': activeTab !== 'danger' }">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Hapus Akun</span>
                    </button>
                </nav>
            </aside>

            {{-- MAIN CONTENT AREA --}}
            <main class="settings-content">

                {{-- ════════════════════════════════════════════
                 TAB 1: INFORMASI PROFIL
            ════════════════════════════════════════════ --}}
                <div x-show="activeTab === 'profile'" x-transition:enter="fade-enter" x-transition:leave="fade-leave"
                    style="display:none;">
                    <div class="content-header">
                        <div>
                            <h2 class="content-title">Informasi Profil</h2>
                            <p class="content-sub">Perbarui nama, email, dan informasi dasar akun Anda.</p>
                        </div>
                    </div>

                    <div class="card">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- ════════════════════════════════════════════
                 TAB 2: KEAMANAN (PASSWORD)
            ════════════════════════════════════════════ --}}
                <div x-show="activeTab === 'security'" x-transition:enter="fade-enter" x-transition:leave="fade-leave"
                    style="display:none;">
                    <div class="content-header">
                        <div>
                            <h2 class="content-title">Keamanan Akun</h2>
                            <p class="content-sub">Kelola password dan preferensi keamanan login Anda.</p>
                        </div>
                    </div>

                    {{-- Password Change Card --}}
                    <div class="card" style="margin-bottom:24px;">
                        <div class="section-header">
                            <div class="section-header-icon section-header-icon-blue">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="section-title">Ubah Password</h3>
                                <p class="section-sub">Gunakan password yang kuat dan unik untuk keamanan maksimal.</p>
                            </div>
                        </div>

                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Security Tips Card --}}
                    <div class="info-card">
                        <div class="info-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="info-title">Tips Keamanan</h4>
                            <ul class="info-list">
                                <li>Gunakan kombinasi huruf besar, kecil, angka, dan simbol</li>
                                <li>Hindari menggunakan nama pribadi atau tanggal lahir</li>
                                <li>Password minimal 8 karakter</li>
                                <li>Jangan bagikan password dengan siapa pun</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- ════════════════════════════════════════════
                 TAB 3: DANGER ZONE (DELETE ACCOUNT)
            ════════════════════════════════════════════ --}}
                <div x-show="activeTab === 'danger'" x-transition:enter="fade-enter" x-transition:leave="fade-leave"
                    style="display:none;">
                    <div class="content-header">
                        <div>
                            <h2 class="content-title">Zona Berbahaya</h2>
                            <p class="content-sub">Tindakan di area ini dapat mempengaruhi akun Anda secara permanen.
                            </p>
                        </div>
                    </div>

                    <div class="card card-danger">
                        <div class="section-header">
                            <div class="section-header-icon section-header-icon-red">
                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="section-title">Hapus Akun Secara Permanen</h3>
                                <p class="section-sub">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan
                                    dihapus.</p>
                            </div>
                        </div>

                        <p style="color:var(--text-secondary); font-size:13px; line-height:1.6; margin:20px 0;">
                            Setelah akun Anda dihapus:
                        </p>
                        <ul
                            style="color:var(--text-secondary); font-size:13px; line-height:1.8; margin:0 0 20px 20px; padding:0;">
                            <li>✗ Semua profil dan data pribadi akan dihapus</li>
                            <li>✗ Riwayat aktivitas akan dihapus</li>
                            <li>✗ Email Anda tidak akan lagi terdaftar di sistem</li>
                            <li>✗ Tidak ada cara untuk memulihkan data ini</li>
                        </ul>

                        <button type="button" @click="showDelete = true" class="btn-danger-outline"
                            style="justify-content:center;">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Akun Saya
                        </button>
                    </div>
                </div>

            </main>
        </div>

        {{-- ══════════════════════════════════════════
         MODAL — DELETE ACCOUNT CONFIRM
    ══════════════════════════════════════════ --}}
        <div x-show="showDelete" class="modal-backdrop" @click.self="showDelete = false" style="display:none;"
            x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="modal-box modal-box-sm" x-transition:enter="t-pop" x-transition:enter-start="pop-out"
                x-transition:enter-end="pop-in" x-transition:leave="t-pop" x-transition:leave-start="pop-in"
                x-transition:leave-end="pop-out">

                <div class="delete-body">
                    <div class="delete-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="delete-title">Hapus Akun?</h3>
                    <p class="delete-sub">
                        Akun Anda akan dihapus secara permanen. Masukkan password Anda untuk mengkonfirmasi tindakan
                        ini.
                    </p>
                    <p class="delete-warn">Tindakan ini tidak dapat dibatalkan.</p>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}" class="delete-footer">
                    @csrf
                    @method('delete')

                    <div style="padding: 0 20px; margin-bottom: 20px; width: 100%;">
                        <label class="field-label">Password <span class="field-required">*</span></label>
                        <input type="password" name="password" class="field-input"
                            placeholder="Masukkan password Anda" required autofocus>
                        @if ($errors->userDeletion->has('password'))
                            <p style="font-size: 11px; color: #DC2626; margin-top: 6px;">
                                @foreach ($errors->userDeletion->get('password') as $error)
                                    {{ $error }}
                                @endforeach
                            </p>
                        @endif
                    </div>

                    <div style="display:flex; gap:12px; padding:16px 20px; border-top:1px solid var(--border-soft);">
                        <button type="button" @click="showDelete = false" class="btn-ghost-sm"
                            style="flex:1; justify-content:center;">
                            Batal
                        </button>
                        <button type="submit" class="btn-danger" style="flex:1;">
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
        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .page-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ── TOASTS ── */
        .toast {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
        }

        .toast-success {
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            color: #15803D;
        }

        .toast-enter {
            transition: opacity 200ms ease, transform 200ms ease;
        }

        .toast-enter-start {
            opacity: 0;
            transform: translateY(-6px);
        }

        .toast-enter-end {
            opacity: 1;
            transform: translateY(0);
        }

        .toast-leave {
            transition: opacity 150ms ease;
        }

        /* ── SETTINGS LAYOUT ── */
        .settings-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 32px;
            margin-bottom: 40px;
        }

        @media (max-width: 968px) {
            .settings-layout {
                grid-template-columns: 240px 1fr;
                gap: 24px;
            }
        }

        @media (max-width: 768px) {
            .settings-layout {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        /* ── SIDEBAR ── */
        .settings-sidebar {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .settings-nav {
            display: flex;
            flex-direction: column;
            gap: 0;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: none;
            background: none;
            color: var(--text-secondary);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-align: left;
            transition: all 150ms ease;
            border-left: 3px solid transparent;
        }

        .nav-item:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        .nav-item.active {
            background: rgba(217, 119, 6, 0.05);
            color: var(--accent);
            border-left-color: var(--accent);
        }

        .nav-item.danger {
            color: #DC2626;
        }

        .nav-item.danger:hover {
            background: #FEE2E2;
        }

        .nav-item.danger.active {
            background: #FEE2E2;
            border-left-color: #DC2626;
        }

        .nav-divider {
            height: 1px;
            background: var(--border-soft);
        }

        /* ── CONTENT AREA ── */
        .settings-content {
            min-height: 400px;
        }

        .content-header {
            margin-bottom: 28px;
        }

        .content-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .content-sub {
            font-size: 13px;
            color: var(--text-secondary);
        }

        /* ── SECTION HEADER ── */
        .section-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-soft);
        }

        .section-header-icon {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #F3F0EA;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }

        .section-header-icon-blue {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .section-header-icon-red {
            background: #FEE2E2;
            color: #DC2626;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .section-sub {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* ── INFO CARD ── */
        .info-card {
            display: flex;
            gap: 16px;
            padding: 16px;
            background: #F0FDF4;
            border: 1px solid #BBF7D0;
            border-radius: 10px;
        }

        .info-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #15803D;
        }

        .info-title {
            font-size: 13px;
            font-weight: 700;
            color: #15803D;
            margin-bottom: 6px;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-list li {
            font-size: 12px;
            color: #15803D;
            line-height: 1.5;
        }

        /* ── DANGER CARD ── */
        .card-danger {
            border: 1px solid #FCA5A5;
            background: #FFFBFB;
        }

        /* ── FORM STYLES ── */
        .form-section {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .field-required {
            color: #DC2626;
        }

        .field-input {
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-family: inherit;
            background: var(--bg-base);
            color: var(--text-primary);
            transition: all 150ms ease;
        }

        .field-input:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--bg-surface);
            box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.1);
        }

        .field-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .field-error {
            font-size: 11px;
            color: #DC2626;
            margin-top: 4px;
        }

        /* ── BUTTONS ── */
        .button-group {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-top: 20px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: var(--accent);
            color: white;
            cursor: pointer;
            transition: all 150ms ease;
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-ghost-sm {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 150ms ease;
        }

        .btn-ghost-sm:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: #DC2626;
            color: white;
            cursor: pointer;
            transition: all 150ms ease;
        }

        .btn-danger:hover {
            background: #B91C1C;
        }

        .btn-danger-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border: 1px solid #DC2626;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            background: transparent;
            color: #DC2626;
            cursor: pointer;
            transition: all 150ms ease;
        }

        .btn-danger-outline:hover {
            background: #FEE2E2;
        }

        /* ── MODAL ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 60;
            background: rgba(26, 25, 22, 0.45);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .t-fade {
            transition: opacity 200ms ease;
        }

        .opacity-0 {
            opacity: 0;
        }

        .opacity-100 {
            opacity: 1;
        }

        .t-pop {
            transition: transform 200ms cubic-bezier(0.4, 0, 0.2, 1), opacity 200ms ease;
        }

        .pop-out {
            transform: scale(0.92) translateY(8px);
            opacity: 0;
        }

        .pop-in {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .fade-enter {
            transition: opacity 200ms ease;
        }

        .modal-box {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 24px 64px rgba(26, 25, 22, 0.18),
                0 4px 12px rgba(26, 25, 22, 0.08);
            overflow: hidden;
        }

        .modal-box-sm {
            max-width: 420px;
        }

        .delete-body {
            padding: 32px 24px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .delete-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #FEE2E2;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DC2626;
            margin-bottom: 4px;
        }

        .delete-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .delete-sub {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        .delete-warn {
            font-size: 12px;
            color: #DC2626;
            font-weight: 600;
        }

        .delete-footer {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        @media (max-width: 640px) {
            .page-header {
                flex-direction: column;
            }

            .settings-layout {
                grid-template-columns: 1fr;
            }

            .settings-sidebar {
                position: static;
            }

            .settings-nav {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                border-radius: 8px;
            }

            .nav-item {
                padding: 10px;
                text-align: center;
                border-left: none;
                border-bottom: 3px solid transparent;
            }

            .nav-item.active {
                border-bottom-color: var(--accent);
                border-left: none;
            }

            .nav-divider {
                display: none;
            }
        }
    </style>
</x-app-layout>
stroke-width="2">
<path stroke-linecap="round" stroke-linejoin="round"
    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
</svg>
</div>
<div>
    <h2 class="section-title">Hapus Akun</h2>
    <p class="section-sub">Akun Anda akan dihapus secara permanen bersama semua data terkait.</p>
</div>
</div>

@include('profile.partials.delete-user-form')
</div>

{{-- MODAL — DELETE ACCOUNT CONFIRM --}}
<div x-show="showDelete" class="modal-backdrop" @click.self="showDelete = false" style="display:none;"
    x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="modal-box modal-box-sm" x-transition:enter="t-pop" x-transition:enter-start="pop-out"
        x-transition:enter-end="pop-in" x-transition:leave="t-pop" x-transition:leave-start="pop-in"
        x-transition:leave-end="pop-out">

        <div class="delete-body">
            <div class="delete-icon">
                <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="delete-title">Hapus Akun Anda?</h3>
            <p class="delete-sub">
                Tindakan ini akan menghapus akun Anda dan semua data terkait secara permanen. Masukkan password
                Anda untuk mengkonfirmasi.
            </p>
            <p class="delete-warn">Tindakan ini tidak dapat dibatalkan.</p>
        </div>

        <form method="post" action="{{ route('profile.destroy') }}" class="delete-footer">
            @csrf
            @method('delete')

            <div style="padding: 0 20px; margin-bottom: 20px; width: 100%;">
                <label class="field-label">Password <span class="field-required">*</span></label>
                <input type="password" name="password" class="field-input" placeholder="Masukkan password Anda"
                    required autofocus>
                @if ($errors->userDeletion->has('password'))
                    <p style="font-size: 11px; color: #DC2626; margin-top: 6px;">
                        @foreach ($errors->userDeletion->get('password') as $error)
                            {{ $error }}
                        @endforeach
                    </p>
                @endif
            </div>

            <div style="display:flex; gap:12px; padding:16px 20px; border-top:1px solid var(--border-soft);">
                <button type="button" @click="showDelete = false" class="btn-ghost-sm"
                    style="flex:1; justify-content:center;">
                    Batal
                </button>
                <button type="submit" class="btn-danger" style="flex:1;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
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
    /* ── PAGE HEADER ── */
    .page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 24px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-primary);
        letter-spacing: -0.02em;
    }

    .page-sub {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* ── TOASTS ── */
    .toast {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px 16px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 16px;
    }

    .toast-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #15803D;
    }

    .toast-enter {
        transition: opacity 200ms ease, transform 200ms ease;
    }

    .toast-enter-start {
        opacity: 0;
        transform: translateY(-6px);
    }

    .toast-enter-end {
        opacity: 1;
        transform: translateY(0);
    }

    .toast-leave {
        transition: opacity 150ms ease;
    }

    /* ── SECTION HEADER ── */
    .section-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-soft);
    }

    .section-header-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #F3F0EA;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
    }

    .section-header-icon-blue {
        background: #DBEAFE;
        color: #1E40AF;
    }

    .section-header-icon-red {
        background: #FEE2E2;
        color: #DC2626;
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .section-sub {
        font-size: 12px;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* ── FORM STYLES ── */
    .form-section {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .field-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-primary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .field-required {
        color: #DC2626;
    }

    .field-input {
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        background: var(--bg-base);
        color: var(--text-primary);
        transition: all 150ms ease;
    }

    .field-input:focus {
        outline: none;
        border-color: var(--accent);
        background: var(--bg-surface);
        box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.1);
    }

    .field-hint {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .field-error {
        font-size: 11px;
        color: #DC2626;
        margin-top: 4px;
    }

    /* ── BUTTONS ── */
    .button-group {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 20px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        background: var(--accent);
        color: white;
        cursor: pointer;
        transition: all 150ms ease;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
        transform: translateY(-1px);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-ghost-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        background: transparent;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 150ms ease;
    }

    .btn-ghost-sm:hover {
        background: var(--bg-base);
        color: var(--text-primary);
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        background: #DC2626;
        color: white;
        cursor: pointer;
        transition: all 150ms ease;
    }

    .btn-danger:hover {
        background: #B91C1C;
    }

    .btn-danger-outline {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        border: 1px solid #DC2626;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        background: transparent;
        color: #DC2626;
        cursor: pointer;
        transition: all 150ms ease;
    }

    .btn-danger-outline:hover {
        background: #FEE2E2;
    }

    .status-message {
        font-size: 12px;
        font-weight: 600;
        color: #15803D;
    }

    /* ── MODAL ── */
    .modal-backdrop {
        position: fixed;
        inset: 0;
        z-index: 60;
        background: rgba(26, 25, 22, 0.45);
        backdrop-filter: blur(3px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .t-fade {
        transition: opacity 200ms ease;
    }

    .opacity-0 {
        opacity: 0;
    }

    .opacity-100 {
        opacity: 1;
    }

    .t-pop {
        transition: transform 200ms cubic-bezier(0.4, 0, 0.2, 1),
            opacity 200ms ease;
    }

    .pop-out {
        transform: scale(0.92) translateY(8px);
        opacity: 0;
    }

    .pop-in {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .modal-box {
        background: var(--bg-surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 24px 64px rgba(26, 25, 22, 0.18),
            0 4px 12px rgba(26, 25, 22, 0.08);
        overflow: hidden;
    }

    .modal-box-sm {
        max-width: 420px;
    }

    .delete-body {
        padding: 32px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .delete-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #FEE2E2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #DC2626;
        margin-bottom: 4px;
    }

    .delete-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .delete-sub {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .delete-warn {
        font-size: 12px;
        color: #DC2626;
        font-weight: 600;
    }

    .delete-footer {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    @media (max-width: 640px) {
        .page-header {
            flex-direction: column;
        }

        .section-header {
            flex-direction: column;
        }
    }
</style>
</x-app-layout>
