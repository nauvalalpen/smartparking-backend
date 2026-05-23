<x-app-layout>
    <x-slot name="header">Tambah Petugas Keamanan</x-slot>

    <div class="form-page">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('pengguna.index') }}" class="bc-link">Petugas Keamanan</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">Tambah Petugas</span>
        </div>

        <div class="form-layout">

            {{-- Main form card --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Data Petugas Baru</h2>
                        <p class="form-card-sub">Isi informasi lengkap akun petugas keamanan yang akan didaftarkan.</p>
                    </div>
                </div>

                {{-- Form content wrapper with scroll --}}
                <div class="form-content-wrapper">
                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="error-box">
                            <div class="error-box-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <p class="error-box-title">Mohon perbaiki kesalahan berikut:</p>
                                @foreach ($errors->all() as $error)
                                    <p class="error-box-item">• {{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('pengguna.store') }}" method="POST" class="sp-form">
                        @csrf

                        <div class="field-group">
                            <label class="field-label">Nama Lengkap <span class="field-required">*</span></label>
                            <input type="text" name="nama_lengkap" class="field-input"
                                value="{{ old('nama_lengkap') }}" placeholder="Contoh: Budi Santoso" required>
                            <p class="field-hint">Gunakan nama lengkap sesuai identitas resmi petugas.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Email <span class="field-required">*</span></label>
                            <input type="email" name="email" class="field-input field-mono"
                                value="{{ old('email') }}" placeholder="budi@security.pnp.ac.id" required>
                            <p class="field-hint">Email akan digunakan sebagai username untuk login.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Kata Sandi Sementara <span
                                    class="field-required">*</span></label>
                            <input type="password" name="password" class="field-input" placeholder="Minimal 6 karakter"
                                required>
                            <p class="field-hint">Petugas dapat mengganti kata sandi setelah login pertama kali.</p>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('pengguna.index') }}" class="btn-ghost-sm">Batal</a>
                            <button type="submit" class="btn-primary">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Akun
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info sidebar --}}
            <div class="form-aside">
                <div class="aside-card">
                    <p class="aside-title">Panduan Pengisian</p>
                    <ul class="aside-list">
                        <li>Nama lengkap harus sesuai dengan identitas resmi petugas.</li>
                        <li>Email unik akan menjadi username login pada sistem.</li>
                        <li>Kata sandi sementara akan diberikan kepada petugas saat registrasi.</li>
                        <li>Petugas dapat mengubah kata sandi melalui profil setelah login.</li>
                    </ul>
                </div>
                <div class="aside-card aside-card-amber">
                    <p class="aside-title">Catatan Penting</p>
                    <p class="aside-desc">Pastikan email yang digunakan valid dan dapat diakses oleh petugas untuk
                        menerima notifikasi sistem.</p>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.form-styles')

    <style>
        .form-content-wrapper {
            max-height: calc(100vh - 320px);
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 4px;
        }

        .form-content-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .form-content-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .form-content-wrapper::-webkit-scrollbar-thumb {
            background: #D9D6D0;
            border-radius: 3px;
        }

        .form-content-wrapper::-webkit-scrollbar-thumb:hover {
            background: #C9C6C0;
        }

        @media (max-width: 720px) {
            .form-content-wrapper {
                max-height: calc(100vh - 280px);
            }
        }

        .aside-desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 4px;
        }
    </style>
</x-app-layout>
