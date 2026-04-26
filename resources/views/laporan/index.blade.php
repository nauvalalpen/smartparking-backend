<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan & Export Data') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Tanggal & Tombol Export -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Mulai Tanggal</label>
                            <input type="date" name="start_date" value="{{ $start_date }}"
                                class="shadow border rounded py-2 px-3 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ $end_date }}"
                                class="shadow border rounded py-2 px-3 text-gray-700">
                        </div>
                        <div>
                            <button type="submit"
                                class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded shadow">Filter
                                Data</button>
                        </div>

                        <div class="ml-auto flex gap-2">
                            <a href="{{ route('laporan.pdf', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                                Cetak PDF
                            </a>
                            <a href="{{ route('laporan.excel', ['start_date' => $start_date, 'end_date' => $end_date]) }}"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                                Export Excel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Preview Data -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border border-gray-200">No</th>
                                <th class="px-4 py-2 border border-gray-200">Tanggal</th>
                                <th class="px-4 py-2 border border-gray-200">Lokasi Area</th>
                                <th class="px-4 py-2 border border-gray-200">Kamera CCTV</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Masuk</th>
                                <th class="px-4 py-2 border border-gray-200 text-center">Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($traffics as $index => $t)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border border-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border border-gray-200 font-semibold">{{ $t->tanggal }}</td>
                                    <td class="px-4 py-2 border border-gray-200">
                                        {{ $t->kamera->area->nama_area ?? '-' }}</td>
                                    <td class="px-4 py-2 border border-gray-200">{{ $t->kamera->nama_kamera ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 border border-gray-200 text-center font-bold text-blue-600">
                                        {{ $t->kendaraan_masuk }}</td>
                                    <td class="px-4 py-2 border border-gray-200 text-center font-bold text-red-600">
                                        {{ $t->kendaraan_keluar }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if ($traffics->isEmpty())
                        <p class="text-center text-gray-500 mt-4">Tidak ada data lalu lintas pada rentang tanggal ini.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
