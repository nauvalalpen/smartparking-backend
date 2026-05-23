<x-app-layout>
    <x-slot name="header">Konfigurasi RoI</x-slot>

    <div class="form-page" style="max-width:none;">

        {{-- Breadcrumb --}}
        <div class="breadcrumb" style="margin-bottom:20px;">
            <a href="{{ route('kamera.index') }}" class="bc-link">Kamera CCTV</a>
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="bc-current">RoI — {{ $kamera->nama_kamera }}</span>
        </div>

        {{-- Page title row --}}
        <div class="page-header" style="margin-bottom:24px;">
            <div>
                <h1 class="page-title">{{ $kamera->nama_kamera }}</h1>
                <p class="page-sub">Klik pada gambar untuk menandai titik poligon slot parkir. Setiap polygon = satu
                    slot.</p>
            </div>
            <div class="roi-status-chip">
                <span class="roi-dot"></span>
                {{ $slots->count() }} Slot Terdaftar
            </div>
        </div>

        {{-- Success toast --}}
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

        {{-- Main two-column layout --}}
        <div class="roi-layout">

            {{-- LEFT — Canvas --}}
            <div class="roi-canvas-card">
                <div class="roi-canvas-header">
                    <div class="roi-canvas-title">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 20v-4m0 4h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                        </svg>
                        Frame Kamera
                    </div>
                    <div class="roi-canvas-actions">
                        <div class="roi-point-counter" id="point-counter">0 titik</div>
                        <button type="button" onclick="clearCanvas()" class="btn-ghost-sm">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4l16 16M4 20L20 4" />
                            </svg>
                            Reset Gambar
                        </button>
                    </div>
                </div>

                <div class="canvas-wrapper">
                    <img id="camera-frame" src="{{ asset('snapshots/kamera_' . $kamera->id_kamera . '.jpg') }}"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/800x480/1A1916/6B6860?text=Snapshot+belum+tersedia';"
                        alt="CCTV Frame" class="canvas-img">
                    <canvas id="roi-canvas" class="canvas-overlay"></canvas>
                </div>

                <div class="canvas-hint">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Klik di atas gambar untuk menambah titik poligon. Minimal 3 titik untuk membentuk area slot.
                </div>
            </div>

            {{-- RIGHT — Form + Slot list --}}
            <div class="roi-right-panel">

                {{-- Save form --}}
                <div class="form-card" style="padding:24px;">
                    <div class="form-card-header"
                        style="margin-bottom:20px; padding-bottom:16px; border-bottom: 1px solid var(--border-soft);">
                        <div class="form-card-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="form-card-title" style="font-size:14px;">Simpan Slot Parkir</h3>
                            <p class="form-card-sub" style="font-size:12px;">Gambar polygon, lalu beri nama slot.</p>
                        </div>
                    </div>

                    <form action="{{ route('kamera.roi.store', $kamera->id_kamera) }}" method="POST" class="sp-form"
                        style="gap:14px;">
                        @csrf

                        <div class="field-group">
                            <label class="field-label">Nama Slot <span class="field-required">*</span></label>
                            <input type="text" name="nama_slot" class="field-input"
                                placeholder="Contoh: A1, B3, VIP-01" required maxlength="20">
                            <p class="field-hint">Kode pendek unik untuk slot ini.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Koordinat Poligon</label>
                            <textarea id="koordinat_input" name="koordinat_roi" rows="3" class="field-input field-mono"
                                style="resize:none; background:var(--bg-base); font-size:11px;" readonly required
                                placeholder="Gambar di canvas untuk mengisi ini..."></textarea>
                        </div>

                        <button type="submit" class="btn-primary" style="width:100%; justify-content:center;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan ke Database
                        </button>
                    </form>
                </div>

                {{-- Slot list --}}
                <div class="form-card" style="padding:24px; flex:1;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;">
                        <h3 style="font-size:14px; font-weight:600; color:var(--text-primary);">Slot Terdaftar</h3>
                        <span class="badge-blue">{{ $slots->count() }}</span>
                    </div>

                    @if ($slots->isEmpty())
                        <div style="text-align:center; padding:28px 0; color:var(--text-muted);">
                            <svg width="28" height="28" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5"
                                style="margin:0 auto 8px; display:block; color:var(--border);">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 20v-4m0 4h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                            </svg>
                            <p style="font-size:13px;">Belum ada slot.</p>
                            <p style="font-size:12px; margin-top:2px;">Gambar dan simpan polygon pertama Anda.</p>
                        </div>
                    @else
                        <div class="slot-list">
                            @foreach ($slots as $slot)
                                <div class="slot-item">
                                    <div class="slot-left">
                                        <div class="slot-dot"></div>
                                        <span class="slot-name">{{ $slot->nama_slot }}</span>
                                    </div>
                                    <span class="slot-badge">RoI ✓</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    @include('layouts.form-styles')

    <style>
        .roi-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        .roi-canvas-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .roi-canvas-header {
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-soft);
        }

        .roi-canvas-title {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .roi-canvas-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .roi-point-counter {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text-muted);
            background: var(--bg-base);
            padding: 3px 8px;
            border-radius: 99px;
            border: 1px solid var(--border);
        }

        .canvas-wrapper {
            position: relative;
            line-height: 0;
        }

        .canvas-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        .canvas-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: crosshair;
        }

        .canvas-hint {
            padding: 10px 18px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-soft);
            background: var(--bg-base);
        }

        .roi-right-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .roi-status-chip {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 14px;
            border-radius: 99px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .roi-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22C55E;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        }

        .slot-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .slot-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            background: var(--bg-base);
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-soft);
        }

        .slot-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .slot-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            flex-shrink: 0;
        }

        .slot-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            font-family: var(--font-mono);
        }

        .slot-badge {
            font-size: 10px;
            font-weight: 600;
            color: #15803D;
            background: #DCFCE7;
            padding: 2px 7px;
            border-radius: 99px;
        }

        .badge-blue {
            font-size: 11px;
            font-weight: 600;
            color: #1D4ED8;
            background: #DBEAFE;
            padding: 2px 8px;
            border-radius: 99px;
        }

        @media (max-width: 900px) {
            .roi-layout {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        const canvas = document.getElementById('roi-canvas');
        const ctx = canvas.getContext('2d');
        const img = document.getElementById('camera-frame');
        const input = document.getElementById('koordinat_input');
        const counter = document.getElementById('point-counter');
        let points = [];

        // Sync canvas size to rendered image
        function syncCanvas() {
            canvas.width = img.offsetWidth;
            canvas.height = img.offsetHeight;
            drawPolygon();
        }
        img.addEventListener('load', syncCanvas);
        window.addEventListener('resize', syncCanvas);
        if (img.complete) syncCanvas();

        canvas.addEventListener('click', function(e) {
            const r = canvas.getBoundingClientRect();
            const scaleX = canvas.width / r.width;
            const scaleY = canvas.height / r.height;
            points.push({
                x: Math.round((e.clientX - r.left) * scaleX),
                y: Math.round((e.clientY - r.top) * scaleY)
            });
            drawPolygon();
        });

        function drawPolygon() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            if (points.length === 0) {
                counter.textContent = '0 titik';
                input.value = '';
                return;
            }

            // Fill
            ctx.beginPath();
            ctx.moveTo(points[0].x, points[0].y);
            for (let i = 1; i < points.length; i++) ctx.lineTo(points[i].x, points[i].y);
            ctx.closePath();
            ctx.fillStyle = 'rgba(217,119,6,0.25)';
            ctx.fill();

            // Stroke
            ctx.lineWidth = 2;
            ctx.strokeStyle = '#D97706';
            ctx.setLineDash([]);
            ctx.stroke();

            // Vertices
            points.forEach((p, i) => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, 5, 0, Math.PI * 2);
                ctx.fillStyle = '#fff';
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = '#D97706';
                ctx.stroke();

                // Label
                ctx.fillStyle = '#1A1916';
                ctx.font = 'bold 10px DM Mono, monospace';
                ctx.fillText(i + 1, p.x + 7, p.y - 5);
            });

            counter.textContent = points.length + ' titik';
            input.value = JSON.stringify(points);
        }

        function clearCanvas() {
            points = [];
            drawPolygon();
        }
    </script>
</x-app-layout>
