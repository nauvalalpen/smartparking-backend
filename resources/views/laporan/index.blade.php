<x-app-layout>
    <x-slot name="header">Laporan & Export Data</x-slot>

    {{-- Page header row --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Arus Lalu Lintas</h1>
            <p class="page-sub">Lihat dan ekspor data traffic dari rentang tanggal pilihan.</p>
        </div>
    </div>

    {{-- Filter & Export card --}}
    <div class="card filter-card">
        <form action="{{ route('laporan.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label class="filter-label">Mulai Tanggal</label>
                <input type="date" name="start_date" value="{{ $start_date }}" class="filter-input">
            </div>

            <div class="filter-group">
                <label class="filter-label">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $end_date }}" class="filter-input">
            </div>

            <button type="submit" class="btn-filter">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </button>

            <div class="export-actions">
                <a href="{{ route('laporan.pdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                    class="btn-export btn-export-pdf">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    PDF
                </a>
                <a href="{{ route('laporan.excel', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                    class="btn-export btn-export-excel">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
            </div>
        </form>
    </div>

    {{-- Toast success --}}
    @if (session('success'))
        <div class="toast-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Data berhasil diperbarui
        </div>
    @endif

    {{-- Data table --}}
    <div class="card">
        @if ($traffics->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <p class="empty-title">Tidak ada data</p>
                <p class="empty-sub">Tidak ada traffic data pada rentang tanggal yang dipilih.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th>Tanggal</th>
                            <th>Area Parkir</th>
                            <th>Kamera CCTV</th>
                            <th style="width:100px; text-align:center;">Masuk</th>
                            <th style="width:100px; text-align:center;">Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($traffics as $index => $t)
                            <tr>
                                <td class="cell-num">{{ $index + 1 }}</td>
                                <td class="cell-bold">{{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                                <td>
                                    <span class="traffic-chip">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $t->kamera->area->nama_area ?? '—' }}
                                    </span>
                                </td>
                                <td class="cell-mono">{{ $t->kamera->nama_kamera ?? '—' }}</td>
                                <td style="text-align:center;">
                                    <span class="traffic-badge traffic-badge-in">{{ $t->kendaraan_masuk }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <span class="traffic-badge traffic-badge-out">{{ $t->kendaraan_keluar }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @include('layouts.table-styles')

    <style>
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .page-sub {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* Filter card */
        .filter-card {
            margin-bottom: 24px;
            padding: 20px 22px;
        }

        .filter-form {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 140px;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-secondary);
            letter-spacing: 0.02em;
        }

        .filter-input {
            padding: 9px 12px;
            font-size: 13.5px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            outline: none;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .filter-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 18px;
            border-radius: var(--radius-md);
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--accent);
            border: none;
            cursor: pointer;
            transition: background 150ms ease;
        }

        .btn-filter:hover {
            background: var(--accent-hover);
        }

        .export-actions {
            display: flex;
            gap: 8px;
            margin-left: auto;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: var(--radius-md);
            font-size: 12px;
            font-weight: 600;
            color: #fff;
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: all 150ms ease;
        }

        .btn-export-pdf {
            background: #DC2626;
        }

        .btn-export-pdf:hover {
            background: #B91C1C;
        }

        .btn-export-excel {
            background: #16A34A;
        }

        .btn-export-excel:hover {
            background: #15803D;
        }

        .traffic-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--text-secondary);
        }

        .traffic-badge {
            display: inline-flex;
            align-items: center;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .traffic-badge-in {
            color: #1E40AF;
            background: #DBEAFE;
        }

        .traffic-badge-out {
            color: #B91C1C;
            background: #FEE2E2;
        }

        @media (max-width: 720px) {
            .filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                min-width: auto;
            }

            .btn-filter,
            .export-actions {
                width: 100%;
                margin-left: 0;
            }

            .export-actions {
                flex-direction: column;
            }

            .btn-export {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
</x-app-layout>
