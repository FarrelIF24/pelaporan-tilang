<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Form Laporan Pelanggaran') }}
            </h2>
            <a href="{{ route('laporan.riwayat') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Lihat Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('success')" />
                    
                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Header Section -->
                        <div class="text-center mb-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Laporkan Pelanggaran Lalu Lintas</h3>
                            <p class="text-gray-600">Bantu menjaga ketertiban lalu lintas dengan melaporkan pelanggaran yang Anda saksikan</p>
                        </div>

                        <!-- Photo Upload Section -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Upload Foto Bukti Pelanggaran
                            </h4>
                            <div class="mt-2 flex justify-center px-6 pt-8 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors duration-200">
                                <div class="space-y-2 text-center">
                                    <svg class="mx-auto h-16 w-16 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-3 py-1">
                                            <span>Pilih file</span>
                                            <input id="photo" name="photo" type="file" class="sr-only" accept="image/*" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                    <div class="preview-area mt-4 hidden">
                                        <img id="preview-image" class="mx-auto max-h-48 rounded-lg shadow-md" src="" alt="Preview foto">
                                        <p class="mt-2 text-sm text-green-600 font-medium">Foto berhasil dipilih</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- License Plate -->
                            <div class="space-y-2">
                                <label for="license_plate" class="block text-sm font-medium text-gray-700">
                                    Nomor Plat Kendaraan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="license_plate" name="license_plate" type="text" 
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-lg font-mono"
                                           value="{{ old('license_plate') }}" required placeholder="B 1234 ABC" maxlength="20">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Violation Rule -->
                            <div class="space-y-2">
                                <label for="violation_article_id" class="block text-sm font-medium text-gray-700">
                                    Jenis Pelanggaran <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="violation_article_id" name="violation_article_id" 
                                            class="appearance-none block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white" required>
                                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                                        @foreach($violationRules as $rule)
                                            <option value="{{ $rule->id }}" data-fine="{{ $rule->fine_amount }}" 
                                                    {{ old('violation_article_id') == $rule->id ? 'selected' : '' }}>
                                                {{ $rule->code }} - {{ $rule->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 rounded-lg pointer-events-none ring-0 ring-transparent focus-within:ring-2 focus-within:ring-opacity-50 focus-within:ring-blue-500 transition-all duration-150"></div>
                                </div>
                            </div>

                            <!-- Fine Amount Display -->
                            <div class="space-y-2">
                                <label for="fine_display" class="block text-sm font-medium text-gray-700">
                                    Jumlah Denda
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 text-lg font-medium">Rp</span>
                                    </div>
                                    <input id="fine_display" type="text" 
                                           class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm bg-gray-50 text-lg font-semibold text-green-600"
                                           value="Pilih pelanggaran terlebih dahulu" disabled>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="space-y-2">
                                <label for="location" class="block text-sm font-medium text-gray-700">
                                    Lokasi Kejadian <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="location" name="location" type="text" 
                                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('location') }}" required placeholder="Jl. Sudirman No. 123, Jakarta">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Violation Date -->
                            <div class="space-y-2">
                                <label for="violation_date" class="block text-sm font-medium text-gray-700">
                                    Tanggal Kejadian <span class="text-red-500">*</span>
                                </label>
                                <input id="violation_date" name="violation_date" type="date" 
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ old('violation_date') ?? date('Y-m-d') }}" required max="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-center pt-6">
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-lg font-semibold text-lg text-white uppercase tracking-wide hover:from-blue-700 hover:to-blue-800 active:from-blue-800 active:to-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Laporan
                            </button>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        <strong>Catatan:</strong> Pastikan foto yang Anda upload jelas dan menunjukkan bukti pelanggaran. 
                                        Laporan akan diverifikasi oleh petugas sebelum diproses lebih lanjut.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview uploaded image
            const photoInput = document.getElementById('photo');
            const previewArea = document.querySelector('.preview-area');
            const previewImage = document.getElementById('preview-image');
            
            photoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewArea.classList.remove('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewArea.classList.add('hidden');
                }
            });

            // Auto-update fine amount
            const violationSelect = document.getElementById('violation_article_id');
            const fineDisplay = document.getElementById('fine_display');

            violationSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const fineAmount = selectedOption.getAttribute('data-fine');
                if (fineAmount && fineAmount !== '') {
                    const formattedFine = new Intl.NumberFormat('id-ID').format(fineAmount);
                    fineDisplay.value = formattedFine;
                    fineDisplay.classList.remove('text-gray-500');
                    fineDisplay.classList.add('text-green-600');
                } else {
                    fineDisplay.value = 'Pilih pelanggaran terlebih dahulu';
                    fineDisplay.classList.remove('text-green-600');
                    fineDisplay.classList.add('text-gray-500');
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const photo = document.getElementById('photo').files[0];
                if (!photo) {
                    e.preventDefault();
                    alert('Silakan pilih foto bukti pelanggaran terlebih dahulu.');
                    return false;
                }
                
                // Show loading state
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Mengirim Laporan...';
            });
        });
    </script>
</x-app-layout>

