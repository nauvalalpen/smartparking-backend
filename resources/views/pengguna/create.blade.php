<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftarkan Akun Petugas Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengguna.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap Petugas</label>
                            <input type="text" name="nama_lengkap"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                placeholder="Misal: Budi Santoso" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Email (Untuk Login)</label>
                            <input type="email" name="email"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                placeholder="Misal: budi@security.pnp.ac.id" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Password Sementara</label>
                            <input type="password" name="password"
                                class="shadow border rounded w-full py-2 px-3 text-gray-700"
                                placeholder="Minimal 6 karakter" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                                Simpan Akun
                            </button>
                            <a href="{{ route('pengguna.index') }}" class="text-gray-500 hover:text-gray-800">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
