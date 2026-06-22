<x-app-layout>
    <x-slot name="header">Konfigurasi Region of Interest & Garis Traffic</x-slot>

    <div class="roi-page-alt" x-data="{ mode: 'slot' }">

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
                            <h2 class="roi-card-title-alt">Area Parkiran & Garis Sensor</h2>
                            <p class="roi-card-sub-alt" id="canvas-hint">
                                Mode Slot: klik untuk titik, double-click untuk menutup poligon
                            </p>
                        </div>
                    </div>

                    {{-- ── Mode Toggle ── --}}
                    <div class="mode-toggle">
                        <button type="button" id="btn-mode-slot" class="mode-btn mode-btn-active"
                            onclick="setMode('slot')">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Mode Slot (Poligon)
                        </button>
                        <button type="button" id="btn-mode-line" class="mode-btn" onclick="setMode('line')">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 12h16M4 12l4-4m-4 4l4 4M20 12l-4-4m4 4l-4 4" />
                            </svg>
                            Mode Garis (Traffic Flow)
                        </button>
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

                        @if ($selectedKamera)
                            <div class="canvas-legend">
                                <span class="legend-dot legend-dot-saved"></span>
                                <span class="legend-label">Slot ({{ $slots->count() }})</span>
                                <span class="legend-dot legend-dot-line" style="margin-left:10px;"></span>
                                <span class="legend-label">Garis ({{ $lines->count() ?? 0 }})</span>
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

                {{-- ── FORM SLOT (tampil saat mode = slot) ── --}}
                <div class="card roi-card-alt" id="form-card-slot">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt roi-card-icon-accent">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title-alt">Tambah Slot</h2>
                            <p class="roi-card-sub-alt">Isi nama lalu simpan koordinat poligon</p>
                        </div>
                    </div>

                    <form action="{{ route('roi.store') }}" method="POST" class="roi-form-alt">
                        @csrf
                        <input type="hidden" name="id_kamera" value="{{ $selectedKamera->id_kamera ?? '' }}">

                        <div class="field-group">
                            <label class="field-label">Nama Slot <span class="field-required">*</span></label>
                            <input type="text" name="nama_slot" class="field-input" placeholder="Contoh: A1"
                                required>
                            <p class="field-hint">Nama unik untuk identifikasi slot parkir.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Koordinat (JSON) <span class="field-required">*</span></label>
                            <textarea id="koordinat_input" name="koordinat_roi" rows="4" class="field-input field-textarea" readonly
                                required placeholder="Gambar di canvas untuk mengisi ini..."></textarea>
                            <p class="field-hint">Otomatis terisi · Double-click untuk tutup poligon.</p>
                        </div>

                        <button type="submit" id="btn-simpan-slot" class="btn-simpan-roi" disabled>
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2M12 12V3m0 0L8 7m4-4l4 4" />
                            </svg>
                            <span id="btn-simpan-slot-text">Gambar poligon terlebih dahulu</span>
                        </button>
                    </form>
                </div>

                {{-- ── FORM GARIS TRAFFIC (tampil saat mode = line) ── --}}
                <div class="card roi-card-alt" id="form-card-line" style="display:none;">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt roi-card-icon-magenta">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 12h16M4 12l4-4m-4 4l4 4M20 12l-4-4m4 4l-4 4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title-alt">Tambah Garis Traffic</h2>
                            <p class="roi-card-sub-alt">Klik 2 titik di canvas: awal & akhir garis</p>
                        </div>
                    </div>

                    <form action="{{ route('roi.line.store') }}" method="POST" class="roi-form-alt">
                        @csrf
                        <input type="hidden" name="id_kamera" value="{{ $selectedKamera->id_kamera ?? '' }}">

                        <div class="field-group">
                            <label class="field-label">Nama Garis <span class="field-required">*</span></label>
                            <input type="text" name="nama_line" class="field-input"
                                placeholder="Contoh: Counting Line 1" required>
                            <p class="field-hint">Nama unik untuk identifikasi garis traffic flow.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Koordinat Garis (JSON) <span
                                    class="field-required">*</span></label>
                            <textarea id="koordinat_line_input" name="koordinat_line" rows="3" class="field-input field-textarea" readonly
                                required placeholder="Klik 2 titik di canvas untuk mengisi ini..."></textarea>
                            <p class="field-hint">Tepat 2 titik: [{"x":..,"y":..},{"x":..,"y":..}]</p>
                        </div>

                        <button type="submit" id="btn-simpan-line" class="btn-simpan-roi btn-simpan-line" disabled>
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2M12 12V3m0 0L8 7m4-4l4 4" />
                            </svg>
                            <span id="btn-simpan-line-text">Klik 2 titik di canvas</span>
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

                {{-- ── Garis Terdaftar ── --}}
                <div class="card roi-card-alt">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt roi-card-icon-magenta">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 12h16M4 12l4-4m-4 4l4 4M20 12l-4-4m4 4l-4 4" />
                            </svg>
                        </div>
                        <div style="flex:1; min-width:0;">
                            <h2 class="roi-card-title-alt">Garis Terdaftar</h2>
                            <p class="roi-card-sub-alt">{{ $lines->count() ?? 0 }} garis traffic flow</p>
                        </div>
                    </div>

                    <div class="roi-list-scroll">
                        @forelse(($lines ?? []) as $line)
                            <div class="roi-list-item-alt" onmouseenter="highlightLine('{{ $line->id_line }}')"
                                onmouseleave="unhighlightLine()">
                                <div class="slot-info">
                                    <div class="slot-badge slot-badge-magenta">
                                        {{ strtoupper(substr($line->nama_line, 0, 2)) }}</div>
                                    <div>
                                        <p class="slot-name-alt">{{ $line->nama_line }}</p>
                                        <p class="slot-coords-alt">{{ substr($line->koordinat_line, 0, 28) }}…</p>
                                    </div>
                                </div>
                                <div class="roi-list-actions-alt">
                                    <a href="{{ route('roi.line.edit', $line->id_line) }}"
                                        class="btn-icon btn-icon-blue" title="Edit">
                                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('roi.line.destroy', $line->id_line) }}" method="POST"
                                        onsubmit="return confirm('Hapus garis {{ $line->nama_line }}?');"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 12h16" />
                                </svg>
                                <p>Belum ada garis traffic terdaftar.</p>
                                <p style="font-size:12px; margin-top:4px;">Pilih Mode Garis lalu klik 2 titik di
                                    canvas.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>{{-- /roi-right-alt --}}
        </div>
    </div>

    @include('layouts.form-styles')
    @include('layouts.table-styles')

    {{-- Pass saved slots & lines ke JS --}}
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

            $linesForJs = collect($lines ?? [])
                ->map(function ($l) {
                    return [
                        'id' => $l->id_line,
                        'nama' => $l->nama_line,
                        'coords' => json_decode($l->koordinat_line, true) ?? [],
                    ];
                })
                ->values()
                ->all();
        @endphp
        <script>
            const SAVED_SLOTS = @json($slotsForJs);
            const SAVED_LINES = @json($linesForJs);
        </script>
    @else
        <script>
            const SAVED_SLOTS = [];
            const SAVED_LINES = [];
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
            --magenta: #DB2777;
            --magenta-hover: #BE185D;
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
            margin-bottom: 16px;
            padding-bottom: 14px;
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

        .roi-card-icon-magenta {
            background: #FCE7F3;
            color: var(--magenta);
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

        /* ── Mode Toggle ── */
        .mode-toggle {
            display: flex;
            gap: 8px;
            margin-bottom: 14px;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 4px;
        }

        .mode-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: var(--text-secondary);
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            transition: all var(--transition);
        }

        .mode-btn:hover {
            color: var(--text-primary);
        }

        .mode-btn-active {
            background: var(--bg-surface);
            color: var(--text-primary);
            box-shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        #btn-mode-slot.mode-btn-active {
            color: var(--accent);
        }

        #btn-mode-line.mode-btn-active {
            color: var(--magenta);
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

        /* Actions */
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
            flex-wrap: wrap;
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

        .legend-dot-line {
            background: var(--magenta);
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

        /* Tombol Simpan */
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

        .btn-simpan-roi:disabled {
            background: var(--bg-base);
            color: var(--text-muted);
            border: 1.5px dashed var(--border);
            cursor: not-allowed;
        }

        .btn-simpan-roi.ready {
            background: var(--accent);
            color: white;
            box-shadow: 0 2px 8px rgba(217, 119, 6, .3);
        }

        .btn-simpan-roi.ready:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        .btn-simpan-roi.ready:active {
            transform: translateY(0);
        }

        /* Tombol Simpan — variant garis (magenta) */
        .btn-simpan-line.ready {
            background: var(--magenta);
            color: white;
            box-shadow: 0 2px 8px rgba(219, 39, 119, .3);
        }

        .btn-simpan-line.ready:hover {
            background: var(--magenta-hover);
            transform: translateY(-1px);
        }

        /* List Scrollable */
        .roi-list-scroll {
            max-height: 280px;
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

        .slot-badge-magenta {
            background: #FCE7F3;
            color: var(--magenta);
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
            padding: 20px 16px;
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

            .mode-btn {
                font-size: 11px;
                padding: 8px 6px;
            }

            .canvas-legend {
                display: none;
            }
        }
    </style>

    <script>
        (function() {
            /* ═══════════════════════════════════════
               REFS
            ═══════════════════════════════════════ */
            const canvas = document.getElementById('roi-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            const img = document.getElementById('camera-frame');
            const counter = document.getElementById('point-counter');
            const countNum = document.getElementById('point-count');
            const canvasHint = document.getElementById('canvas-hint');

            /* Form Slot */
            const formCardSlot = document.getElementById('form-card-slot');
            const inputKoordSlot = document.getElementById('koordinat_input');
            const btnSimpanSlot = document.getElementById('btn-simpan-slot');
            const btnTextSlot = document.getElementById('btn-simpan-slot-text');

            /* Form Garis */
            const formCardLine = document.getElementById('form-card-line');
            const inputKoordLine = document.getElementById('koordinat_line_input');
            const btnSimpanLine = document.getElementById('btn-simpan-line');
            const btnTextLine = document.getElementById('btn-simpan-line-text');

            /* Mode buttons */
            const btnModeSlot = document.getElementById('btn-mode-slot');
            const btnModeLine = document.getElementById('btn-mode-line');

            /* ═══════════════════════════════════════
               STATE
            ═══════════════════════════════════════ */
            let currentMode = 'slot'; // 'slot' | 'line'
            let pointsSlot = [];
            let closedSlot = false;
            let pointsLine = []; // max 2 titik
            let hoveredSlot = null;
            let hoveredLine = null;

            /* ═══════════════════════════════════════
               1. SYNC CANVAS SIZE
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
               2. MODE SWITCHING
            ═══════════════════════════════════════ */
            window.setMode = function(mode) {
                currentMode = mode;

                btnModeSlot.classList.toggle('mode-btn-active', mode === 'slot');
                btnModeLine.classList.toggle('mode-btn-active', mode === 'line');

                formCardSlot.style.display = (mode === 'slot') ? '' : 'none';
                formCardLine.style.display = (mode === 'line') ? '' : 'none';

                canvasHint.textContent = (mode === 'slot') ?
                    'Mode Slot: klik untuk titik, double-click untuk menutup poligon' :
                    'Mode Garis: klik 2 titik di canvas (titik awal & akhir)';

                updateCounter();
                updateSaveButtons();
                redraw();
            };

            /* ═══════════════════════════════════════
               3. KLIK — koordinat akurat, per-mode
            ═══════════════════════════════════════ */
            canvas.addEventListener('click', function(e) {
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;
                const x = Math.round((e.clientX - rect.left) * scaleX);
                const y = Math.round((e.clientY - rect.top) * scaleY);
                if (x < 0 || x > canvas.width || y < 0 || y > canvas.height) return;

                if (currentMode === 'slot') {
                    if (closedSlot) return;
                    pointsSlot.push({
                        x,
                        y
                    });
                } else {
                    /* Mode garis: maksimal 2 titik. Klik ke-3 reset & mulai ulang. */
                    if (pointsLine.length >= 2) {
                        pointsLine = [{
                            x,
                            y
                        }];
                    } else {
                        pointsLine.push({
                            x,
                            y
                        });
                    }
                }

                updateInput();
                updateCounter();
                updateSaveButtons();
                redraw();
            });

            /* Double-click: tutup poligon (hanya berlaku di mode slot) */
            canvas.addEventListener('dblclick', function() {
                if (currentMode !== 'slot') return;
                if (pointsSlot.length >= 3) {
                    closedSlot = true;
                    updateInput();
                    updateSaveButtons();
                    redraw();
                }
            });

            /* ═══════════════════════════════════════
               4. REDRAW — saved slots + saved lines + current drawing
            ═══════════════════════════════════════ */
            function redraw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                const dotR = Math.max(5, canvas.width * 0.006);
                const lw = Math.max(2, canvas.width * 0.003);
                const fs = Math.max(12, canvas.width * 0.014);

                /* ── Saved SLOTS (hijau) ── */
                (SAVED_SLOTS || []).forEach(function(slot) {
                    if (!slot.coords || slot.coords.length < 2) return;
                    const isHover = (hoveredSlot === String(slot.id));

                    ctx.beginPath();
                    ctx.moveTo(slot.coords[0].x, slot.coords[0].y);
                    for (let i = 1; i < slot.coords.length; i++) ctx.lineTo(slot.coords[i].x, slot.coords[i].y);
                    ctx.closePath();

                    ctx.fillStyle = isHover ? 'rgba(22,163,74,.35)' : 'rgba(22,163,74,.18)';
                    ctx.fill();
                    ctx.lineWidth = isHover ? lw * 1.8 : lw;
                    ctx.strokeStyle = isHover ? '#16A34A' : '#22C55E';
                    ctx.setLineDash([]);
                    ctx.stroke();

                    const cx = slot.coords.reduce((s, p) => s + p.x, 0) / slot.coords.length;
                    const cy = slot.coords.reduce((s, p) => s + p.y, 0) / slot.coords.length;
                    drawLabelPill(cx, cy, slot.nama, isHover ? '#15803D' : '#16A34A', fs);
                });

                /* ── Saved LINES (magenta) ── */
                (SAVED_LINES || []).forEach(function(line) {
                    if (!line.coords || line.coords.length < 2) return;
                    const isHover = (hoveredLine === String(line.id));
                    const pts = line.coords;

                    drawArrowLine(pts[0], pts[1], isHover ? '#9D174D' : '#DB2777', isHover ? lw * 2.2 : lw *
                        1.6, dotR);

                    const mx = (pts[0].x + pts[1].x) / 2;
                    const my = (pts[0].y + pts[1].y) / 2;
                    drawLabelPill(mx, my - fs * 1.6, line.nama, isHover ? '#9D174D' : '#DB2777', fs);
                });

                /* ── Sedang digambar: SLOT ── */
                if (currentMode === 'slot' && pointsSlot.length > 0) {
                    ctx.beginPath();
                    ctx.moveTo(pointsSlot[0].x, pointsSlot[0].y);
                    for (let i = 1; i < pointsSlot.length; i++) ctx.lineTo(pointsSlot[i].x, pointsSlot[i].y);
                    if (closedSlot) ctx.closePath();

                    ctx.fillStyle = closedSlot ? 'rgba(37,99,235,.25)' : 'rgba(37,99,235,.10)';
                    ctx.fill();
                    ctx.lineWidth = lw;
                    ctx.strokeStyle = closedSlot ? '#2563EB' : '#60A5FA';
                    ctx.setLineDash(closedSlot ? [] : [8, 4]);
                    ctx.stroke();
                    ctx.setLineDash([]);

                    pointsSlot.forEach(function(p, i) {
                        drawPointDot(p, i === 0 ? '#16A34A' : '#DC2626', dotR, lw);
                        drawPointNumber(p, i + 1, fs);
                    });
                }

                /* ── Sedang digambar: GARIS ── */
                if (currentMode === 'line' && pointsLine.length > 0) {
                    if (pointsLine.length === 2) {
                        drawArrowLine(pointsLine[0], pointsLine[1], '#DB2777', lw * 1.8, dotR, true);
                    } else {
                        /* hanya 1 titik: tampilkan titik saja */
                        drawPointDot(pointsLine[0], '#DB2777', dotR, lw);
                    }
                }
            }

            /* ── Helper: titik bulat ── */
            function drawPointDot(p, color, dotR, lw) {
                ctx.beginPath();
                ctx.arc(p.x, p.y, dotR, 0, 2 * Math.PI);
                ctx.fillStyle = color;
                ctx.fill();
                ctx.strokeStyle = '#fff';
                ctx.lineWidth = Math.max(1.5, lw * 0.8);
                ctx.stroke();
            }

            /* ── Helper: angka di titik ── */
            function drawPointNumber(p, num, fs) {
                ctx.font = `bold ${fs}px sans-serif`;
                ctx.fillStyle = '#fff';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(num, p.x, p.y);
            }

            /* ── Helper: garis dengan anak panah di ujung (untuk traffic flow) ── */
            function drawArrowLine(p1, p2, color, lw, dotR, isDashed) {
                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(p2.x, p2.y);
                ctx.lineWidth = lw;
                ctx.strokeStyle = color;
                if (isDashed) ctx.setLineDash([10, 5]);
                else ctx.setLineDash([]);
                ctx.stroke();
                ctx.setLineDash([]);

                /* Titik di kedua ujung */
                [p1, p2].forEach(function(p, i) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, dotR * 1.1, 0, 2 * Math.PI);
                    ctx.fillStyle = i === 0 ? '#16A34A' : color; /* titik awal hijau, akhir warna garis */
                    ctx.fill();
                    ctx.strokeStyle = '#fff';
                    ctx.lineWidth = 2;
                    ctx.stroke();
                });

                /* Anak panah di ujung akhir, menunjukkan arah flow */
                const angle = Math.atan2(p2.y - p1.y, p2.x - p1.x);
                const headLen = Math.max(10, lw * 4);
                ctx.beginPath();
                ctx.moveTo(p2.x, p2.y);
                ctx.lineTo(p2.x - headLen * Math.cos(angle - Math.PI / 7), p2.y - headLen * Math.sin(angle - Math.PI /
                    7));
                ctx.lineTo(p2.x - headLen * Math.cos(angle + Math.PI / 7), p2.y - headLen * Math.sin(angle + Math.PI /
                    7));
                ctx.closePath();
                ctx.fillStyle = color;
                ctx.fill();
            }

            /* ── Helper: label pill (nama slot/garis) ── */
            function drawLabelPill(cx, cy, text, bgColor, fs) {
                ctx.font = `bold ${fs}px sans-serif`;
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                const tw = ctx.measureText(text).width;
                const ph = fs * 0.45,
                    pw = fs * 0.6;

                ctx.fillStyle = bgColor;
                roundRect(ctx, cx - tw / 2 - pw, cy - fs / 2 - ph, tw + pw * 2, fs + ph * 2, fs * 0.4);
                ctx.fill();

                ctx.fillStyle = '#fff';
                ctx.fillText(text, cx, cy);
            }

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
               5. STATE HELPERS
            ═══════════════════════════════════════ */
            function updateInput() {
                if (currentMode === 'slot') {
                    inputKoordSlot.value = pointsSlot.length > 0 ? JSON.stringify(pointsSlot) : '';
                } else {
                    inputKoordLine.value = pointsLine.length === 2 ? JSON.stringify(pointsLine) : '';
                }
            }

            function updateCounter() {
                if (!counter) return;
                const len = currentMode === 'slot' ? pointsSlot.length : pointsLine.length;
                counter.style.display = len > 0 ? 'inline-flex' : 'none';
                if (countNum) countNum.textContent = len;
            }

            function updateSaveButtons() {
                /* Tombol Slot */
                const hasCoordsSlot = pointsSlot.length >= 3 && closedSlot;
                btnSimpanSlot.disabled = !hasCoordsSlot;
                btnSimpanSlot.classList.toggle('ready', hasCoordsSlot);
                btnTextSlot.textContent = hasCoordsSlot ? 'Simpan Slot' : 'Gambar poligon terlebih dahulu';

                /* Tombol Garis */
                const hasCoordsLine = pointsLine.length === 2;
                btnSimpanLine.disabled = !hasCoordsLine;
                btnSimpanLine.classList.toggle('ready', hasCoordsLine);
                btnTextLine.textContent = hasCoordsLine ? 'Simpan Garis Traffic' : 'Klik 2 titik di canvas';
            }

            /* Reset — hanya membersihkan mode yang sedang aktif */
            window.clearCanvas = function() {
                if (currentMode === 'slot') {
                    pointsSlot = [];
                    closedSlot = false;
                } else {
                    pointsLine = [];
                }
                updateInput();
                updateCounter();
                updateSaveButtons();
                redraw();
            };

            /* ═══════════════════════════════════════
               6. HOVER HIGHLIGHT — slot & line
            ═══════════════════════════════════════ */
            window.highlightSlot = function(id) {
                hoveredSlot = String(id);
                redraw();
                document.querySelectorAll('.roi-list-item-alt[onmouseenter*="highlightSlot"]').forEach(function(
                    el) {
                    const m = el.getAttribute('onmouseenter').match(/'([^']+)'/);
                    el.classList.toggle('highlighted', m && m[1] === String(id));
                });
            };
            window.unhighlightSlot = function() {
                hoveredSlot = null;
                redraw();
                document.querySelectorAll('.roi-list-item-alt[onmouseenter*="highlightSlot"]').forEach(function(
                    el) {
                    el.classList.remove('highlighted');
                });
            };

            window.highlightLine = function(id) {
                hoveredLine = String(id);
                redraw();
                document.querySelectorAll('.roi-list-item-alt[onmouseenter*="highlightLine"]').forEach(function(
                    el) {
                    const m = el.getAttribute('onmouseenter').match(/'([^']+)'/);
                    el.classList.toggle('highlighted', m && m[1] === String(id));
                });
            };
            window.unhighlightLine = function() {
                hoveredLine = null;
                redraw();
                document.querySelectorAll('.roi-list-item-alt[onmouseenter*="highlightLine"]').forEach(function(
                    el) {
                    el.classList.remove('highlighted');
                });
            };

            /* Init awal */
            updateSaveButtons();

        })();

        function changeKamera(idKamera) {
            if (idKamera) window.location.href = "{{ route('roi.index') }}?kamera_id=" + idKamera;
        }
    </script>
</x-app-layout>
