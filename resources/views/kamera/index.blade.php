<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Kamera CCTV') }}
            </h2>
            <a href="{{ route('kamera.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                + Tambah Kamera
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border border-gray-200 text-left">No</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">Area Parkir</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">Nama Kamera</th>
                                <th class="px-4 py-2 border border-gray-200 text-left">URL RTSP</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Status</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kameras as $index => $kamera)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $kamera->area->nama_area ?? 'Unknown' }}</td>
                                    <td class="px-4 py-2 border border-gray-200 font-semibold">
                                        {{ $kamera->nama_kamera }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-sm text-gray-500 break-all">
                                        {{ $kamera->rtsp_url }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        @if ($kamera->status == 'aktif')
                                            <span
                                                class="bg-green-200 text-green-800 text-xs px-2 py-1 rounded-full uppercase font-bold">Aktif</span>
                                        @else
                                            <span
                                                class="bg-red-200 text-red-800 text-xs px-2 py-1 rounded-full uppercase font-bold">Tidak
                                                Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <a href="{{ route('kamera.roi', $kamera->id_kamera) }}"
                                            class="bg-indigo-500 hover:bg-indigo-700 text-white text-xs font-bold py-1 px-3 rounded mr-2">
                                            Set RoI
                                        </a>
                                        <form action="{{ route('kamera.destroy', $kamera->id_kamera) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamera ini?');">
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
                    @if ($kameras->isEmpty())
                        <p class="text-center text-gray-500 mt-4">Belum ada data kamera CCTV.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
