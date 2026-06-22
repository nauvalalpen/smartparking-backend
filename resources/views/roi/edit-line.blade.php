<x-app-layout>
    <x-slot name="header">Edit Garis Traffic</x-slot>

    <div class="form-page">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('roi.index') }}?kamera_id={{ $kamera->id_kamera }}" class="bc-link">ROI Manager</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">Edit Garis: {{ $line['nama_line'] }}</span>
        </div>

        <div class="form-layout">

            {{-- Main form card --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon" style="background:#FCE7F3; color:var(--magenta);">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 12h16M4 12l4-4m-4 4l4 4M20 12l-4-4m4 4l-4 4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Edit Garis Traffic</h2>
                        <p class="form-card-sub">Perbarui nama dan koordinat garis traffic flow.</p>
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

                    <form action="{{ route('roi.line.update', $line['id_line']) }}" method="POST" class="sp-form">
                        @csrf
                        @method('PUT')

                        <div class="field-group">
                            <label class="field-label">Nama Garis <span class="field-required">*</span></label>
                            <input type="text" name="nama_line" class="field-input" value="{{ $line['nama_line'] }}"
                                required>
                            <p class="field-hint">Nama unik untuk identifikasi garis traffic flow.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Koordinat Garis (JSON) <span class="field-required">*</span></label>
                            <textarea name="koordinat_line" class="field-input field-textarea" rows="6" required>{{ $line['koordinat_line'] }}</textarea>
                            <p class="field-hint">Format: JSON array dari 2 koordinat titik [{"x":...,"y":...},{"x":...,"y":...}]</p>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('roi.index', ['kamera_id' => $kamera->id_kamera]) }}"
                                class="btn-ghost-sm">Batal</a>
                            <button type="submit" class="btn-primary" style="background:var(--magenta); box-shadow:0 2px 8px rgba(219,39,119,.3);">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Garis
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info sidebar --}}
            <div class="form-aside">
                <div class="aside-card">
                    <p class="aside-title">Informasi Garis</p>
                    <div class="aside-meta">
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Nama Garis</span>
                            <span class="aside-meta-val">{{ $line['nama_line'] }}</span>
                        </div>
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Kamera</span>
                            <span class="aside-meta-val">{{ $kamera->nama_kamera }} (ID: {{ $kamera->id_kamera }})</span>
                        </div>
                    </div>
                </div>
                <div class="aside-card aside-card-amber">
                    <p class="aside-title">Format Koordinat</p>
                    <p class="aside-desc">Format koordinat garis harus berupa JSON array tepat 2 titik koordinat (awal dan akhir).</p>
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

        .field-textarea {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            resize: none;
            background: var(--bg-base);
            color: var(--text-secondary);
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
