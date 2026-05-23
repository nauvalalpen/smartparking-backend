<x-app-layout>
    <x-slot name="header">Edit Area Parkiran</x-slot>

    <div class="form-page">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('area.index') }}" class="bc-link">Area Parkiran</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">Edit Area</span>
        </div>

        <div class="form-layout">

            {{-- Main form card --}}
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-card-icon">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.5m0 0H9m0 0h-2m9.5 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871m-6.258 0H9m0 0V9m0 3.375c0 .621.504 1.125 1.125 1.125h.872m-1.125 0h6.5c.621 0 1.125-.504 1.125-1.125V9M9 21h6m0-7.5h3m0 2.25h-3m0 2.25h3" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="form-card-title">Edit Data Area</h2>
                        <p class="form-card-sub">Perbarui informasi area parkiran dan kapasitas slotnya.</p>
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

                    <form action="{{ route('area.update', $area->id_area) }}" method="POST" class="sp-form">
                        @csrf
                        @method('PUT')

                        <div class="field-group">
                            <label class="field-label">Nama Area <span class="field-required">*</span></label>
                            <input type="text" name="nama_area" class="field-input" value="{{ $area->nama_area }}"
                                required>
                            <p class="field-hint">Nama area yang mudah dikenali.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Deskripsi</label>
                            <textarea name="deskripsi" class="field-input" rows="3">{{ $area->deskripsi }}</textarea>
                            <p class="field-hint">Informasi tambahan tentang lokasi atau karakteristik area.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Kapasitas Total Slot <span
                                    class="field-required">*</span></label>
                            <input type="number" name="kapasitas_total" class="field-input"
                                value="{{ $area->kapasitas_total }}" min="1" required>
                            <p class="field-hint">Jumlah total slot parkir yang dapat ditampung di area ini.</p>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('area.index') }}" class="btn-ghost-sm">Batal</a>
                            <button type="submit" class="btn-primary">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Update Area
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Info sidebar --}}
            <div class="form-aside">
                <div class="aside-card">
                    <p class="aside-title">Informasi Area</p>
                    <div class="aside-meta">
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Total Kapasitas</span>
                            <span class="aside-meta-val">{{ $area->kapasitas_total }} slot</span>
                        </div>
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Slot Terpakai</span>
                            <span class="aside-meta-val">{{ $area->filled_slots ?? 0 }} slot</span>
                        </div>
                        <div class="aside-meta-row">
                            <span class="aside-meta-key">Slot Tersedia</span>
                            <span class="aside-meta-val">{{ $area->available_slots ?? 0 }} slot</span>
                        </div>
                    </div>
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

        @media (max-width: 720px) {
            .form-content-wrapper {
                max-height: calc(100vh - 280px);
            }
        }
    </style>
</x-app-layout>
