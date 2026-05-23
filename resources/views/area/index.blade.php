<x-app-layout>
    <x-slot name="header">Manajemen Area Parkiran</x-slot>

    {{-- Page header row --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Area Parkiran</h1>
            <p class="page-sub">Kelola semua area parkiran dan kapasitas slotnya.</p>
        </div>
        <a href="{{ route('area.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Area
        </a>
    </div>

    {{-- Toast messages --}}
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

    @if (session('error'))
        <div class="toast-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Table card --}}
    <div class="card">
        @if ($areas->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5.5m0 0H9m0 0h-2m9.5 0v-3.375c0-.621-.504-1.125-1.125-1.125h-.871m-6.258 0H9m0 0V9m0 3.375c0 .621.504 1.125 1.125 1.125h.872m-1.125 0h6.5c.621 0 1.125-.504 1.125-1.125V9M9 21h6m0-7.5h3m0 2.25h-3m0 2.25h3" />
                    </svg>
                </div>
                <p class="empty-title">Belum ada area</p>
                <p class="empty-sub">Tambahkan area parkiran pertama Anda untuk memulai.</p>
                <a href="{{ route('area.create') }}" class="btn-primary" style="margin-top:16px; display:inline-flex;">
                    + Tambah Area
                </a>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th>Nama Area</th>
                            <th>Deskripsi</th>
                            <th style="width:90px; text-align:center;">Kapasitas</th>
                            <th style="width:90px; text-align:center;">Terpakai</th>
                            <th style="width:90px; text-align:center;">Tersedia</th>
                            <th style="width:120px; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($areas as $index => $area)
                            <tr>
                                <td class="cell-num">{{ $index + 1 }}</td>
                                <td class="cell-bold">{{ $area->nama_area }}</td>
                                <td class="cell-mono" style="max-width:200px;">{{ $area->deskripsi ?? '—' }}</td>
                                <td style="text-align:center; font-weight:600;">{{ $area->kapasitas_total }}</td>
                                <td style="text-align:center;">
                                    <span
                                        class="capacity-badge capacity-badge-used">{{ $area->filled_slots ?? 0 }}</span>
                                </td>
                                <td style="text-align:center;">
                                    <span
                                        class="capacity-badge capacity-badge-available">{{ $area->available_slots ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="action-row">
                                        <a href="{{ route('area.edit', $area->id_area) }}"
                                            class="btn-icon btn-icon-blue" title="Edit">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('area.destroy', $area->id_area) }}" method="POST"
                                            onsubmit="return confirm('Hapus area {{ $area->nama_area }}?');"
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

        .toast-error {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 12px 16px;
            border-radius: var(--radius-md);
            background: #FEF2F2;
            border: 1px solid #FECDD3;
            color: #BE123C;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .capacity-badge {
            display: inline-flex;
            align-items: center;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .capacity-badge-used {
            color: #B91C1C;
            background: #FEE2E2;
        }

        .capacity-badge-available {
            color: #15803D;
            background: #DCFCE7;
        }
    </style>
</x-app-layout>
