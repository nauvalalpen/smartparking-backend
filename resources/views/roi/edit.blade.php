<x-app-layout>
    <x-slot name="header">Edit Slot Parkir</x-slot>

    <div class="form-page">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('roi.index') }}" class="bc-link">ROI Manager</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">Edit: {{ $slot->nama_slot }}</span>
        </div>

        <div class="form-layout">

            {{-- Main form card --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Edit Slot Parkir</h2>
                        <p class="form-card-sub">Perbarui nama dan koordinat poligon slot parkir.</p>
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

                    <form action="{{ route('roi.update', $slot->id_slot) }}" method="POST" class="sp-form">
                        @csrf
                        @method('PUT')

                        <div class="field-group">
                            <label class="field-label">Nama Slot <span class="field-required">*</span></label>
                            <input type="text" name="nama_slot" class="field-input" value="{{ $slot->nama_slot }}"
                                required>
                            <p class="field-hint">Nama unik untuk identifikasi slot parkir.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Koordinat (JSON) <span class="field-required">*</span></label>
                            <textarea name="koordinat_roi" class="field-input field-textarea" rows="6" required>{{ $slot->koordinat_roi }}</textarea>
                            <p class="field-hint">Format: JSON array dari koordinat titik [{"x":100,"y":100},...]</p>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('roi.index', ['kamera_id' => $slot->id_kamera]) }}"
                                class="btn-ghost-sm">Batal</a>
                            <button type="submit" class="btn-primary">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Slot
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info sidebar --}}
            <div class="form-aside">
                <div class="aside-card">
                    <p class="aside-title">Informasi Slot</p>
                    <div class="aside-meta">
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Nama Slot</span>
                            <span class="aside-meta-val">{{ $slot->nama_slot }}</span>
                        </div>
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Kamera</span>
                            <span class="aside-meta-val">ID: {{ $slot->id_kamera }}</span>
                        </div>
                    </div>
                </div>
                <div class="aside-card aside-card-amber">
                    <p class="aside-title">Format Koordinat</p>
                    <p class="aside-desc">Pastikan format JSON valid sebelum menyimpan. Setiap titik harus memiliki
                        properti "x" dan "y".</p>
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
