<x-app-layout>
    <x-slot name="header">Konfigurasi RoI — {{ $kamera->nama_kamera }}</x-slot>

    <div class="roi-page">
        {{-- Page header --}}
        <div class="roi-header">
            <div>
                <h1 class="roi-title">Konfigurasi Area Tinjauan</h1>
                <p class="roi-sub">Tentukan Region of Interest (RoI) dan buat slot parkir untuk kamera CCTV ini.</p>
            </div>
        </div>

        <div class="roi-container">
            {{-- KOLOM KIRI: CANVAS MENGGAMBAR --}}
            <div class="roi-left">
                <div class="card roi-card">
                    <div class="roi-card-header">
                        <div class="roi-card-icon">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title">Area Tinjauan</h2>
                            <p class="roi-card-sub">Klik pada gambar untuk membuat poligon slot parkir</p>
                        </div>
                    </div>

                    <div class="canvas-wrapper">
                        <img id="camera-frame" src="{{ asset('snapshots/kamera_' . $kamera->id_kamera . '.jpg') }}"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/640x480.png?text=Snapshot+Kamera+Belum+Tersedia';"
                            alt="CCTV Frame" class="canvas-img">
                        <canvas id="roi-canvas" width="640" height="480" class="canvas-overlay"></canvas>
                    </div>

                    <div class="roi-actions">
                        <button type="button" onclick="clearCanvas()" class="btn-reset">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </button>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM & LIST SLOT --}}
            <div class="roi-right">
                {{-- Form Simpan RoI --}}
                <div class="card roi-card">
                    <div class="roi-card-header">
                        <div class="roi-card-icon roi-card-icon-accent">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title">Tambah Slot Parkir</h2>
                            <p class="roi-card-sub">Simpan koordinat poligon yang telah digambar</p>
                        </div>
                    </div>

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

                    <form action="{{ route('kamera.roi.store', $kamera->id_kamera) }}" method="POST" class="roi-form">
                        @csrf
                        <div class="field-group">
                            <label class="field-label">Nama Slot <span class="field-required">*</span></label>
                            <input type="text" name="nama_slot" class="field-input" placeholder="Contoh: A1"
                                required>
                            <p class="field-hint">Gunakan nama unik untuk identifikasi slot parkir.</p>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Titik Koordinat (JSON) <span
                                    class="field-required">*</span></label>
                            <textarea id="koordinat_input" name="koordinat_roi" rows="3" class="field-input field-textarea" readonly required
                                placeholder="Gambar di canvas untuk mengisi ini..."></textarea>
                            <p class="field-hint">Koordinat otomatis terisi saat Anda menggambar pada canvas.</p>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Slot
                        </button>
                    </form>
                </div>

                {{-- List Slot yang sudah ada --}}
                <div class="card roi-card">
                    <div class="roi-card-header">
                        <div class="roi-card-icon roi-card-icon-blue">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title">Slot Terdaftar</h2>
                            <p class="roi-card-sub">Daftar slot parkir yang telah dikonfigurasi</p>
                        </div>
                    </div>

                    <div class="roi-list">
                        @foreach ($slots as $slot)
                            <div class="roi-list-item">
                                <span class="slot-name">{{ $slot->nama_slot }}</span>
                                <span class="slot-badge">Tersimpan</span>
                            </div>
                        @endforeach
                        @if ($slots->isEmpty())
                            <div class="roi-empty">
                                <p>Belum ada slot yang terdaftar.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.form-styles')

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
            --font-mono: 'DM Mono', monospace;
            --radius-md: 10px;
            --radius-lg: 14px;
            --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* ROI Page */
        .roi-page {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .roi-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .roi-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .roi-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* ROI Container */
        .roi-container {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            align-items: start;
        }

        .roi-left,
        .roi-right {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .roi-right {
            max-height: calc(100vh - 280px);
            overflow-y: auto;
            padding-right: 4px;
        }

        .roi-right::-webkit-scrollbar {
            width: 6px;
        }

        .roi-right::-webkit-scrollbar-track {
            background: transparent;
        }

        .roi-right::-webkit-scrollbar-thumb {
            background: #D9D6D0;
            border-radius: 3px;
        }

        .roi-right::-webkit-scrollbar-thumb:hover {
            background: #C9C6C0;
        }

        /* Card */
        .card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .roi-card {
            padding: 20px 22px;
        }

        .roi-card-header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-soft);
        }

        .roi-card-icon {
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

        .roi-card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .roi-card-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* Canvas */
        .canvas-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            background: var(--bg-base);
            cursor: crosshair;
        }

        .canvas-img {
            display: block;
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
        }

        .canvas-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* ROI Actions */
        .roi-actions {
            display: flex;
            gap: 8px;
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            color: #DC2626;
            background: transparent;
            border: 1px solid #FECACA;
            cursor: pointer;
            transition: all var(--transition);
        }

        .btn-reset:hover {
            background: #FEF2F2;
            border-color: #FCA5A5;
        }

        /* ROI Form */
        .roi-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field-textarea {
            font-family: var(--font-mono);
            font-size: 12px;
            resize: none;
            background: var(--bg-base);
            color: var(--text-secondary);
        }

        /* ROI List */
        .roi-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .roi-list-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-soft);
        }

        .roi-list-item:last-child {
            border-bottom: none;
        }

        .slot-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .slot-badge {
            font-size: 11px;
            font-weight: 600;
            color: #15803D;
            background: #DCFCE7;
            padding: 2px 8px;
            border-radius: 99px;
            white-space: nowrap;
        }

        .roi-empty {
            padding: 16px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .roi-container {
                grid-template-columns: 1fr;
            }

            .roi-right {
                max-height: none;
                overflow-y: visible;
            }
        }

        @media (max-width: 720px) {
            .roi-card {
                padding: 16px 18px;
            }

            .roi-card-header {
                margin-bottom: 16px;
                padding-bottom: 12px;
                gap: 10px;
            }

            .roi-card-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .roi-card-title {
                font-size: 14px;
            }

            .roi-card-sub {
                font-size: 12px;
            }
        }
    </style>

    <!-- JAVASCRIPT UNTUK MENGGAMBAR POLIGON -->
    <script>
        const canvas = document.getElementById('roi-canvas');
        const ctx = canvas.getContext('2d');
        const inputKoordinat = document.getElementById('koordinat_input');

        let points = []; // Array untuk menyimpan titik [x, y]

        canvas.addEventListener('click', function(event) {
            // Mengambil posisi klik relatif terhadap canvas
            const rect = canvas.getBoundingClientRect();
            const x = Math.round(event.clientX - rect.left);
            const y = Math.round(event.clientY - rect.top);

            points.push({
                x: x,
                y: y
            });
            drawPolygon();
        });

        function drawPolygon() {
            ctx.clearRect(0, 0, canvas.width, canvas.height); // Bersihkan canvas

            if (points.length > 0) {
                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);

                // Gambar garis antar titik
                for (let i = 1; i < points.length; i++) {
                    ctx.lineTo(points[i].x, points[i].y);
                }

                // Tutup poligon dengan garis ke titik awal
                ctx.closePath();

                // Styling poligon (Warna isi dan garis)
                ctx.fillStyle = "rgba(59, 130, 246, 0.4)"; // Biru transparan
                ctx.fill();
                ctx.lineWidth = 2;
                ctx.strokeStyle = "#2563EB"; // Biru tua
                ctx.stroke();

                // Gambar lingkaran kecil (vertex) di setiap titik
                points.forEach(point => {
                    ctx.beginPath();
                    ctx.arc(point.x, point.y, 4, 0, 2 * Math.PI);
                    ctx.fillStyle = "red";
                    ctx.fill();
                });
            }

            // Update textarea dengan format JSON
            inputKoordinat.value = JSON.stringify(points);
        }

        function clearCanvas() {
            points = [];
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            inputKoordinat.value = "";
        }
    </script>
</x-app-layout>
