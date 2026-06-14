<x-app-layout>
    <x-slot name="header">Area Parkiran</x-slot>

    {{-- ─────────────────────────────────────────────
         Alpine root — owns ALL modal state
    ───────────────────────────────────────────── --}}
    <div x-data="{
        /* ── CREATE ── */
        showCreate: false,
    
        /* ── EDIT ── */
        showEdit: false,
        edit: { id: null, nama_area: '', deskripsi: '', kapasitas_total: '' },
        openEdit(area) {
            this.edit = { ...area };
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
                <h1 class="page-title">Area Parkiran</h1>
                <p class="page-sub">Kelola semua area parkiran dan kapasitas slotnya.</p>
            </div>
            <button @click="showCreate = true" class="btn-primary">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Area
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
            <div class="toast toast-error" x-data="{ show: true }" x-show="show" x-init="@if (old('_form') === 'edit') showEdit = true; edit.id = '{{ old('_id') }}'; edit.nama_area = '{{ old('nama_area') }}'; edit.deskripsi = '{{ old('deskripsi') }}'; edit.kapasitas_total = '{{ old('kapasitas_total') }}';
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
            @if ($areas->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.5m0 0H9m0 0h-2m9.5 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871m-6.258 0H9v-3.375c0-.621.504-1.125 1.125-1.125h.872M9 21h6" />
                        </svg>
                    </div>
                    <p class="empty-title">Belum ada area parkiran</p>
                    <p class="empty-sub">Tambahkan area parkiran pertama Anda untuk memulai sistem.</p>
                    <button @click="showCreate = true" class="btn-primary" style="margin-top:18px;">
                        + Tambah Area Pertama
                    </button>
                </div>
            @else
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="width:44px;">#</th>
                                <th>Nama Area</th>
                                <th>Deskripsi</th>
                                <th style="width:100px; text-align:center;">Kapasitas</th>
                                <th style="width:100px; text-align:center;">Terpakai</th>
                                <th style="width:100px; text-align:center;">Tersedia</th>
                                <th style="width:100px; text-align:right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($areas as $i => $area)
                                <tr>
                                    <td class="cell-num">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="area-name-cell">
                                            <div class="area-dot"></div>
                                            <span class="cell-bold">{{ $area->nama_area }}</span>
                                        </div>
                                    </td>
                                    <td class="cell-muted">{{ $area->deskripsi ?? '—' }}</td>
                                    <td style="text-align:center;">
                                        <span class="cap-total">{{ $area->kapasitas_total }}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="cap-badge cap-used">{{ $area->filled_slots ?? 0 }}</span>
                                    </td>
                                    <td style="text-align:center;">
                                        <span class="cap-badge cap-free">{{ $area->available_slots ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="action-row">
                                            {{-- Edit --}}
                                            <button
                                                @click="openEdit({
                                            id:              '{{ $area->id_area }}',
                                            nama_area:       @js($area->nama_area),
                                            deskripsi:       @js($area->deskripsi ?? ''),
                                            kapasitas_total: '{{ $area->kapasitas_total }}'
                                        })"
                                                class="btn-icon btn-icon-blue" title="Edit">
                                                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <button
                                                @click="openDelete('{{ $area->id_area }}', @js($area->nama_area))"
                                                class="btn-icon btn-icon-red" title="Hapus">
                                                <svg width="13" height="13" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                        {{ $areas->count() }} area terdaftar
                        · Total kapasitas: <strong>{{ $areas->sum('kapasitas_total') }}</strong> slot
                        · Tersedia: <strong>{{ $areas->sum('available_slots') }}</strong> slot
                    </span>
                </div>
            @endif
        </div>


        {{-- ══════════════════════════════════════════
         MODAL — CREATE
    ══════════════════════════════════════════ --}}
        <div x-show="showCreate" class="modal-backdrop" x-transition:enter="backdrop-enter"
            x-transition:enter-start="backdrop-enter-start" x-transition:enter-end="backdrop-enter-end"
            x-transition:leave="backdrop-enter" x-transition:leave-start="backdrop-enter-end"
            x-transition:leave-end="backdrop-enter-start" @click.self="showCreate = false" style="display:none;">

            <div class="modal-box" x-transition:enter="modal-enter" x-transition:enter-start="modal-enter-start"
                x-transition:enter-end="modal-enter-end" x-transition:leave="modal-enter"
                x-transition:leave-start="modal-enter-end" x-transition:leave-end="modal-enter-start">

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
                            <h3 class="modal-title">Tambah Area Parkiran</h3>
                            <p class="modal-sub">Buat area baru dan tentukan kapasitasnya.</p>
                        </div>
                    </div>
                    <button @click="showCreate = false" class="modal-close">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <form action="{{ route('area.store') }}" method="POST" class="modal-form">
                    @csrf
                    <input type="hidden" name="_form" value="create">

                    <div class="field-group">
                        <label class="field-label">Nama Area <span class="field-required">*</span></label>
                        <input type="text" name="nama_area" class="field-input" value="{{ old('nama_area') }}"
                            placeholder="Contoh: Area Parkiran Utama" required autofocus>
                        <p class="field-hint">Gunakan nama yang unik dan mudah dikenali.</p>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="deskripsi" class="field-input" rows="2" placeholder="Contoh: Parkiran di lantai 1 gedung A">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Kapasitas Total Slot <span class="field-required">*</span></label>
                        <input type="number" name="kapasitas_total" class="field-input"
                            value="{{ old('kapasitas_total') }}" placeholder="Contoh: 50" min="1" required>
                        <p class="field-hint">Jumlah total slot parkir fisik yang tersedia.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="showCreate = false" class="btn-ghost-sm">Batal</button>
                        <button type="submit" class="btn-primary">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Area
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- ══════════════════════════════════════════
         MODAL — EDIT
    ══════════════════════════════════════════ --}}
        <div x-show="showEdit" class="modal-backdrop" x-transition:enter="backdrop-enter"
            x-transition:enter-start="backdrop-enter-start" x-transition:enter-end="backdrop-enter-end"
            x-transition:leave="backdrop-enter" x-transition:leave-start="backdrop-enter-end"
            x-transition:leave-end="backdrop-enter-start" @click.self="showEdit = false" style="display:none;">

            <div class="modal-box" x-transition:enter="modal-enter" x-transition:enter-start="modal-enter-start"
                x-transition:enter-end="modal-enter-end" x-transition:leave="modal-enter"
                x-transition:leave-start="modal-enter-end" x-transition:leave-end="modal-enter-start">

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
                            <h3 class="modal-title">Edit Area Parkiran</h3>
                            <p class="modal-sub" x-text="'Mengubah: ' + edit.nama_area"></p>
                        </div>
                    </div>
                    <button @click="showEdit = false" class="modal-close">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Body — action built dynamically --}}
                <form :action="'{{ url('area') }}/' + edit.id" method="POST" class="modal-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">
                    <input type="hidden" name="_id" :value="edit.id">

                    <div class="field-group">
                        <label class="field-label">Nama Area <span class="field-required">*</span></label>
                        <input type="text" name="nama_area" class="field-input" x-model="edit.nama_area"
                            required>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="deskripsi" class="field-input" rows="2" x-model="edit.deskripsi"></textarea>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Kapasitas Total Slot <span class="field-required">*</span></label>
                        <input type="number" name="kapasitas_total" class="field-input"
                            x-model="edit.kapasitas_total" min="1" required>
                        <p class="field-hint">Mengubah kapasitas tidak mempengaruhi data slot yang sudah terdaftar.</p>
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
        <div x-show="showDelete" class="modal-backdrop" x-transition:enter="backdrop-enter"
            x-transition:enter-start="backdrop-enter-start" x-transition:enter-end="backdrop-enter-end"
            x-transition:leave="backdrop-enter" x-transition:leave-start="backdrop-enter-end"
            x-transition:leave-end="backdrop-enter-start" @click.self="showDelete = false" style="display:none;">

            <div class="modal-box modal-box-sm" x-transition:enter="modal-enter"
                x-transition:enter-start="modal-enter-start" x-transition:enter-end="modal-enter-end"
                x-transition:leave="modal-enter" x-transition:leave-start="modal-enter-end"
                x-transition:leave-end="modal-enter-start">

                {{-- Danger icon + copy --}}
                <div class="delete-body">
                    <div class="delete-icon">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="delete-title">Hapus Area Parkiran?</h3>
                    <p class="delete-sub">
                        Area <strong x-text="del.nama"></strong> akan dihapus secara permanen beserta semua data kamera
                        dan slot yang terkait.
                    </p>
                    <p class="delete-warn">Tindakan ini tidak dapat dibatalkan.</p>
                </div>

                <form :action="'{{ url('area') }}/' + del.id" method="POST" class="delete-footer">
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

        /* ── Area name cell ── */
        .area-name-cell {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .area-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
        }

        /* ── Capacity badges ── */
        .cap-total {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .cap-badge {
            display: inline-flex;
            align-items: center;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .cap-used {
            color: #B91C1C;
            background: #FEE2E2;
        }

        .cap-free {
            color: #15803D;
            background: #DCFCE7;
        }

        /* ── Table footer ── */
        .table-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border-soft);
            background: var(--bg-base);
        }

        .table-footer-text {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ── MODAL BACKDROP ── */
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

        .backdrop-enter {
            transition: opacity 200ms ease;
        }

        .backdrop-enter-start {
            opacity: 0;
        }

        .backdrop-enter-end {
            opacity: 1;
        }

        /* ── MODAL BOX ── */
        .modal-box {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 24px 64px rgba(26, 25, 22, 0.18), 0 4px 12px rgba(26, 25, 22, 0.08);
            overflow: hidden;
        }

        .modal-box-sm {
            max-width: 380px;
        }

        .modal-enter {
            transition: opacity 200ms ease, transform 200ms cubic-bezier(0.34, 1.2, 0.64, 1);
        }

        .modal-enter-start {
            opacity: 0;
            transform: scale(0.95) translateY(8px);
        }

        .modal-enter-end {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* ── MODAL HEADER ── */
        .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 20px 22px 16px;
            border-bottom: 1px solid var(--border-soft);
        }

        .modal-header-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .modal-icon {
            width: 36px;
            height: 36px;
            border-radius: 9px;
            background: #FEF3C7;
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .modal-icon-blue {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .modal-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .modal-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .modal-close {
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            flex-shrink: 0;
            transition: all var(--transition);
        }

        .modal-close:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        /* ── MODAL FORM ── */
        .modal-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 20px 22px 0;
        }

        /* ── MODAL FOOTER ── */
        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            padding: 18px 22px;
            border-top: 1px solid var(--border-soft);
            background: var(--bg-base);
            margin-top: 4px;
        }

        /* ── DELETE MODAL ── */
        .delete-body {
            padding: 28px 28px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .delete-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #FEF2F2;
            color: #DC2626;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .delete-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 10px;
        }

        .delete-sub {
            font-size: 13.5px;
            color: var(--text-secondary);
            line-height: 1.65;
            max-width: 280px;
        }

        .delete-warn {
            margin-top: 10px;
            font-size: 11.5px;
            font-weight: 600;
            color: #DC2626;
            background: #FEF2F2;
            padding: 5px 12px;
            border-radius: 99px;
            border: 1px solid #FECACA;
        }

        .delete-footer {
            display: flex;
            gap: 8px;
            padding: 16px 22px;
            border-top: 1px solid var(--border-soft);
            background: var(--bg-base);
        }

        /* ── Shared field styles ── */
        :root {
            --bg-base: #F7F6F3;
            --bg-surface: #FFFFFF;
            --border: #E8E6E1;
            --border-soft: #F0EDE8;
            --text-primary: #1A1916;
            --text-secondary: #6B6860;
            --text-muted: #A09D97;
            --accent: #D97706;
            --accent-hover: #B45309;
            --font-mono: 'DM Mono', monospace;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .field-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.02em;
        }

        .field-required {
            color: var(--accent);
        }

        .field-input,
        .field-select {
            width: 100%;
            padding: 9px 12px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .field-input:focus,
        .field-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        .field-input::placeholder {
            color: var(--text-muted);
        }

        .field-hint {
            font-size: 11.5px;
            color: var(--text-muted);
        }

        /* ── Buttons ── */
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--accent);
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: background var(--transition);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
        }

        .btn-ghost-sm {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            background: transparent;
            border: 1px solid var(--border);
            text-decoration: none;
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-ghost-sm:hover {
            background: var(--bg-base);
            color: var(--text-primary);
        }

        .btn-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: #DC2626;
            border: none;
            cursor: pointer;
            transition: background var(--transition);
        }

        .btn-danger:hover {
            background: #B91C1C;
        }
    </style>

</x-app-layout>
