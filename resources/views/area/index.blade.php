<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Area Parkiran') }}
            </h2>
            <a href="{{ route('area.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Tambah Area
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Notifikasi Sukses -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Notifikasi Error -->
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border border-gray-200 text-left">No</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">Nama Area</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">Deskripsi</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Kapasitas</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Slot Terpakai</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Slot Tersedia</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($areas as $index => $area)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border border-gray-200 font-semibold">{{ $area->nama_area }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-sm">{{ $area->deskripsi ?? '-' }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-center font-semibold">
                                        {{ $area->kapasitas_total }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <span class="bg-red-200 text-red-800 text-xs px-3 py-1 rounded-full font-bold">
                                            {{ $area->filled_slots ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <span class="bg-green-200 text-green-800 text-xs px-3 py-1 rounded-full font-bold">
                                            {{ $area->available_slots ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <a href="{{ route('area.edit', $area->id_area) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1 px-3 rounded mr-2">
                                            Edit
                                        </a>
                                        <form action="{{ route('area.destroy', $area->id_area) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus area ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($areas->isEmpty())
                        <p class="text-center text-gray-500 mt-4">Belum ada data area parkiran.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
