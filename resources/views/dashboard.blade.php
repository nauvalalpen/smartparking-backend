<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    {{-- Page header --}}
    <div class="dash-header">
        <div>
            <h1 class="dash-title">Control Center</h1>
            <p class="dash-sub">Ringkasan sistem parkir kampus hari ini.</p>
        </div>
        <div class="dash-date" x-data="{ d: '' }" x-init="const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const now = new Date();
        d = days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();" x-text="d"></div>
    </div>

    {{-- STAT CARDS --}}
    <div class="stat-grid">

        {{-- Slot availability --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-label">Sisa Slot Parkir</span>
                <div class="stat-icon stat-icon-green">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $sisa_slot }}</div>
            <div class="stat-meta">
                dari <strong>{{ $total_slot }}</strong> total slot
                @php $pct = $total_slot > 0 ? round(($sisa_slot / $total_slot) * 100) : 0; @endphp
                <span class="stat-pct stat-pct-green">{{ $pct }}% tersedia</span>
            </div>
            <div class="stat-bar-track">
                <div class="stat-bar-fill stat-bar-green" style="width: {{ $pct }}%"></div>
            </div>
        </div>

        {{-- Vehicles in --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-label">Kendaraan Masuk Hari Ini</span>
                <div class="stat-icon stat-icon-amber">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ end($data_masuk) ?: 0 }}</div>
            <div class="stat-meta">kendaraan tercatat masuk</div>
        </div>

        {{-- Active cameras --}}
        <div class="stat-card">
            <div class="stat-card-top">
                <span class="stat-label">Kamera CCTV Aktif</span>
                <div class="stat-icon stat-icon-blue">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $total_kamera }}</div>
            <div class="stat-meta">
                kamera terhubung
                <span class="stat-live">
                    <span class="live-dot"></span> Live
                </span>
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="chart-card">
        <div class="chart-card-header">
            <div>
                <h2 class="chart-title">Arus Lalu Lintas</h2>
                <p class="chart-sub">Kendaraan masuk & keluar — 7 hari terakhir</p>
            </div>
            <div class="chart-legend">
                <span class="legend-item">
                    <span class="legend-dot legend-dot-amber"></span> Masuk
                </span>
                <span class="legend-item">
                    <span class="legend-dot legend-dot-slate"></span> Keluar
                </span>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>

    {{-- STYLES --}}
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
            --font-mono: 'DM Mono', monospace;
            --radius-md: 10px;
            --radius-lg: 14px;
            --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Page header */
        .dash-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 28px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .dash-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .dash-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .dash-date {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted);
            padding: 6px 12px;
            border: 1px solid var(--border);
            border-radius: 99px;
            background: var(--bg-surface);
            white-space: nowrap;
        }

        /* Stat grid */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 20px 22px 18px;
            transition: box-shadow var(--transition), border-color var(--transition);
        }

        .stat-card:hover {
            box-shadow: 0 4px 16px rgba(26, 25, 22, 0.07);
            border-color: #D9D6D0;
        }

        .stat-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon-green {
            background: #DCFCE7;
            color: #15803D;
        }

        .stat-icon-amber {
            background: #FEF3C7;
            color: #B45309;
        }

        .stat-icon-blue {
            background: #DBEAFE;
            color: #1D4ED8;
        }

        .stat-value {
            font-size: 38px;
            font-weight: 700;
            line-height: 1;
            color: var(--text-primary);
            letter-spacing: -0.04em;
            margin-bottom: 8px;
        }

        .stat-meta {
            font-size: 12.5px;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .stat-pct {
            font-size: 11px;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 99px;
        }

        .stat-pct-green {
            background: #DCFCE7;
            color: #15803D;
        }

        /* Progress bar */
        .stat-bar-track {
            height: 4px;
            border-radius: 99px;
            background: var(--border);
            overflow: hidden;
        }

        .stat-bar-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-bar-green {
            background: #22C55E;
        }

        /* Live indicator */
        .stat-live {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            color: #15803D;
            background: #DCFCE7;
            padding: 1px 8px;
            border-radius: 99px;
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #22C55E;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
            }

            50% {
                box-shadow: 0 0 0 4px rgba(34, 197, 94, 0);
            }
        }

        /* Chart card */
        .chart-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .chart-card-header {
            padding: 18px 22px 16px;
            border-bottom: 1px solid var(--border-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .chart-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.01em;
        }

        .chart-sub {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .chart-legend {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 2px;
        }

        .legend-dot-amber {
            background: #D97706;
        }

        .legend-dot-slate {
            background: #64748B;
        }

        .chart-body {
            padding: 22px 22px 18px;
            height: 300px;
        }

        @media (max-width: 768px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .chart-body {
                height: 240px;
            }
        }

        @media (max-width: 1024px) and (min-width: 769px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = {!! json_encode($labels) !!};
            const dataMasuk = {!! json_encode($data_masuk) !!};
            const dataKeluar = {!! json_encode($data_keluar) !!};

            const ctx = document.getElementById('trafficChart').getContext('2d');

            // Gradient fills
            const gradAmber = ctx.createLinearGradient(0, 0, 0, 280);
            gradAmber.addColorStop(0, 'rgba(217,119,6,0.18)');
            gradAmber.addColorStop(1, 'rgba(217,119,6,0)');

            const gradSlate = ctx.createLinearGradient(0, 0, 0, 280);
            gradSlate.addColorStop(0, 'rgba(100,116,139,0.12)');
            gradSlate.addColorStop(1, 'rgba(100,116,139,0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                            label: 'Kendaraan Masuk',
                            data: dataMasuk,
                            borderColor: '#D97706',
                            backgroundColor: gradAmber,
                            borderWidth: 2,
                            pointBackgroundColor: '#D97706',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4,
                        },
                        {
                            label: 'Kendaraan Keluar',
                            data: dataKeluar,
                            borderColor: '#64748B',
                            backgroundColor: gradSlate,
                            borderWidth: 2,
                            pointBackgroundColor: '#64748B',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1A1916',
                            titleColor: '#F7F6F3',
                            bodyColor: '#A09D97',
                            borderColor: '#2E2D2A',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8,
                            titleFont: {
                                family: 'DM Sans',
                                size: 12,
                                weight: '600'
                            },
                            bodyFont: {
                                family: 'DM Sans',
                                size: 12
                            },
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: '#F0EDE8',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#A09D97',
                                font: {
                                    family: 'DM Sans',
                                    size: 11
                                }
                            },
                            border: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#F0EDE8',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#A09D97',
                                font: {
                                    family: 'DM Sans',
                                    size: 11
                                },
                                maxTicksLimit: 5
                            },
                            border: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>

</x-app-layout>
