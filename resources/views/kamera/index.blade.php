<x-app-layout>
    <x-slot name="header">Kamera CCTV</x-slot>

    {{-- Alpine root — owns ALL modal state --}}
    <div
        x-data="{
            showCreate: false,

            showEdit: false,
            edit: { id: null, id_area: '', nama_kamera: '', rtsp_url: '', status: 'aktif' },
            openEdit(k) { this.edit = { ...k }; this.showEdit = true; },

            showDelete: false,
            del: { id: null, nama: '' },
            openDelete(id, nama) { this.del = { id, nama }; this.showDelete = true; },

            closeAll() { this.showCreate = false; this.showEdit = false; this.showDelete = false; }
        }"
        @keydown.escape.window="closeAll()"
    >

    {{-- PAGE HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kamera CCTV</h1>
            <p class="page-sub">Kelola seluruh kamera CCTV yang terdaftar di sistem parkir.</p>
        </div>
        <button @click="showCreate = true" class="btn-primary">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kamera
        </button>
    </div>

    {{-- TOASTS --}}
    @if (session('success'))
        <div class="toast toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="toast toast-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="toast toast-error" x-data x-init="
            @if(old('_form') === 'edit') showEdit = true; edit = { id: '{{ old('_id') }}', id_area: '{{ old('id_area') }}', nama_kamera: '{{ old('nama_kamera') }}', rtsp_url: '{{ old('rtsp_url') }}', status: '{{ old('status','aktif') }}' };
            @else showCreate = true; @endif
        ">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span>@foreach ($errors->all() as $e){{ $e }}{{ !$loop->last ? ' · ' : '' }}@endforeach</span>
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="card">
        @if ($kameras->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="empty-title">Belum ada kamera</p>
                <p class="empty-sub">Tambahkan kamera CCTV pertama Anda untuk memulai sistem deteksi parkir.</p>
                <button @click="showCreate = true" class="btn-primary" style="margin-top:18px;">
                    + Tambah Kamera Pertama
                </button>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th>Area Parkir</th>
                            <th>Nama Kamera</th>
                            <th>URL RTSP</th>
                            <th style="width:100px; text-align:center;">Status</th>
                            <th style="width:88px; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kameras as $i => $kamera)
                        <tr>
                            <td class="cell-num">{{ $i + 1 }}</td>
                            <td>
                                <span class="area-chip">
                                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $kamera->area->nama_area ?? '—' }}
                                </span>
                            </td>
                            <td>
                                <div class="cam-name-cell">
                                    <div class="cam-dot {{ $kamera->status === 'aktif' ? 'cam-dot-on' : 'cam-dot-off' }}"></div>
                                    <span class="cell-bold">{{ $kamera->nama_kamera }}</span>
                                </div>
                            </td>
                            <td class="cell-mono">{{ $kamera->rtsp_url }}</td>
                            <td style="text-align:center;">
                                @if ($kamera->status === 'aktif')
                                    <span class="badge-green">Aktif</span>
                                @else
                                    <span class="badge-red">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-row">
                                    <button
                                        @click="openEdit({
                                            id:          '{{ $kamera->id_kamera }}',
                                            id_area:     '{{ $kamera->id_area }}',
                                            nama_kamera: @js($kamera->nama_kamera),
                                            rtsp_url:    @js($kamera->rtsp_url),
                                            status:      '{{ $kamera->status }}'
                                        })"
                                        class="btn-icon btn-icon-blue" title="Edit Kamera">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button
                                        @click="openDelete('{{ $kamera->id_kamera }}', @js($kamera->nama_kamera))"
                                        class="btn-icon btn-icon-red" title="Hapus Kamera">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span class="table-footer-text">
                    {{ $kameras->count() }} kamera terdaftar
                    · Aktif: <strong>{{ $kameras->where('status','aktif')->count() }}</strong>
                    · Nonaktif: <strong>{{ $kameras->where('status','tidak_aktif')->count() }}</strong>
                </span>
            </div>
        @endif
    </div>


    {{-- MODAL — CREATE --}}
    <div x-show="showCreate" class="modal-backdrop" @click.self="showCreate = false" style="display:none;"
        x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="modal-box"
            x-transition:enter="t-pop" x-transition:enter-start="pop-out" x-transition:enter-end="pop-in"
            x-transition:leave="t-pop" x-transition:leave-start="pop-in"  x-transition:leave-end="pop-out">

            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-icon">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Tambah Kamera CCTV</h3>
                        <p class="modal-sub">Daftarkan kamera baru ke sistem parkir.</p>
                    </div>
                </div>
                <button @click="showCreate = false" class="modal-close">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form action="{{ route('kamera.store') }}" method="POST" class="modal-form">
                @csrf
                <input type="hidden" name="_form" value="create">

                <div class="field-row-2">
                    <div class="field-group">
                        <label class="field-label">Area Parkir <span class="req">*</span></label>
                        <select name="id_area" class="field-input" required>
                            <option value="">— Pilih area —</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id_area }}" {{ old('id_area') == $area->id_area ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Status <span class="req">*</span></label>
                        <select name="status" class="field-input" required>
                            <option value="aktif"       {{ old('status','aktif') === 'aktif'       ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status') === 'tidak_aktif'          ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Nama Kamera <span class="req">*</span></label>
                    <input type="text" name="nama_kamera" class="field-input"
                        value="{{ old('nama_kamera') }}" placeholder="Contoh: CCTV Pintu Utama A" required autofocus>
                    <p class="field-hint">Gunakan nama yang deskriptif dan mudah diidentifikasi.</p>
                </div>

                <div class="field-group">
                    <label class="field-label">URL RTSP <span class="req">*</span></label>
                    <input type="url" name="rtsp_url" class="field-input field-mono"
                        value="{{ old('rtsp_url') }}" placeholder="rtsp://user:pass@192.168.1.100/stream" required>
                    <p class="field-hint">Format: <code>rtsp://username:password@ip-address/path</code></p>
                </div>

                <div class="modal-footer">
                    <button type="button" @click="showCreate = false" class="btn-ghost-sm">Batal</button>
                    <button type="submit" class="btn-primary">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Kamera
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- MODAL — EDIT --}}
    <div x-show="showEdit" class="modal-backdrop" @click.self="showEdit = false" style="display:none;"
        x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="modal-box"
            x-transition:enter="t-pop" x-transition:enter-start="pop-out" x-transition:enter-end="pop-in"
            x-transition:leave="t-pop" x-transition:leave-start="pop-in"  x-transition:leave-end="pop-out">

            <div class="modal-header">
                <div class="modal-header-left">
                    <div class="modal-icon modal-icon-blue">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="modal-title">Edit Kamera CCTV</h3>
                        <p class="modal-sub" x-text="'Mengubah: ' + edit.nama_kamera"></p>
                    </div>
                </div>
                <button @click="showEdit = false" class="modal-close">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form :action="'{{ url('kamera') }}/' + edit.id" method="POST" class="modal-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="_form" value="edit">
                <input type="hidden" name="_id"   :value="edit.id">

                <div class="field-row-2">
                    <div class="field-group">
                        <label class="field-label">Area Parkir <span class="req">*</span></label>
                        <select name="id_area" class="field-input" required>
                            <option value="">— Pilih area —</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id_area }}" :selected="edit.id_area == '{{ $area->id_area }}'">{{ $area->nama_area }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Status <span class="req">*</span></label>
                        <select name="status" class="field-input" x-model="edit.status" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-label">Nama Kamera <span class="req">*</span></label>
                    <input type="text" name="nama_kamera" class="field-input" x-model="edit.nama_kamera" required>
                </div>

                <div class="field-group">
                    <label class="field-label">URL RTSP <span class="req">*</span></label>
                    <input type="url" name="rtsp_url" class="field-input field-mono"
                        x-model="edit.rtsp_url" required placeholder="rtsp://user:pass@192.168.1.100/stream">
                    <p class="field-hint">Format: <code>rtsp://username:password@ip-address/path</code></p>
                </div>

                <div class="modal-footer">
                    <button type="button" @click="showEdit = false" class="btn-ghost-sm">Batal</button>
                    <button type="submit" class="btn-primary">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- MODAL — DELETE --}}
    <div x-show="showDelete" class="modal-backdrop" @click.self="showDelete = false" style="display:none;"
        x-transition:enter="t-fade" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="t-fade" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="modal-box modal-box-sm"
            x-transition:enter="t-pop" x-transition:enter-start="pop-out" x-transition:enter-end="pop-in"
            x-transition:leave="t-pop" x-transition:leave-start="pop-in"  x-transition:leave-end="pop-out">

            <div class="delete-body">
                <div class="delete-icon">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <h3 class="delete-title">Hapus Kamera?</h3>
                <p class="delete-sub">
                    Kamera <strong x-text="del.nama"></strong> akan dihapus secara permanen
                    beserta semua konfigurasi RoI yang terkait.
                </p>
                <p class="delete-warn">Tindakan ini tidak dapat dibatalkan.</p>
            </div>

            <form :action="'{{ url('kamera') }}/' + del.id" method="POST" class="delete-footer">
                @csrf
                @method('DELETE')
                <button type="button" @click="showDelete = false" class="btn-ghost-sm" style="flex:1; justify-content:center;">Batal</button>
                <button type="submit" class="btn-danger" style="flex:1;">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>

    </div>{{-- end x-data --}}

    @include('layouts.table-styles')

    <style>
        :root {
            --bg-base:#F7F6F3; --bg-surface:#FFFFFF;
            --border:#E8E6E1; --border-soft:#F0EDE8;
            --text-primary:#1A1916; --text-secondary:#6B6860; --text-muted:#A09D97;
            --accent:#D97706; --accent-hover:#B45309;
            --font-mono:'DM Mono',monospace;
            --radius-sm:6px; --radius-md:10px; --radius-lg:14px;
            --transition:150ms cubic-bezier(0.4,0,0.2,1);
        }

        .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; gap:16px; flex-wrap:wrap; }
        .page-title  { font-size:20px; font-weight:700; color:var(--text-primary); letter-spacing:-0.02em; }
        .page-sub    { font-size:13px; color:var(--text-secondary); margin-top:2px; }

        .toast { display:flex; align-items:center; gap:9px; padding:12px 16px; border-radius:var(--radius-md); font-size:13px; font-weight:500; margin-bottom:16px; }
        .toast-success { background:#F0FDF4; border:1px solid #BBF7D0; color:#15803D; }
        .toast-error   { background:#FEF2F2; border:1px solid #FECDD3; color:#BE123C; }

        .cam-name-cell { display:flex; align-items:center; gap:9px; }
        .cam-dot       { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
        .cam-dot-on    { background:#22C55E; box-shadow:0 0 0 2px rgba(34,197,94,0.2); }
        .cam-dot-off   { background:#D1D5DB; }

        .area-chip { display:inline-flex; align-items:center; gap:4px; font-size:12px; color:var(--text-secondary); }

        .table-footer      { padding:12px 16px; border-top:1px solid var(--border-soft); background:var(--bg-base); }
        .table-footer-text { font-size:12px; color:var(--text-muted); }

        /* MODAL */
        .modal-backdrop {
            position:fixed; inset:0; z-index:60;
            background:rgba(26,25,22,0.45); backdrop-filter:blur(3px);
            display:flex; align-items:center; justify-content:center; padding:20px;
        }
        .t-fade { transition:opacity 200ms ease; }
        .opacity-0 { opacity:0; } .opacity-100 { opacity:1; }

        .modal-box {
            background:var(--bg-surface); border:1px solid var(--border); border-radius:16px;
            width:100%; max-width:500px;
            box-shadow:0 24px 64px rgba(26,25,22,0.18),0 4px 12px rgba(26,25,22,0.08);
            overflow:hidden;
        }
        .modal-box-sm { max-width:380px; }
        .t-pop   { transition:opacity 200ms ease, transform 220ms cubic-bezier(0.34,1.2,0.64,1); }
        .pop-out { opacity:0; transform:scale(0.95) translateY(8px); }
        .pop-in  { opacity:1; transform:scale(1) translateY(0); }

        .modal-header { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; padding:20px 22px 16px; border-bottom:1px solid var(--border-soft); }
        .modal-header-left { display:flex; align-items:flex-start; gap:12px; }
        .modal-icon { width:36px; height:36px; border-radius:9px; background:#FEF3C7; color:var(--accent); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .modal-icon-blue { background:#DBEAFE; color:#1D4ED8; }
        .modal-title { font-size:15px; font-weight:700; color:var(--text-primary); line-height:1.2; }
        .modal-sub   { font-size:12px; color:var(--text-muted); margin-top:3px; }
        .modal-close { width:30px; height:30px; border-radius:7px; border:1px solid var(--border); background:transparent; display:flex; align-items:center; justify-content:center; color:var(--text-muted); cursor:pointer; flex-shrink:0; transition:all var(--transition); }
        .modal-close:hover { background:var(--bg-base); color:var(--text-primary); }

        .modal-form { display:flex; flex-direction:column; gap:16px; padding:20px 22px 0; }
        .field-row-2 { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
        .modal-footer { display:flex; align-items:center; justify-content:flex-end; gap:8px; padding:16px 22px; border-top:1px solid var(--border-soft); background:var(--bg-base); margin-top:4px; }

        .field-group { display:flex; flex-direction:column; gap:5px; }
        .field-label { font-size:12px; font-weight:600; color:var(--text-secondary); letter-spacing:0.02em; }
        .req { color:var(--accent); }
        .field-input {
            width:100%; padding:9px 12px;
            font-size:13.5px; font-family:inherit; color:var(--text-primary);
            background:var(--bg-surface); border:1px solid var(--border); border-radius:var(--radius-md);
            outline:none; transition:border-color var(--transition),box-shadow var(--transition); appearance:none;
        }
        .field-input:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(217,119,6,0.1); }
        .field-input::placeholder { color:var(--text-muted); }
        .field-mono { font-family:var(--font-mono); font-size:12.5px; }
        .field-hint { font-size:11.5px; color:var(--text-muted); }
        .field-hint code { font-family:var(--font-mono); font-size:11px; background:var(--bg-base); padding:1px 5px; border-radius:4px; }
        select.field-input {
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23A09D97' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 12px center; padding-right:36px;
        }

        .delete-body { padding:28px 28px 20px; display:flex; flex-direction:column; align-items:center; text-align:center; }
        .delete-icon { width:52px; height:52px; border-radius:14px; background:#FEF2F2; color:#DC2626; display:flex; align-items:center; justify-content:center; margin-bottom:16px; }
        .delete-title { font-size:16px; font-weight:700; color:var(--text-primary); margin-bottom:10px; }
        .delete-sub   { font-size:13.5px; color:var(--text-secondary); line-height:1.65; max-width:280px; }
        .delete-warn  { margin-top:10px; font-size:11.5px; font-weight:600; color:#DC2626; background:#FEF2F2; padding:5px 12px; border-radius:99px; border:1px solid #FECACA; }
        .delete-footer { display:flex; gap:8px; padding:16px 22px; border-top:1px solid var(--border-soft); background:var(--bg-base); }

        .btn-primary  { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:var(--radius-md); font-size:13px; font-weight:600; color:#fff; background:var(--accent); border:none; cursor:pointer; text-decoration:none; transition:background var(--transition); }
        .btn-primary:hover { background:var(--accent-hover); }
        .btn-ghost-sm { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-md); font-size:13px; font-weight:500; color:var(--text-secondary); background:transparent; border:1px solid var(--border); text-decoration:none; cursor:pointer; transition:all var(--transition); }
        .btn-ghost-sm:hover { background:var(--bg-base); color:var(--text-primary); }
        .btn-danger   { display:inline-flex; align-items:center; justify-content:center; gap:7px; padding:9px 18px; border-radius:var(--radius-md); font-size:13px; font-weight:600; color:#fff; background:#DC2626; border:none; cursor:pointer; transition:background var(--transition); }
        .btn-danger:hover { background:#B91C1C; }
    </style>

</x-app-layout>