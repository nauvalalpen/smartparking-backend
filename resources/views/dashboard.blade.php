<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SmartParking Control Center') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- WIDGET STATISTIK (3 KARTU) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Kartu 1: Sisa Slot -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Sisa Slot Parkir</div>
                        <div class="mt-2 flex items-baseline gap-2">
                            <div class="text-4xl font-extrabold text-gray-900">{{ $sisa_slot }}</div>
                            <div class="text-sm text-gray-500">dari {{ $total_slot }} total slot</div>
                        </div>
                    </div>
                </div>

                <!-- Kartu 2: Kendaraan Masuk Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Kendaraan Masuk (Hari
                            Ini)</div>
                        <div class="mt-2 text-4xl font-extrabold text-gray-900">
                            {{ end($data_masuk) ?? 0 }}
                        </div>
                    </div>
                </div>

                <!-- Kartu 3: Kamera Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="text-gray-500 text-sm font-medium uppercase tracking-wide">Kamera CCTV Aktif</div>
                        <div class="mt-2 text-4xl font-extrabold text-gray-900">
                            {{ $total_kamera }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- GRAFIK TRAFFIC FLOW -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Arus Lalu Lintas (7 Hari Terakhir)</h3>
                    <!-- Canvas untuk Chart.js -->
                    <div class="relative h-96 w-full">
                        <canvas id="trafficChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SCRIPT CHART.JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('trafficChart').getContext('2d');

            // Mengambil data dari PHP (Controller) ke Javascript
            const labels = {!! json_encode($labels) !!};
            const dataMasuk = {!! json_encode($data_masuk) !!};
            const dataKeluar = {!! json_encode($data_keluar) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Kendaraan Masuk',
                            data: dataMasuk,
                            borderColor: 'rgba(59, 130, 246, 1)', // Blue-500
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3 // Membuat garis melengkung (smooth)
                        },
                        {
                            label: 'Kendaraan Keluar',
                            data: dataKeluar,
                            borderColor: 'rgba(239, 68, 68, 1)', // Red-500
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
