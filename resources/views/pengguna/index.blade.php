<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Petugas Keamanan') }}
            </h2>
            <a href="{{ route('pengguna.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Tambah Petugas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border border-gray-200 text-left">No</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">Nama Lengkap</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">Email / Username</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Hak Akses</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penggunas as $index => $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border border-gray-200 font-semibold">{{ $user->nama_lengkap }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $user->email }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <span
                                            class="bg-indigo-200 text-indigo-800 text-xs px-2 py-1 rounded-full uppercase font-bold">{{ $user->role }}</span>
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <form action="{{ route('pengguna.destroy', $user->id_pengguna) }}"
                                            method="POST" onsubmit="return confirm('Hapus akun petugas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($penggunas->isEmpty())
                        <p class="text-center text-gray-500 mt-4">Belum ada akun petugas yang didaftarkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
