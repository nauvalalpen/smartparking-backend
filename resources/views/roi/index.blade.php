<x-app-layout>
    <x-slot name="header">Konfigurasi Region of Interest</x-slot>

    <div class="roi-page-alt">
        {{-- Camera selector --}}
        <div class="card camera-selector-card">
            <div class="camera-selector-inner">
                <label class="camera-selector-label">Pilih Kamera:</label>
                <select id="kameraSelector" onchange="changeKamera(this.value)" class="camera-selector-input">
                    @if ($kameras->isEmpty())
                        <option value="">— Belum ada kamera aktif —</option>
                    @else
                        @foreach ($kameras as $kam)
                            <option value="{{ $kam->id_kamera }}"
                                {{ $selectedKamera && $selectedKamera->id_kamera == $kam->id_kamera ? 'selected' : '' }}>
                                {{ $kam->nama_kamera }} — {{ $kam->rtsp_url }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="roi-grid-alt">

            {{-- ═══════════════════════════════
                 KOLOM KIRI: CANVAS
            ═══════════════════════════════ --}}
            <div class="roi-left-alt">
                <div class="card roi-card-alt">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title-alt">Area Parkiran</h2>
                            <p class="roi-card-sub-alt">Klik untuk menambah titik · Double-click untuk menutup poligon
                            </p>
                        </div>
                    </div>

                    <div class="canvas-wrapper-alt" id="canvas-wrapper">
                        @if ($selectedKamera)
                            <img id="camera-frame"
                                src="{{ asset('snapshots/kamera_' . $selectedKamera->id_kamera . '.jpg') }}"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/640x480.png?text=Feed+Kamera+CCTV';"
                                class="canvas-img-alt" alt="Camera Feed">
                            <canvas id="roi-canvas" class="canvas-overlay-alt"></canvas>
                        @else
                            <div class="canvas-placeholder-alt">
                                <svg width="40" height="40" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5" style="color:#A09D97; margin-bottom:12px;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <p>Pilih kamera terlebih dahulu untuk memulai</p>
                            </div>
                        @endif
                    </div>

                    <div class="roi-actions-alt">
                        <button type="button" onclick="clearCanvas()" class="btn-reset-alt">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </button>
                        <span class="roi-point-counter" id="point-counter" style="display:none;">
                            <span id="point-count">0</span> titik
                        </span>
                        {{-- Legend ROI tersimpan --}}
                        @if ($selectedKamera && $slots->count() > 0)
                            <div class="canvas-legend">
                                <span class="legend-dot legend-dot-saved"></span>
                                <span class="legend-label">Tersimpan ({{ $slots->count() }})</span>
                                <span class="legend-dot legend-dot-active" style="margin-left:10px;"></span>
                                <span class="legend-label">Sedang digambar</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ═══════════════════════════════
                 KOLOM KANAN: FORM + LIST
            ═══════════════════════════════ --}}
            <div class="roi-right-alt">

                {{-- ── Form Simpan ── --}}
                <div class="card roi-card-alt">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt roi-card-icon-accent">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title-alt">Tambah Slot</h2>
                            <p class="roi-card-sub-alt">Isi nama lalu simpan koordinat poligon</p>
                        </div>
                    </div>

                    <form action="{{ route('roi.store') }}" method="POST" class="roi-form-alt" id="roi-store-form">
                        @csrf
                        <input type="hidden" name="id_kamera" value="{{ $selectedKamera->id_kamera ?? '' }}">

                        <div class="field-group">
                            <label class="field-label">Nama Slot <span class="field-required">*</span></label>
                            <input type="text" name="nama_slot" id="nama_slot_input" class="field-input"
                                placeholder="Contoh: A1" required>
                            <p class="field-hint">Nama unik untuk identifikasi slot parkir.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Koordinat (JSON) <span class="field-required">*</span></label>
                            <textarea id="koordinat_input" name="koordinat_roi" rows="4" class="field-input field-textarea" readonly
                                required placeholder="Gambar di canvas untuk mengisi ini..."></textarea>
                            <p class="field-hint">Otomatis terisi · Double-click untuk tutup poligon.</p>
                        </div>

                        {{-- Save button — lebih jelas, full-width, dengan state disabled --}}
                        <button type="submit" id="btn-simpan" class="btn-simpan-roi" disabled>
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2M12 12V3m0 0L8 7m4-4l4 4" />
                            </svg>
                            <span id="btn-simpan-text">Gambar poligon terlebih dahulu</span>
                        </button>
                    </form>
                </div>

                {{-- ── Slot Terdaftar ── --}}
                <div class="card roi-card-alt">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt roi-card-icon-blue">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <h2 class="roi-card-title-alt">Slot Terdaftar</h2>
                            <p class="roi-card-sub-alt">{{ $slots->count() }} slot dikonfigurasi</p>
                        </div>
                    </div>

                    {{-- Scrollable list --}}
                    <div class="roi-list-scroll">
                        @forelse($slots as $slot)
                            <div class="roi-list-item-alt" onmouseenter="highlightSlot('{{ $slot->id_slot }}')"
                                onmouseleave="unhighlightSlot()">
                                <div class="slot-info">
                                    <div class="slot-badge">{{ strtoupper(substr($slot->nama_slot, 0, 2)) }}</div>
                                    <div>
                                        <p class="slot-name-alt">{{ $slot->nama_slot }}</p>
                                        <p class="slot-coords-alt">{{ substr($slot->koordinat_roi, 0, 28) }}…</p>
                                    </div>
                                </div>
                                <div class="roi-list-actions-alt">
                                    <a href="{{ route('roi.edit', $slot->id_slot) }}" class="btn-icon btn-icon-blue"
                                        title="Edit">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('roi.destroy', $slot->id_slot) }}" method="POST"
                                        onsubmit="return confirm('Hapus slot {{ $slot->nama_slot }}?');"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-icon btn-icon-red" title="Hapus">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="roi-empty-alt">
                                <svg width="32" height="32" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.5"
                                    style="color:#D9D6D0; margin-bottom:8px;">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p>Belum ada slot terdaftar.</p>
                                <p style="font-size:12px; margin-top:4px;">Gambar poligon di canvas lalu simpan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>{{-- /roi-right-alt --}}
        </div>
    </div>

    @include('layouts.form-styles')
    @include('layouts.table-styles')

    {{-- Pass saved slots ke JS sebagai JSON --}}
    @if ($selectedKamera)
        @php
            $slotsForJs = $slots
                ->map(function ($s) {
                    return [
                        'id' => $s->id_slot,
                        'nama' => $s->nama_slot,
                        'coords' => json_decode($s->koordinat_roi, true) ?? [],
                    ];
                })
                ->values()
                ->all();
        @endphp
        <script>
            const SAVED_SLOTS = @json($slotsForJs);
        </script>
    @else
        <script>
            const SAVED_SLOTS = [];
        </script>
    @endif

    <style>
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
            --radius-md: 10px;
            --radius-lg: 14px;
            --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .roi-page-alt {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Camera selector */
        .camera-selector-card {
            padding: 16px 20px;
        }

        .camera-selector-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .camera-selector-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .camera-selector-input {
            flex: 1;
            min-width: 200px;
            padding: 8px 12px;
            font-size: 13px;
            color: var(--text-primary);
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            outline: none;
            transition: border-color var(--transition);
        }

        .camera-selector-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, .1);
        }

        /* Grid */
        .roi-grid-alt {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .roi-left-alt,
        .roi-right-alt {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Card */
        .roi-card-alt {
            padding: 20px 22px;
        }

        .roi-card-header-alt {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-soft);
        }

        .roi-card-icon-alt {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #DBEAFE;
            color: #2563EB;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .roi-card-icon-accent {
            background: #FEF3C7;
            color: var(--accent);
        }

        .roi-card-icon-blue {
            background: #DBEAFE;
            color: #2563EB;
        }

        .roi-card-title-alt {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .roi-card-sub-alt {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* Canvas */
        .canvas-wrapper-alt {
            position: relative;
            display: inline-block;
            width: 100%;
            margin-bottom: 14px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            background: #111;
            line-height: 0;
        }

        .canvas-img-alt {
            display: block;
            width: 100%;
            height: auto;
            border-radius: calc(var(--radius-md) - 1px);
        }

        .canvas-overlay-alt {
            position: absolute;
            top: 0;
            left: 0;
            cursor: crosshair;
            border-radius: calc(var(--radius-md) - 1px);
        }

        .canvas-placeholder-alt {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 360px;
            color: var(--text-muted);
            text-align: center;
            font-size: 14px;
        }

        /* Actions row */
        .roi-actions-alt {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-reset-alt {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #DC2626;
            background: transparent;
            border: 1px solid #FECACA;
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-reset-alt:hover {
            background: #FEF2F2;
            border-color: #FCA5A5;
        }

        .roi-point-counter {
            font-size: 12px;
            color: var(--text-muted);
            background: var(--bg-base);
            border: 1px solid var(--border);
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Legend */
        .canvas-legend {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            color: var(--text-muted);
            background: var(--bg-base);
            border: 1px solid var(--border);
            padding: 5px 10px;
            border-radius: 6px;
            margin-left: auto;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .legend-dot-saved {
            background: #16A34A;
        }

        .legend-dot-active {
            background: #DC2626;
        }

        .legend-label {
            font-size: 11px;
            color: var(--text-muted);
        }

        /* Form */
        .roi-form-alt {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .field-textarea {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            resize: none;
            background: var(--bg-base);
            color: var(--text-secondary);
        }

        /* ── Tombol Simpan ── */
        .btn-simpan-roi {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 16px;
            border-radius: 9px;
            border: none;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 150ms ease;
        }

        /* disabled: poligon belum digambar */
        .btn-simpan-roi:disabled {
            background: var(--bg-base);
            color: var(--text-muted);
            border: 1.5px dashed var(--border);
            cursor: not-allowed;
        }

        /* ready: ada koordinat */
        .btn-simpan-roi.ready {
            background: var(--accent);
            color: white;
            box-shadow: 0 2px 8px rgba(217, 119, 6, .3);
        }

        .btn-simpan-roi.ready:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(217, 119, 6, .35);
        }

        .btn-simpan-roi.ready:active {
            transform: translateY(0);
        }

        /* ── Slot List Scrollable ── */
        .roi-list-scroll {
            max-height: 320px;
            overflow-y: auto;
            overflow-x: hidden;
            margin: 0 -4px;
            padding: 0 4px;
        }

        .roi-list-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .roi-list-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .roi-list-scroll::-webkit-scrollbar-thumb {
            background: #D9D6D0;
            border-radius: 3px;
        }

        .roi-list-scroll::-webkit-scrollbar-thumb:hover {
            background: #C0BDB7;
        }

        .roi-list-item-alt {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 8px;
            border-radius: 8px;
            border-bottom: 1px solid var(--border-soft);
            transition: background 100ms ease;
            cursor: default;
        }

        .roi-list-item-alt:last-child {
            border-bottom: none;
        }

        .roi-list-item-alt:hover {
            background: #F7F6F3;
        }

        .roi-list-item-alt.highlighted {
            background: #FEF3C7;
        }

        /* Slot item layout */
        .slot-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .slot-badge {
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            border-radius: 7px;
            background: #DBEAFE;
            color: #2563EB;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slot-name-alt {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .slot-coords-alt {
            font-size: 10.5px;
            color: var(--text-muted);
            margin: 2px 0 0;
            font-family: 'DM Mono', monospace;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
        }

        .roi-list-actions-alt {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        .roi-empty-alt {
            padding: 24px 16px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .roi-grid-alt {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 720px) {
            .camera-selector-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .camera-selector-label,
            .camera-selector-input {
                width: 100%;
            }

            .roi-card-alt {
                padding: 16px 18px;
            }

            .roi-card-header-alt {
                margin-bottom: 16px;
                padding-bottom: 12px;
                gap: 10px;
            }

            .roi-card-icon-alt {
                width: 32px;
                height: 32px;
            }

            .canvas-legend {
                display: none;
            }
        }
    </style>

    <script>
        (function() {
            /* ── refs ── */
            const canvas = document.getElementById('roi-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const img = document.getElementById('camera-frame');
            const inputKoord = document.getElementById('koordinat_input');
            const counter = document.getElementById('point-counter');
            const countNum = document.getElementById('point-count');
            const btnSimpan = document.getElementById('btn-simpan');
            const btnText = document.getElementById('btn-simpan-text');

            let points = [];
            let closed = false;
            let hoveredSlot = null; /* id slot yang di-hover dari list */

            /* ═══════════════════════════════════════
               1. SYNC CANVAS SIZE ke render gambar
            ═══════════════════════════════════════ */
            function syncCanvasSize() {
                if (!img.naturalWidth) return;
                const r = img.getBoundingClientRect();
                canvas.style.width = r.width + 'px';
                canvas.style.height = r.height + 'px';
                canvas.width = img.naturalWidth;
                canvas.height = img.naturalHeight;
                redraw();
            }

            if (img.complete && img.naturalWidth) {
                syncCanvasSize();
            } else {
                img.addEventListener('load', syncCanvasSize);
            }
            const ro = new ResizeObserver(syncCanvasSize);
            ro.observe(img);

            /* ═══════════════════════════════════════
               2. KLIK — koordinat akurat
            ═══════════════════════════════════════ */
            canvas.addEventListener('click', function(e) {
                if (closed) return;
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                const x = Math.round((e.clientX - rect.left) * scaleX);
                const y = Math.round((e.clientY - rect.top) * scaleY);
                if (x < 0 || x > canvas.width || y < 0 || y > canvas.height) return;
                points.push({
                    x,
                    y
                });
                updateCounter();
                updateInput();
                redraw();
            });

            /* Double-click: tutup poligon */
            canvas.addEventListener('dblclick', function() {
                if (points.length >= 3) {
                    closed = true;
                    updateInput();
                    updateSaveButton();
                    redraw();
                }
            });

            /* ═══════════════════════════════════════
               3. REDRAW — current + semua saved
            ═══════════════════════════════════════ */
            function redraw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                const dotR = Math.max(5, canvas.width * 0.006);
                const lw = Math.max(2, canvas.width * 0.003);
                const fs = Math.max(12, canvas.width * 0.014);

                /* ── Render semua ROI tersimpan ── */
                if (typeof SAVED_SLOTS !== 'undefined') {
                    SAVED_SLOTS.forEach(function(slot) {
                        if (!slot.coords || slot.coords.length < 2) return;

                        const isHover = (hoveredSlot === String(slot.id));

                        ctx.beginPath();
                        ctx.moveTo(slot.coords[0].x, slot.coords[0].y);
                        for (let i = 1; i < slot.coords.length; i++) {
                            ctx.lineTo(slot.coords[i].x, slot.coords[i].y);
                        }
                        ctx.closePath();

                        /* fill */
                        ctx.fillStyle = isHover ?
                            'rgba(22, 163, 74, 0.35)' :
                            'rgba(22, 163, 74, 0.18)';
                        ctx.fill();

                        /* stroke */
                        ctx.lineWidth = isHover ? lw * 1.8 : lw;
                        ctx.strokeStyle = isHover ? '#16A34A' : '#22C55E';
                        ctx.setLineDash([]);
                        ctx.stroke();

                        /* Label nama slot — background pill */
                        const cx = slot.coords.reduce((s, p) => s + p.x, 0) / slot.coords.length;
                        const cy = slot.coords.reduce((s, p) => s + p.y, 0) / slot.coords.length;

                        ctx.font = `bold ${fs}px sans-serif`;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';

                        const tw = ctx.measureText(slot.nama).width;
                        const ph = fs * 0.45,
                            pw = fs * 0.6;

                        /* pill background */
                        ctx.fillStyle = isHover ? '#15803D' : '#16A34A';
                        roundRect(ctx, cx - tw / 2 - pw, cy - fs / 2 - ph, tw + pw * 2, fs + ph * 2, fs * 0.4);
                        ctx.fill();

                        /* teks */
                        ctx.fillStyle = '#fff';
                        ctx.fillText(slot.nama, cx, cy);
                    });
                }

                /* ── Render poligon yang sedang digambar ── */
                if (points.length === 0) return;

                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);
                for (let i = 1; i < points.length; i++) ctx.lineTo(points[i].x, points[i].y);
                if (closed) ctx.closePath();

                ctx.fillStyle = closed ? 'rgba(37, 99, 235, 0.25)' : 'rgba(37, 99, 235, 0.10)';
                ctx.fill();
                ctx.lineWidth = lw;
                ctx.strokeStyle = closed ? '#2563EB' : '#60A5FA';
                ctx.setLineDash(closed ? [] : [8, 4]);
                ctx.stroke();
                ctx.setLineDash([]);

                points.forEach(function(p, i) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, dotR, 0, 2 * Math.PI);
                    ctx.fillStyle = i === 0 ? '#16A34A' : '#DC2626';
                    ctx.fill();
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = Math.max(1.5, lw * 0.8);
                    ctx.stroke();

                    ctx.font = `bold ${fs}px sans-serif`;
                    ctx.fillStyle = '#fff';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(i + 1, p.x, p.y);
                });
            }

            /* helper: rounded rect path */
            function roundRect(ctx, x, y, w, h, r) {
                ctx.beginPath();
                ctx.moveTo(x + r, y);
                ctx.lineTo(x + w - r, y);
                ctx.quadraticCurveTo(x + w, y, x + w, y + r);
                ctx.lineTo(x + w, y + h - r);
                ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
                ctx.lineTo(x + r, y + h);
                ctx.quadraticCurveTo(x, y + h, x, y + h - r);
                ctx.lineTo(x, y + r);
                ctx.quadraticCurveTo(x, y, x + r, y);
                ctx.closePath();
            }

            /* ═══════════════════════════════════════
               4. STATE HELPERS
            ═══════════════════════════════════════ */
            function updateInput() {
                if (points.length > 0) inputKoord.value = JSON.stringify(points);
            }

            function updateCounter() {
                if (!counter) return;
                counter.style.display = points.length > 0 ? 'inline-flex' : 'none';
                if (countNum) countNum.textContent = points.length;
            }

            function updateSaveButton() {
                if (!btnSimpan) return;
                const hasCoords = points.length >= 3 && closed;
                if (hasCoords) {
                    btnSimpan.disabled = false;
                    btnSimpan.classList.add('ready');
                    if (btnText) btnText.textContent = 'Simpan Slot';
                } else {
                    btnSimpan.disabled = true;
                    btnSimpan.classList.remove('ready');
                    if (btnText) btnText.textContent = 'Gambar poligon terlebih dahulu';
                }
            }

            /* Aktifkan tombol juga saat koordinat textarea terisi (mis. dari double-click) */
            if (inputKoord) {
                const obs = new MutationObserver(updateSaveButton);
                obs.observe(inputKoord, {
                    attributes: true,
                    childList: true,
                    subtree: true
                });
                inputKoord.addEventListener('input', updateSaveButton);
            }

            function clearCanvas() {
                points = [];
                closed = false;
                if (inputKoord) inputKoord.value = '';
                updateCounter();
                updateSaveButton();
                redraw();
            }

            window.clearCanvas = clearCanvas;

            /* ═══════════════════════════════════════
               5. HOVER HIGHLIGHT dari list slot
            ═══════════════════════════════════════ */
            window.highlightSlot = function(id) {
                hoveredSlot = String(id);
                redraw();
                /* Tambah class ke item list */
                document.querySelectorAll('.roi-list-item-alt').forEach(function(el) {
                    el.classList.toggle('highlighted', el.dataset.slotId === String(id));
                });
            };
            window.unhighlightSlot = function() {
                hoveredSlot = null;
                redraw();
                document.querySelectorAll('.roi-list-item-alt').forEach(function(el) {
                    el.classList.remove('highlighted');
                });
            };

            /* Set data-slot-id pada setiap list item agar class toggle bisa match */
            document.querySelectorAll('.roi-list-item-alt').forEach(function(el) {
                const onenter = el.getAttribute('onmouseenter');
                if (onenter) {
                    const m = onenter.match(/'([^']+)'/);
                    if (m) el.dataset.slotId = m[1];
                }
            });

        })();

        function changeKamera(idKamera) {
            if (idKamera) window.location.href = "{{ route('roi.index') }}?kamera_id=" + idKamera;
        }
    </script>
</x-app-layout>
