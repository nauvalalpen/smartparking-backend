<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- DROPDOWN PILIH KAMERA -->
            <div class="bg-white shadow-sm sm:rounded-lg p-4 border border-gray-200 flex items-center gap-4">
                <label class="font-bold text-gray-700">Pilih Kamera:</label>
                <select id="kameraSelector" onchange="changeKamera(this.value)"
                    class="shadow-sm border-gray-300 rounded-md w-full md:w-1/2 py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                    @if ($kameras->isEmpty())
                        <option value="">-- Belum ada kamera aktif --</option>
                    @else
                        @foreach ($kameras as $kam)
                            <option value="{{ $kam->id_kamera }}"
                                {{ $selectedKamera && $selectedKamera->id_kamera == $kam->id_kamera ? 'selected' : '' }}>
                                {{ $kam->nama_kamera }} - {{ $kam->rtsp_url }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="flex flex-col md:flex-row gap-6">
                <!-- KOLOM KIRI: CANVAS MENGGAMBAR -->
                <div class="w-full md:w-2/3 bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">Area Parkiran (Video Frame)</h3>

                    <div
                        class="relative inline-block bg-gray-900 rounded-lg overflow-hidden flex items-center justify-center min-h-[400px] w-full">
                        @if ($selectedKamera)
                            <!-- Gambar Real Kamera -->
                            <img id="camera-frame"
                                src="{{ asset('snapshots/kamera_' . $selectedKamera->id_kamera . '.jpg') }}"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/640x480.png?text=Feed+Kamera+CCTV';"
                                class="w-full h-full object-cover">
                            <!-- Canvas Transparan -->
                            <canvas id="roi-canvas" width="640" height="480"
                                class="absolute top-0 left-0 w-full h-full cursor-crosshair"></canvas>
                        @else
                            <div class="text-center text-gray-500">
                                <p>Silakan pilih kamera terlebih dahulu</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <button class="bg-red-600 text-white font-bold py-2 px-6 rounded shadow">Slot Parkir</button>
                        <button type="button" onclick="clearCanvas()"
                            class="text-gray-500 hover:text-red-500 text-sm font-bold underline">Reset Canvas</button>
                    </div>
                </div>

                <!-- KOLOM KANAN: FORM & LIST -->
                <div class="w-full md:w-1/3 flex flex-col gap-6">

                    <!-- Form Simpan -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-sm font-bold text-gray-800 mb-4">Simpan Slot Parkir</h3>
                        <form action="{{ route('roi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_kamera" value="{{ $selectedKamera->id_kamera ?? '' }}">

                            <div class="mb-4">
                                <label class="block text-gray-600 text-xs font-bold mb-2">Nama Slot Parkir</label>
                                <input type="text" name="nama_slot"
                                    class="border-gray-300 rounded-md w-full focus:ring-blue-500"
                                    placeholder="Masukkan nama slot parkir" required>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-600 text-xs font-bold mb-2">Koordinat
                                    (x1,y1,x2,y2,x3,y3,x4,y4)</label>
                                <textarea id="koordinat_input" name="koordinat_roi" rows="4"
                                    class="border-gray-300 rounded-md w-full bg-white focus:ring-blue-500" readonly required
                                    placeholder="Ex: (100,100,200,100...)"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-md shadow">
                                Simpan ke Database
                            </button>
                        </form>
                    </div>

                    <!-- List Tersimpan -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200">
                        <h3 class="text-sm font-bold text-gray-800 mb-4">Slot Parkir Tersimpan</h3>
                        <ul class="divide-y divide-gray-100">
                            @forelse($slots as $slot)
                                <li class="py-3 flex justify-between items-center">
                                    <span class="text-gray-700 font-medium">{{ $slot->nama_slot }}</span>
                                    <span class="text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded">RoI
                                        disimpan</span>
                                </li>
                            @empty
                                <p class="text-xs text-gray-400">Belum ada slot tersimpan untuk kamera ini.</p>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT CANVAS & DROPDOWN -->
    <script>
        // Fungsi Dropdown
        function changeKamera(idKamera) {
            if (idKamera) {
                window.location.href = "{{ route('roi.index') }}?kamera_id=" + idKamera;
            }
        }

        // Script Canvas (Sama seperti sebelumnya)
        const canvas = document.getElementById('roi-canvas');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            const inputKoordinat = document.getElementById('koordinat_input');
            let points = [];

            // Sesuaikan ukuran resolusi internal canvas dengan ukuran tampilannya
            const rect = canvas.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;

            canvas.addEventListener('click', function(event) {
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
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                if (points.length > 0) {
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

                    points.forEach(point => {
                        ctx.beginPath();
                        ctx.arc(point.x, point.y, 4, 0, 2 * Math.PI);
                        ctx.fillStyle = "red";
                        ctx.fill();
                    });
                }
                inputKoordinat.value = JSON.stringify(points);
            }

            function clearCanvas() {
                points =
