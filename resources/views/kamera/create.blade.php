<x-app-layout>
    <x-slot name="header">Tambah Kamera CCTV</x-slot>

    <div class="form-page">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('kamera.index') }}" class="bc-link">Kamera CCTV</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">Tambah Kamera</span>
        </div>

        <div class="form-layout">

            {{-- Main form card --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Detail Kamera</h2>
                        <p class="form-card-sub">Isi informasi kamera CCTV yang akan didaftarkan.</p>
                    </div>
                </div>

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="error-box">
                        <div class="error-box-icon">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
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

                <form action="{{ route('kamera.store') }}" method="POST" class="sp-form">
                    @csrf

                    <div class="form-row-2">
                        <div class="field-group">
                            <label class="field-label">Area Parkir <span class="field-required">*</span></label>
                            <select name="id_area" class="field-select" required>
                                <option value="">— Pilih area —</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id_area }}"
                                        {{ old('id_area') == $area->id_area ? 'selected' : '' }}>
                                        {{ $area->nama_area }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Status <span class="field-required">*</span></label>
                            <select name="status" class="field-select" required>
                                <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option
                                    value="tidak_aktif"{{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>
                                    Tidak Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Nama Kamera <span class="field-required">*</span></label>
                        <input type="text" name="nama_kamera" class="field-input" value="{{ old('nama_kamera') }}"
                            placeholder="Contoh: CCTV Pintu Utama A" required>
                        <p class="field-hint">Gunakan nama yang mudah dikenali, seperti nama lokasi atau nomor urut.</p>
                    </div>

                    <div class="field-group">
                        <label class="field-label">URL RTSP <span class="field-required">*</span></label>
                        <input type="url" name="rtsp_url" class="field-input field-mono"
                            value="{{ old('rtsp_url') }}" placeholder="rtsp://user:password@192.168.1.100/stream"
                            required>
                        <p class="field-hint">Format: <code>rtsp://username:password@ip-address/path</code></p>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('kamera.index') }}" class="btn-ghost-sm">Batal</a>
                        <button type="submit" class="btn-primary">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Kamera
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info sidebar --}}
            <div class="form-aside">
                <div class="aside-card">
                    <p class="aside-title">Tips Pengisian</p>
                    <ul class="aside-list">
                        <li>Pastikan URL RTSP sudah diuji dan dapat diakses dari server.</li>
                        <li>Gunakan nama kamera yang deskriptif agar mudah diidentifikasi.</li>
                        <li>Set status <strong>Tidak Aktif</strong> jika kamera belum siap digunakan.</li>
                        <li>Setelah disimpan, Anda dapat mengkonfigurasi RoI dari halaman daftar kamera.</li>
                    </ul>
                </div>
                <div class="aside-card aside-card-amber">
                    <p class="aside-title">Format RTSP</p>
                    <code class="rtsp-example">rtsp://admin:pass<br>@192.168.1.100:554<br>/stream1</code>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.form-styles')
</x-app-layout>
