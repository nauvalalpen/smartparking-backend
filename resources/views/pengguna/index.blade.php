<x-app-layout>
    <x-slot name="header">Manajemen Petugas Keamanan</x-slot>

    {{-- Alpine root — owns ALL modal state --}}
    <div x-data="{
        /* ── CREATE ── */
        showCreate: false,
    
        /* ── EDIT ── */
        showEdit: false,
        edit: { id: null, nama_lengkap: '', email: '', role: 'petugas' },
        openEdit(user) {
            this.edit = { ...user };
            this.showEdit = true;
        },
    
        /* ── DELETE ── */
        showDelete: false,
        del: { id: null, nama: '' },
        openDelete(id, nama) {
            this.del = { id, nama };
            this.showDelete = true;
        },
    
        /* close all */
        closeAll() {
            this.showCreate = false;
            this.showEdit = false;
            this.showDelete = false;
        }
    }" @keydown.escape.window="closeAll()">

        {{-- ══════════════════════════════════════════
         PAGE HEADER
    ══════════════════════════════════════════ --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Petugas Keamanan</h1>
                <p class="page-sub">Kelola akun petugas dan hak akses sistem parkir.</p>
            </div>
            <button @click="showCreate = true" class="btn-primary">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Petugas
            </button>
        </div>

        {{-- ══════════════════════════════════════════
         FLASH TOASTS
    ══════════════════════════════════════════ --}}
        @if (session('success'))
            <div class="toast toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="toast-enter" x-transition:leave="toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="toast toast-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="toast-enter" x-transition:leave="toast-leave">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Validation error (from failed create/edit) --}}
        @if ($errors->any())
            <div class="toast toast-error" x-data="{ show: true }" x-show="show" x-init="@if (old('_form') === 'edit') showEdit = true; edit.id = '{{ old('_id') }}'; edit.nama_lengkap = '{{ old('nama_lengkap') }}'; edit.email = '{{ old('email') }}'; edit.role = '{{ old('role') }}';
                @else showCreate = true; @endif">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>
                    @foreach ($errors->all() as $e)
                        {{ $e }}{{ !$loop->last ? ' · ' : '' }}
                    @endforeach
                </span>
            </div>
        @endif

        {{-- ══════════════════════════════════════════
         TABLE CARD
    ══════════════════════════════════════════ --}}
        <div class="card">
            @if ($penggunas->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM16 20H4v-2a8 8 0 0116 0z" />
                        </svg>
                    </div>
                    <p class="empty-title">Belum ada petugas</p>
                    <p class="empty-sub">Tambahkan akun petugas keamanan pertama Anda untuk memulai.</p>
                    <button @click="showCreate = true" class="btn-primary" style="margin-top:18px;">
                        + Tambah Petugas
                    </button>
                </div>
            @else
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:44px;">#</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th style="width:100px; text-align:center;">Hak Akses</th>
                                <th style="width:100px; text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggunas as $index => $user)
                                <tr>
                                    <td class="cell-num">{{ $index + 1 }}</td>
                                    <td class="cell-bold">{{ $user->nama_lengkap }}</td>
                                    <td class="cell-mono">{{ $user->email }}</td>
                                    <td style="text-align:center;">
                                        @if ($user->role === 'admin')
                                            <span class="badge-blue">Admin</span>
                                        @elseif ($user->role === 'petugas')
                                            <span class="badge-green">Petugas</span>
                                        @else
                                            <span class="badge-gray">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-row">
                                            <button
                                                @click="openEdit({
                                                    id:              '{{ $user->id_pengguna }}',
                                                    nama_lengkap:    @js($user->nama_lengkap),
                                                    email:           @js($user->email),
                                                    role:            '{{ $user->role }}'
                                                })"
                                                class="btn-icon btn-icon-blue" title="Edit Petugas">
                                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button
                                                @click="openDelete('{{ $user->id_pengguna }}', @js($user->nama_lengkap))"
                                                class="btn-icon btn-icon-red" title="Hapus Petugas">
                                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mini summary bar --}}
                <div class="table-footer">
                    <span class="table-footer-text">
                        {{ $penggunas->count() }} petugas terdaftar
                        · Admin: <strong>{{ $penggunas->where('role', 'admin')->count() }}</strong>
                        · Petugas: <strong>{{ $penggunas->where('role', 'petugas')->count() }}</strong>
                    </span>
                </div>
            @endif
        </div>


        {{-- ══════════════════════════════════════════
         MODAL — CREATE
    ══════════════════════════════════════════ --}}
        <div x-show="showCreate" class="modal-backdrop" @click.self="showCreate = false" style="display:none;"
            x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="modal-box" x-transition:enter="t-pop" x-transition:enter-start="pop-out"
                x-transition:enter-end="pop-in" x-transition:leave="t-pop" x-transition:leave-start="pop-in"
                x-transition:leave-end="pop-out">

                {{-- Header --}}
                <div class="modal-header">
                    <div class="modal-header-left">
                        <div class="modal-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="modal-title">Tambah Petugas Keamanan</h3>
                            <p class="modal-sub">Buat akun petugas baru dan atur hak aksesnya.</p>
                        </div>
                    </div>
                    <button @click="showCreate = false" class="modal-close">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <form action="{{ route('pengguna.store') }}" method="POST" class="modal-form">
                    @csrf
                    <input type="hidden" name="_form" value="create">

                    <div class="field-row-2">
                        <div class="field-group">
                            <label class="field-label">Nama Lengkap <span class="field-required">*</span></label>
                            <input type="text" name="nama_lengkap" class="field-input"
                                value="{{ old('nama_lengkap') }}" placeholder="Contoh: Budi Santoso" required
                                autofocus>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Hak Akses <span class="field-required">*</span></label>
                            <select name="role" class="field-input" required>
                                <option value="">— Pilih akses —</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="petugas"
                                    {{ old('role', 'petugas') === 'petugas' ? 'selected' : '' }}>
                                    Petugas</option>
                            </select>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email <span class="field-required">*</span></label>
                        <input type="email" name="email" class="field-input field-mono"
                            value="{{ old('email') }}" placeholder="petugas@smartparking.id" required>
                        <p class="field-hint">Gunakan email yang aktif dan mudah diakses.</p>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Password <span class="field-required">*</span></label>
                        <input type="password" name="password" class="field-input" placeholder="Minimal 8 karakter"
                            required>
                        <p class="field-hint">Password harus sekurang-kurangnya 8 karakter.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="showCreate = false" class="btn-ghost-sm">Batal</button>
                        <button type="submit" class="btn-primary">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Buat Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════
         MODAL — EDIT
    ══════════════════════════════════════════ --}}
        <div x-show="showEdit" class="modal-backdrop" @click.self="showEdit = false" style="display:none;"
            x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="modal-box" x-transition:enter="t-pop" x-transition:enter-start="pop-out"
                x-transition:enter-end="pop-in" x-transition:leave="t-pop" x-transition:leave-start="pop-in"
                x-transition:leave-end="pop-out">

                {{-- Header --}}
                <div class="modal-header">
                    <div class="modal-header-left">
                        <div class="modal-icon modal-icon-blue">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="modal-title">Edit Petugas Keamanan</h3>
                            <p class="modal-sub" x-text="'Mengubah: ' + edit.nama_lengkap"></p>
                        </div>
                    </div>
                    <button @click="showEdit = false" class="modal-close">
                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body —action built dynamically --}}
                <form :action="'{{ url('pengguna') }}/' + edit.id" method="POST" class="modal-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">
                    <input type="hidden" name="_id" :value="edit.id">

                    <div class="field-row-2">
                        <div class="field-group">
                            <label class="field-label">Nama Lengkap <span class="field-required">*</span></label>
                            <input type="text" name="nama_lengkap" class="field-input"
                                x-model="edit.nama_lengkap" required>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Hak Akses <span class="field-required">*</span></label>
                            <select name="role" class="field-input" x-model="edit.role" required>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                            </select>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email <span class="field-required">*</span></label>
                        <input type="email" name="email" class="field-input field-mono" x-model="edit.email"
                            required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="showEdit = false" class="btn-ghost-sm">Batal</button>
                        <button type="submit" class="btn-primary">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════
         MODAL — DELETE CONFIRM
    ══════════════════════════════════════════ --}}
        <div x-show="showDelete" class="modal-backdrop" @click.self="showDelete = false" style="display:none;"
            x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="modal-box modal-box-sm" x-transition:enter="t-pop" x-transition:enter-start="pop-out"
                x-transition:enter-end="pop-in" x-transition:leave="t-pop" x-transition:leave-start="pop-in"
                x-transition:leave-end="pop-out">

                {{-- Danger icon + copy --}}
                <div class="delete-body">
                    <div class="delete-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="delete-title">Hapus Akun Petugas?</h3>
                    <p class="delete-sub">
                        Petugas <strong x-text="del.nama"></strong> akan dihapus secara permanen beserta semua akses
                        dan riwayat aktivitasnya.
                    </p>
                    <p class="delete-warn">Tindakan ini tidak dapat dibatalkan.</p>
                </div>

                <form :action="'{{ url('pengguna') }}/' + del.id" method="POST" class="delete-footer">
                    @csrf
                    @method('DELETE')
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
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>

    </div>{{-- end x-data --}}

    {{-- ══════════════════════════════════════════
     STYLES
══════════════════════════════════════════ --}}
    @include('layouts.table-styles')

    <style>
        /* ── Page header ── */
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

        /* ── Toasts ── */
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

        .toast-error {
            background: #FEF2F2;
            border: 1px solid #FECDD3;
            color: #BE123C;
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

        /* ── Badges ── */
        .badge-blue {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #1E40AF;
            background: #DBEAFE;
            padding: 3px 9px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .badge-green {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #15803D;
            background: #DCFCE7;
            padding: 3px 9px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .badge-gray {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--bg-base);
            padding: 3px 9px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .table-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border-soft);
            background: var(--bg-base);
        }

        .table-footer-text {
            font-size: 12px;
            color: var(--text-muted);
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
            max-width: 380px;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 20px;
            border-bottom: 1px solid var(--border-soft);
            gap: 12px;
        }

        .modal-header-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            flex: 1;
            min-width: 0;
        }

        .modal-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #F3F0EA;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }

        .modal-icon-blue {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .modal-sub {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .modal-close {
            flex-shrink: 0;
            background: none;
            border: none;
            padding: 4px;
            cursor: pointer;
            color: var(--text-muted);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 150ms ease;
        }

        .modal-close:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        .modal-form {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 480px) {
            .field-row-2 {
                grid-template-columns: 1fr;
            }
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

        .field-input.field-mono {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
        }

        .field-hint {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .modal-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border-soft);
            display: flex;
            gap: 12px;
            justify-content: flex-end;
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

        /* ── Delete modal ── */
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
            padding: 16px 20px;
            border-top: 1px solid var(--border-soft);
            display: flex;
            gap: 12px;
        }
    </style>
</x-app-layout>
