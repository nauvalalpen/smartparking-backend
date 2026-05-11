<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('roi.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-bold">
                    ← Kembali ke Konfigurasi RoI
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Edit Slot Parkir: {{ $slot->nama_slot }}</h3>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('roi.update', $slot->id_slot) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-600 text-sm font-bold mb-2">Nama Slot Parkir</label>
                        <input type="text" name="nama_slot"
                            class="border-gray-300 rounded-md w-full focus:ring-blue-500" value="{{ $slot->nama_slot }}"
                            required>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-600 text-sm font-bold mb-2">Koordinat JSON</label>
                        <textarea name="koordinat_roi" rows="6"
                            class="border-gray-300 rounded-md w-full bg-white focus:ring-blue-500 font-mono text-sm" required>{{ $slot->koordinat_roi }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Format: JSON array dari koordinat titik
                            [{"x":100,"y":100},...]</p>
                    </div>

                    <div class="flex items-center justify-between gap-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('roi.index', ['kamera_id' => $slot->id_kamera]) }}"
                            class="text-gray-500 hover:text-gray-800">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
