<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Laporan Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
            <form method="POST" action="{{ route('laporkan.pelanggaran') }}" enctype="multipart/form-data">
                @csrf

                <!-- Upload Foto Bukti -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Upload Foto Bukti</label>
                    <input type="file" name="bukti" accept="image/*" class="block w-full border border-gray-300 p-2 rounded-lg" />
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF hingga 10MB</p>
                </div>

                <!-- Plat Nomor -->
                <div class="mb-4">
                    <label for="plat_nomor" class="block text-sm font-medium text-gray-700">Plat Nomor</label>
                    <input type="text" name="plat_nomor" id="plat_nomor" placeholder="Contoh: B 1234 ABC"
                        class="mt-1 block w-full border border-gray-300 p-2 rounded-lg" />
                </div>

                <!-- Pasal Pelanggaran -->
                <div class="mb-4">
                    <label for="pasal" class="block text-sm font-medium text-gray-700">Pasal Pelanggaran</label>
                    <select name="pasal" id="pasal"
                        class="mt-1 block w-full border border-gray-300 p-2 rounded-lg">
                        <option value="">Pilih pasal...</option>
                        <option value="Pasal 1">Pasal 1</option>
                        <option value="Pasal 2">Pasal 2</option>
                    </select>
                </div>

                <!-- Total Denda -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Total Denda</label>
                    <div class="mt-1 p-2 bg-gray-100 rounded-lg text-gray-600">Rp 0</div>
                </div>

                <!-- Lokasi Kejadian -->
                <div class="mb-4">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" id="lokasi" placeholder="Contoh: Jl. Sudirman, Jakarta"
                        class="mt-1 block w-full border border-gray-300 p-2 rounded-lg" />
                </div>

                <!-- Tanggal & Waktu -->
                <div class="mb-6">
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal & Waktu</label>
                    <input type="datetime-local" name="tanggal" id="tanggal"
                        class="mt-1 block w-full border border-gray-300 p-2 rounded-lg" />
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-lg">
                        Submit Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

