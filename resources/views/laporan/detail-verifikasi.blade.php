<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan Pelanggaran') }}
            </h2>
            <a href="{{ route('laporan.verifikasi') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Verifikasi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Status Summary Panel -->
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Nomor Laporan</p>
                                        <p class="text-2xl font-bold">#TCK-{{ str_pad($report->id, 3, '0', STR_PAD_LEFT) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="@if($report->status === 'menunggu_verifikasi') bg-gradient-to-r from-yellow-500 to-yellow-600 @elseif($report->status === 'diterima') bg-gradient-to-r from-green-500 to-green-600 @else bg-gradient-to-r from-red-500 to-red-600 @endif rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($report->status === 'menunggu_verifikasi')
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @elseif($report->status === 'diterima')
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Status</p>
                                        <p class="text-2xl font-bold">
                                            @if($report->status === 'menunggu_verifikasi')
                                                Menunggu
                                            @elseif($report->status === 'diterima')
                                                Diterima
                                            @else
                                                Ditolak
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Denda</p>
                                        <p class="text-2xl font-bold">Rp {{ number_format($report->violationRule->fine_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column - Report Details -->
                        <div class="space-y-6">
                            <!-- Reporter Information -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelapor</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Nama:</span>
                                        <span class="text-sm text-gray-900">{{ $report->reporter->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Email:</span>
                                        <span class="text-sm text-gray-900">{{ $report->reporter->email }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Tanggal Lapor:</span>
                                        <span class="text-sm text-gray-900">{{ $report->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Violation Details -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pelanggaran</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Plat Nomor:</span>
                                        <span class="text-sm font-bold text-gray-900">{{ $report->license_plate }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Pasal:</span>
                                        <span class="text-sm text-gray-900">{{ $report->violationRule->code }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Jenis Pelanggaran:</span>
                                        <span class="text-sm text-gray-900">{{ $report->violationRule->description }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Lokasi:</span>
                                        <span class="text-sm text-gray-900">{{ $report->location }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Tanggal Kejadian:</span>
                                        <span class="text-sm text-gray-900">{{ $report->violation_date ? $report->violation_date->format('d M Y, H:i') : 'N/A' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm font-medium text-gray-500">Jumlah Denda:</span>
                                        <span class="text-sm font-bold text-blue-600">Rp {{ number_format($report->violationRule->fine_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Verification Info -->
                            @if($report->status !== 'menunggu_verifikasi')
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Verifikasi</h3>
                                    <div class="space-y-3">
                                        @if($report->verifier)
                                            <div class="flex justify-between">
                                                <span class="text-sm font-medium text-gray-500">Diverifikasi oleh:</span>
                                                <span class="text-sm text-gray-900">{{ $report->verifier->name }}</span>
                                            </div>
                                        @endif
                                        <div class="flex justify-between">
                                            <span class="text-sm font-medium text-gray-500">Tanggal Verifikasi:</span>
                                            <span class="text-sm text-gray-900">{{ $report->updated_at->format('d M Y, H:i') }}</span>
                                        </div>
                                        @if($report->status === 'ditolak' && $report->rejection_reason)
                                            <div class="mt-4">
                                                <span class="text-sm font-medium text-gray-500">Alasan Penolakan:</span>
                                                <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md">
                                                    <p class="text-sm text-red-800">{{ $report->rejection_reason }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column - Photo and Actions -->
                        <div class="space-y-6">
                            <!-- Photo Evidence -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Bukti Foto</h3>
                                @if($report->photo_url)
                                    <div class="relative">
                                        <img src="{{ Storage::url($report->photo_url) }}" 
                                             alt="Bukti pelanggaran" 
                                             class="w-full h-64 object-cover rounded-lg shadow-md">
                                        <div class="absolute top-2 right-2">
                                            <button onclick="openImageModal()" class="bg-white bg-opacity-75 hover:bg-opacity-100 rounded-full p-2 transition-all duration-200">
                                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">Tidak ada foto</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            @if($report->status === 'menunggu_verifikasi')
                                <div class="bg-gray-50 rounded-lg p-6" x-data="{ 
                                    open: false, 
                                    reportId: {{ $report->id }}, 
                                    licensePlate: '{{ $report->license_plate }}', 
                                    rejectionReason: '',
                                    openModal() {
                                        this.open = true;
                                    },
                                    closeModal() {
                                        this.open = false;
                                        this.rejectionReason = '';
                                    }
                                }">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Verifikasi</h3>
                                    <div class="space-y-3">
                                        <!-- Approve Button -->
                                        <form action="{{ route('laporan.approve', $report->id) }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui laporan ini?')"
                                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Setujui Laporan
                                            </button>
                                        </form>
                                        
                                        <!-- Reject Button -->
                                        <button type="button" 
                                                @click="console.log('Button clicked'); openModal(); console.log('Modal should open now', open)"
                                                class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Tolak Laporan
                                        </button>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div x-show="open" 
                                         x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0"
                                         x-transition:enter-end="opacity-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100"
                                         x-transition:leave-end="opacity-0"
                                         class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                                         style="display: none;">
                                        
                                        <!-- Modal Content -->
                                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                            <div class="mt-3">
                                                <!-- Modal Header -->
                                                <div class="flex items-center justify-between mb-4">
                                                    <h3 class="text-lg font-medium text-gray-900">Tolak Laporan</h3>
                                                    <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal Body -->
                                                <div class="mb-4">
                                                    <p class="text-sm text-gray-600 mb-4">
                                                        Anda akan menolak laporan untuk kendaraan: <strong x-text="licensePlate"></strong>
                                                    </p>
                                                    
                                                    <form :action="'/laporan/' + reportId + '/reject'" method="POST">
                                                        @csrf
                                                        <div class="mb-4">
                                                            <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                                                Alasan Penolakan <span class="text-red-500">*</span>
                                                            </label>
                                                            <textarea 
                                                                id="rejection_reason" 
                                                                name="rejection_reason" 
                                                                x-model="rejectionReason"
                                                                rows="4" 
                                                                required
                                                                class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                                placeholder="Masukkan alasan penolakan laporan..."></textarea>
                                                            <p class="mt-1 text-xs text-gray-500">Minimal 10 karakter, maksimal 500 karakter</p>
                                                        </div>
                                                        
                                                        <!-- Modal Footer -->
                                                        <div class="flex justify-end space-x-3">
                                                            <button type="button" 
                                                                    @click="closeModal()"
                                                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                                Batal
                                                            </button>
                                                            <button type="submit" 
                                                                    :disabled="rejectionReason.length < 10"
                                                                    :class="rejectionReason.length < 10 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-red-700'"
                                                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                Tolak Laporan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Verifikasi</h3>
                                    <div class="text-center">
                                        @if($report->status === 'diterima')
                                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Laporan Telah Diterima
                                            </div>
                                        @else
                                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Laporan Telah Ditolak
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    @if($report->photo_url)
        <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
            <div class="relative max-w-4xl max-h-full">
                <img src="{{ Storage::url($report->photo_url) }}" 
                     alt="Bukti pelanggaran" 
                     class="max-w-full max-h-full object-contain rounded-lg">
                <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors duration-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <script>
        function openImageModal() {
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('[role="alert"]');
            alerts.forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</x-app-layout>
