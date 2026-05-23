<x-app-layout>
    <x-slot name="header">Manajemen Petugas Keamanan</x-slot>

    {{-- Page header row --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Petugas Keamanan</h1>
            <p class="page-sub">Kelola akun petugas dan hak akses sistem parkir.</p>
        </div>
        <a href="{{ route('pengguna.create') }}" class="btn-primary">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Petugas
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
        @if ($penggunas->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM16 20H4v-2a8 8 0 0116 0z" />
                    </svg>
                </div>
                <p class="empty-title">Belum ada petugas</p>
                <p class="empty-sub">Tambahkan akun petugas keamanan pertama Anda untuk memulai.</p>
                <a href="{{ route('pengguna.create') }}" class="btn-primary"
                    style="margin-top:16px; display:inline-flex;">
                    + Tambah Petugas
                </a>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th style="width:100px; text-align:center;">Hak Akses</th>
                            <th style="width:140px; text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penggunas as $index => $user)
                            <tr>
                                <td class="cell-num">{{ $index + 1 }}</td>
                                <td class="cell-bold">{{ $user->nama_lengkap }}</td>
                                <td class="cell-mono">{{ $user->email }}</td>
                                <td style="text-align:center;">
                                    @if ($user->role === 'admin')
                                        <span class="badge-blue">Admin</span>
                                    @elseif ($user->role === 'operator')
                                        <span class="badge-green">Operator</span>
                                    @else
                                        <span class="badge-gray">{{ $user->role }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-row">
                                        <a href="{{ route('pengguna.edit', $user->id_pengguna) }}"
                                            class="btn-icon btn-icon-blue" title="Edit">
                                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('pengguna.destroy', $user->id_pengguna) }}"
                                            method="POST"
                                            onsubmit="return confirm('Hapus akun petugas {{ $user->nama_lengkap }}?');"
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

        {{-- Badge for blue role --}} .badge-blue {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #1E40AF;
            background: #DBEAFE;
            padding: 3px 9px;
            border-radius: 99px;
            white-space: nowrap;
        }

        {{-- Badge for gray role (fallback) --}} .badge-gray {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            color: var(--text-muted);
            background: var(--bg-base);
            padding: 3px 9px;
            border-radius: 99px;
            white-space: nowrap;
        }
    </style>
</x-app-layout>
