<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfigurasi RoI - ') }} <span class="text-blue-600">{{ $kamera->nama_kamera }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-6">

                <!-- BAGIAN KIRI: CANVAS VIDEO -->
                <div class="w-full lg:w-2/3 bg-white shadow-sm sm:rounded-lg p-4">
                    <h3 class="font-bold text-gray-700 mb-2">Layar CCTV (Klik untuk menggambar poligon)</h3>
                    <p class="text-sm text-gray-500 mb-4">Klik minimal 4 titik, lalu klik "Simpan Slot". Klik "Reset"
                        jika salah.</p>

                    <!-- Kotak Canvas -->
                    <div class="relative bg-gray-200 border-2 border-dashed border-gray-400 rounded cursor-crosshair overflow-hidden"
                        style="width: 100%; max-width: 800px;">
                        <canvas id="roiCanvas" width="800" height="450" class="w-full h-auto"></canvas>
                    </div>

                    <div class="mt-4">
                        <button onclick="clearCanvas()"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Reset Gambar
                        </button>
                    </div>
                </div>

                <!-- BAGIAN KANAN: FORM & LIST SLOT -->
                <div class="w-full lg:w-1/3 flex flex-col gap-6">

                    <!-- Form Simpan -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-gray-700 mb-4">Simpan Slot Baru</h3>
                        <form action="{{ route('roi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_kamera" value="{{ $kamera->id_kamera }}">

                            <!-- Input tersembunyi untuk menyimpan array JSON dari Javascript -->
                            <input type="hidden" name="koordinat_roi" id="koordinat_input" required>

                            <div class="mb-4">
                                <label class="block text-sm font-bold mb-2">Nama Slot (Misal: A1)</label>
                                <input type="text" name="nama_slot" class="shadow border rounded w-full py-2 px-3"
                                    required>
                            </div>

                            <button type="submit" id="btnSimpan"
                                class="w-full bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed"
                                disabled>
                                Simpan Slot
                            </button>
                        </form>
                    </div>

                    <!-- Daftar Slot yang sudah ada -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-gray-700 mb-4">Slot Tedaftar di Kamera Ini</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse($slots as $slot)
                                <li class="py-2 flex justify-between">
                                    <span class="font-semibold">{{ $slot->nama_slot }}</span>
                                    <span
                                        class="text-xs text-gray-500 border px-2 py-1 rounded">{{ $slot->status }}</span>
                                </li>
                            @empty
                                <li class="text-gray-500 text-sm">Belum ada slot dikonfigurasi.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT UNTUK MENGGAMBAR DI CANVAS -->
    <script>
        const canvas = document.getElementById('roiCanvas');
        const ctx = canvas.getContext('2d');
        const inputKoordinat = document.getElementById('koordinat_input');
        const btnSimpan = document.getElementById('btnSimpan');

        let points = [];
        let bgImg = new Image();

        // Menggunakan gambar placeholder parkiran sebagai simulasi CCTV
        bgImg.src = 'https://images.unsplash.com/photo-1506521781263-d8422e82f27a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'
        ;

        bgImg.onload = function() {
            redraw();
        };

        // Fungsi ketika mouse diklik di atas gambar
        canvas.addEventListener('mousedown', function(e) {
            const rect = canvas.getBoundingClientRect();
            // Kalkulasi skala jika layar di-resize
            const scaleX = canvas.width / rect.width;
            const scaleY = canvas.height / rect.height;

            const x = Math.round((e.clientX - rect.left) * scaleX);
            const y = Math.round((e.clientY - rect.top) * scaleY);

            points.push({
                x: x,
                y: y
            });

            // Simpan ke input hidden sebagai JSON
            inputKoordinat.value = JSON.stringify(points);

            // Aktifkan tombol simpan jika titik >= 4 (Bentuk kotak)
            if (points.length >= 4) {
                btnSimpan.disabled = false;
                btnSimpan.classList.remove('opacity-50', 'cursor-not-allowed');
            }

            redraw();
        });

        // Fungsi untuk menggambar ulang gambar dan garis poligon
        function redraw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(bgImg, 0, 0, canvas.width, canvas.height);

            if (points.length > 0) {
                ctx.beginPath();
                ctx.moveTo(points[0].x, points[0].y);

                for (let i = 1; i < points.length; i++) {
                    ctx.lineTo(points[i].x, points[i].y);
                }

                // Jika titik >= 3, tutup poligonnya agar jadi bidang
                if (points.length >= 3) {
                    ctx.closePath();
                    ctx.fillStyle = 'rgba(0, 255, 0, 0.3)'; // Warna hijau transparan
                    ctx.fill();
                }

                ctx.lineWidth = 3;
                ctx.strokeStyle = '#00FF00'; // Garis hijau terang
                ctx.stroke();

                // Gambar titik (dot) merah di setiap ujung
                points.forEach(p => {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, 5, 0, 2 * Math.PI);
                    ctx.fillStyle = 'red';
                    ctx.fill();
                });
            }
        }

        // Fungsi untuk menghapus gambar jika salah klik
        function clearCanvas() {
            points =
