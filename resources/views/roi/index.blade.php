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
            {{-- KOLOM KIRI: CANVAS MENGGAMBAR --}}
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
                            <p class="roi-card-sub-alt">Klik pada gambar untuk membuat poligon slot</p>
                        </div>
                    </div>

                    <div class="canvas-wrapper-alt">
                        @if ($selectedKamera)
                            <img id="camera-frame"
                                src="{{ asset('snapshots/kamera_' . $selectedKamera->id_kamera . '.jpg') }}"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/640x480.png?text=Feed+Kamera+CCTV';"
                                class="canvas-img-alt">
                            <canvas id="roi-canvas" width="640" height="480" class="canvas-overlay-alt"></canvas>
                        @else
                            <div class="canvas-placeholder-alt">
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
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM & LIST --}}
            <div class="roi-right-alt">
                {{-- Form Simpan --}}
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
                            <p class="roi-card-sub-alt">Simpan koordinat poligon yang telah digambar</p>
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
                            <textarea id="koordinat_input" name="koordinat_roi" rows="6" class="field-input field-textarea json-editor"
                                readonly required placeholder="Gambar di canvas untuk mengisi ini..."></textarea>
                            <p class="field-hint">Koordinat otomatis terisi saat menggambar pada canvas.</p>
                        </div>

                        <button type="submit" class="btn-primary" style="width: 100%;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Slot
                        </button>
                    </form>
                </div>

                {{-- List Tersimpan --}}
                <div class="card roi-card-alt">
                    <div class="roi-card-header-alt">
                        <div class="roi-card-icon-alt roi-card-icon-blue">
                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="roi-card-title-alt">Slot Terdaftar</h2>
                            <p class="roi-card-sub-alt">Daftar slot yang telah dikonfigurasi</p>
                        </div>
                    </div>

                    <div class="roi-list-alt">
                        @forelse($slots as $slot)
                            <div class="roi-list-item-alt">
                                <div>
                                    <p class="slot-name-alt">{{ $slot->nama_slot }}</p>
                                    <p class="slot-coords-alt">{{ substr($slot->koordinat_roi, 0, 30) }}...</p>
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
                                <p>Belum ada slot terdaftar untuk kamera ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.form-styles')
    @include('layouts.table-styles')

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
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        /* ROI Grid */
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

        .roi-right-alt {
            max-height: calc(100vh - 280px);
            overflow-y: auto;
            padding-right: 4px;
        }

        .roi-right-alt::-webkit-scrollbar {
            width: 6px;
        }

        .roi-right-alt::-webkit-scrollbar-track {
            background: transparent;
        }

        .roi-right-alt::-webkit-scrollbar-thumb {
            background: #D9D6D0;
            border-radius: 3px;
        }

        .roi-right-alt::-webkit-scrollbar-thumb:hover {
            background: #C9C6C0;
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
            display: block;
            width: 100%;
            margin-bottom: 16px;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            overflow: hidden;
            background: var(--bg-base);
        }

        .canvas-img-alt {
            display: block;
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
        }

        .canvas-overlay-alt {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: crosshair;
        }

        .canvas-placeholder-alt {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 400px;
            color: var(--text-muted);
            text-align: center;
            font-size: 14px;
        }

        /* ROI Actions */
        .roi-actions-alt {
            display: flex;
            gap: 8px;
        }

        .btn-reset-alt {
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

        .btn-reset-alt:hover {
            background: #FEF2F2;
            border-color: #FCA5A5;
        }

        /* ROI Form */
        .roi-form-alt {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .field-textarea {
            font-family: 'DM Mono', monospace;
            font-size: 12px;
            resize: none;
            background: var(--bg-base);
            color: var(--text-secondary);
        }

        /* ROI List */
        .roi-list-alt {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .roi-list-item-alt {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--border-soft);
        }

        .roi-list-item-alt:last-child {
            border-bottom: none;
        }

        .slot-name-alt {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .slot-coords-alt {
            font-size: 11px;
            color: var(--text-muted);
            margin: 3px 0 0 0;
            font-family: 'DM Mono', monospace;
        }

        .roi-list-actions-alt {
            display: flex;
            gap: 6px;
        }

        .roi-empty-alt {
            padding: 16px;
            text-align: center;
            color: var(--text-muted);
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .roi-grid-alt {
                grid-template-columns: 1fr;
            }

            .roi-right-alt {
                max-height: none;
                overflow-y: visible;
            }
        }

        @media (max-width: 720px) {
            .camera-selector-inner {
                flex-direction: column;
                align-items: stretch;
            }

            .camera-selector-label {
                width: 100%;
            }

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
        }
    </style>

    <!-- JAVASCRIPT UNTUK MENGGAMBAR POLIGON -->
    <script>
        // Fungsi Dropdown
        function changeKamera(idKamera) {
            if (idKamera) {
                window.location.href = "{{ route('roi.index') }}?kamera_id=" + idKamera;
            }
        }

        // Script Canvas
        const canvas = document.getElementById('roi-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            const inputKoordinat = document.getElementById('koordinat_input');
            const canvasImg = document.getElementById('camera-frame');
            let points = [];

            // Get the image and set canvas dimensions based on image
            if (canvasImg.complete) {
                initCanvas();
            } else {
                canvasImg.onload = initCanvas;
            }

            function initCanvas() {
                // Set canvas size based on container and image
                const container = canvas.parentElement;
                const containerRect = container.getBoundingClientRect();
                const imgRect = canvasImg.getBoundingClientRect();

                // Use image dimensions for canvas resolution
                canvas.width = canvasImg.naturalWidth || 640;
                canvas.height = canvasImg.naturalHeight || 480;

                // Set display size
                canvas.style.width = imgRect.width + 'px';
                canvas.style.height = imgRect.height + 'px';

                redraw();
            }

            canvas.addEventListener('click', function(event) {
                const rect = canvas.getBoundingClientRect();
                const imgRect = document.getElementById('camera-frame').getBoundingClientRect();

                // Calculate position relative to canvas internal resolution
                const x = Math.round((event.clientX - imgRect.left) * (canvas.width / imgRect.width));
                const y = Math.round((event.clientY - imgRect.top) * (canvas.height / imgRect.height));

                // Only add point if within canvas bounds
                if (x >= 0 && x <= canvas.width && y >= 0 && y <= canvas.height) {
                    points.push({
                        x: x,
                        y: y
                    });
                    redraw();
                }
            });

            // Add double-click to close polygon
            canvas.addEventListener('dblclick', function() {
                if (points.length > 2) {
                    updateInputValue();
                }
            });

            function redraw() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                if (points.length > 0) {
                    // Draw polygon
                    ctx.beginPath();
                    ctx.moveTo(points[0].x, points[0].y);
                    for (let i = 1; i < points.length; i++) {
                        ctx.lineTo(points[i].x, points[i].y);
                    }
                    ctx.closePath();
                    ctx.fillStyle = "rgba(37, 99, 235, 0.3)";
                    ctx.fill();
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = "#2563EB";
                    ctx.stroke();

                    // Draw points
                    points.forEach(point => {
                        ctx.beginPath();
                        ctx.arc(point.x, point.y, 4, 0, 2 * Math.PI);
                        ctx.fillStyle = "#DC2626";
                        ctx.fill();
                        ctx.strokeStyle = "#fff";
                        ctx.lineWidth = 2;
                        ctx.stroke();
                    });
                }
            }

            function updateInputValue() {
                if (points.length >= 3) {
                    inputKoordinat.value = JSON.stringify(points);
                } else {
                    inputKoordinat.value = JSON.stringify(points);
                }
            }

            function clearCanvas() {
                points = [];
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                inputKoordinat.value = '';
            }

            // Expose functions to global scope
            window.clearCanvas = clearCanvas;
        }
    </script>
</x-app-layout>
