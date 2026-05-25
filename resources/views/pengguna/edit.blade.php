<x-app-layout>
    <x-slot name="header">Edit Data Petugas</x-slot>

    <div class="form-page">
        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('pengguna.index') }}" class="bc-link">Petugas Keamanan</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">Edit Petugas</span>
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
                        <h2 class="form-card-title">Edit Data Petugas</h2>
                        <p class="form-card-sub">Perbarui informasi dan akses petugas keamanan.</p>
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

                    <form action="{{ route('pengguna.update', $pengguna->id_pengguna) }}" method="POST"
                        class="sp-form">
                        @csrf
                        @method('PUT')

                        <div class="field-group">
                            <label class="field-label">Nama Lengkap <span class="field-required">*</span></label>
                            <input type="text" name="nama_lengkap" class="field-input"
                                value="{{ $pengguna->nama_lengkap }}" required>
                            <p class="field-hint">Nama lengkap sesuai identitas resmi.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Email <span class="field-required">*</span></label>
                            <input type="email" name="email" class="field-input field-mono"
                                value="{{ $pengguna->email }}" required>
                            <p class="field-hint">Email digunakan sebagai username login.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Kata Sandi Baru</label>
                            <input type="password" name="password" class="field-input"
                                placeholder="Kosongkan jika tidak ingin mengubah">
                            <p class="field-hint">Biarkan kosong untuk tidak mengubah kata sandi saat ini.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Hak Akses</label>
                            <input type="text" name="role" value="Petugas Keamanan" class="field-input" disabled
                                style="background: var(--bg-base); color: var(--text-muted);">
                            <p class="field-hint">Hak akses tidak dapat diubah (tetap sebagai Petugas Keamanan).</p>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('pengguna.index') }}" class="btn-ghost-sm">Batal</a>
                            <button type="submit" class="btn-primary">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Petugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info sidebar --}}
            <div class="form-aside">
                <div class="aside-card">
                    <p class="aside-title">Informasi Petugas</p>
                    <div class="aside-meta">
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">ID Petugas</span>
                            <span class="aside-meta-val">{{ $pengguna->id_pengguna }}</span>
                        </div>
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Status Akun</span>
                            <span class="aside-meta-val" style="color: #15803D;">Aktif</span>
                        </div>
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Hak Akses</span>
                            <span class="aside-meta-val">Petugas Keamanan</span>
                        </div>
                    </div>
                </div>
                <div class="aside-card aside-card-amber">
                    <p class="aside-title">Catatan Penting</p>
                    <p class="aside-desc">Perubahan email akan mempengaruhi username login petugas di sistem.</p>
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

        .aside-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .aside-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .aside-meta-key {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        .aside-meta-val {
            font-size: 12px;
            color: var(--text-primary);
            font-weight: 500;
        }

        .aside-desc {
            font-size: 12.5px;
            color: var(--text-secondary);
            line-height: 1.6;
        }

        @media (max-width: 720px) {
            .form-content-wrapper {
                max-height: calc(100vh - 280px);
            }
        }
    </style>
</x-app-layout>
