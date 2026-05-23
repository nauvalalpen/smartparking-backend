<x-app-layout>
    <x-slot name="header">Manajemen Kamera CCTV</x-slot>

    {{-- Page header row --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Kamera CCTV</h1>
            <p class="page-sub">Kelola seluruh kamera CCTV yang terdaftar di sistem parkir.</p>
        </div>
        <a href="{{ route('kamera.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kamera
        </a>
    </div>

    {{-- Toast success --}}
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

    {{-- Table card --}}
    <div class="card">
        @if ($kameras->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <p class="empty-title">Belum ada kamera</p>
                <p class="empty-sub">Tambahkan kamera CCTV pertama Anda untuk memulai.</p>
                <a href="{{ route('kamera.create') }}" class="btn-primary"
                    style="margin-top:16px; display:inline-flex;">
                    + Tambah Kamera
                </a>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th>Area Parkir</th>
                            <th>Nama Kamera</th>
                            <th>URL RTSP</th>
                            <th style="width:100px; text-align:center;">Status</th>
                            <th style="width:140px; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kameras as $index => $kamera)
                            <tr>
                                <td class="cell-num">{{ $index + 1 }}</td>
                                <td>
                                    <span class="area-chip">
                                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        {{ $kamera->area->nama_area ?? '—' }}
                                    </span>
                                </td>
                                <td class="cell-bold">{{ $kamera->nama_kamera }}</td>
                                <td class="cell-mono">{{ $kamera->rtsp_url }}</td>
                                <td style="text-align:center;">
                                    @if ($kamera->status == 'aktif')
                                        <span class="badge-green">Aktif</span>
                                    @else
                                        <span class="badge-red">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-row">
                                        <a href="{{ route('roi.index', $kamera->id_kamera) }}"
                                            class="btn-icon btn-icon-amber" title="Konfigurasi RoI">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 20v-4m0 4h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('kamera.edit', $kamera->id_kamera) }}"
                                            class="btn-icon btn-icon-blue" title="Edit">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('kamera.destroy', $kamera->id_kamera) }}" method="POST"
                                            onsubmit="return confirm('Hapus kamera {{ $kamera->nama_kamera }}?');"
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

        .area-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            color: var(--text-secondary);
        }
    </style>
</x-app-layout>
