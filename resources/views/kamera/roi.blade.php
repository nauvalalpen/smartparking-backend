<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfigurasi RoI: {{ $kamera->nama_kamera }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">

            <!-- KOLOM KIRI: CANVAS MENGGAMBAR -->
            <div class="w-full md:w-2/3 bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Area Tinjauan (Video Frame)</h3>
                <p class="text-sm text-gray-500 mb-4">Klik pada gambar untuk membuat titik (vertex) poligon. Klik "Reset"
                    jika salah.</p>

                <div class="relative inline-block border-2 border-gray-300 rounded cursor-crosshair">
                    <img id="camera-frame" src="{{ asset('snapshots/kamera_' . $kamera->id_kamera . '.jpg') }}"
                        onerror="this.onerror=null; this.src='https://via.placeholder.com/640x480.png?text=Snapshot+Kamera+Belum+Tersedia';"
                        alt="CCTV Frame" class="w-[640px] h-[480px] object-cover rounded">
                    <!-- Canvas transparan di atas gambar -->
                    <canvas id="roi-canvas" width="640" height="480"
                        class="absolute top-0 left-0 w-full h-full"></canvas>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="button" onclick="clearCanvas()"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">Reset Gambar</button>
                </div>
            </div>

            <!-- KOLOM KANAN: FORM & LIST SLOT -->
            <div class="w-full md:w-1/3 flex flex-col gap-6">

                <!-- Form Simpan RoI -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-500">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Simpan Slot Parkir</h3>

                    @if (session('success'))
                        <div class="text-green-600 text-sm mb-4">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('kamera.roi.store', $kamera->id_kamera) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Slot (Misal: A1)</label>
                            <input type="text" name="nama_slot"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Titik Koordinat (JSON)</label>
                            <!-- Teks ini otomatis terisi oleh Javascript -->
                            <textarea id="koordinat_input" name="koordinat_roi" rows="3"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700 bg-gray-100" readonly required
                                placeholder="Gambar di canvas untuk mengisi ini..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">Simpan
                            Ke Database</button>
                    </form>
                </div>

                <!-- List Slot yang sudah ada -->
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Slot Parkir Terdaftar</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach ($slots as $slot)
                            <li class="py-2 flex justify-between">
                                <span class="font-semibold text-blue-600">{{ $slot->nama_slot }}</span>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">RoI Disimpan</span>
                            </li>
                        @endforeach
                        @if ($slots->isEmpty())
                            <p class="text-sm text-gray-500">Belum ada slot terdaftar.</p>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>

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
