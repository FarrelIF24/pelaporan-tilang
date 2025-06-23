<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Laporan Pelanggaran') }}
            </h2>
            <a href="{{ route('laporan.riwayat') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Kembali ke Riwayat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Laporan</h3>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Nomor Tiket</p>
                                <p class="text-lg font-semibold">TCK-{{ str_pad($report->id, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Tanggal Laporan</p>
                                <p>{{ date('d M Y H:i', strtotime($report->created_at)) }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Plat Nomor</p>
                                <p class="font-semibold">{{ $report->license_plate }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Lokasi</p>
                                <p>{{ $report->location }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Tanggal Pelanggaran</p>
                                <p>{{ date('d M Y', strtotime($report->violation_date)) }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Pasal Pelanggaran</p>
                                <p>{{ $report->violationRule->code }}</p>
                                <p class="text-sm mt-1">{{ $report->violationRule->description }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-500">Status</p>
                                @if($report->status == 'menunggu_verifikasi')
                                    <span class="px-2 py-1 text-xs font-semibold text-blue-800 bg-blue-100 rounded-full inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu Verifikasi
                                    </span>
                                @elseif($report->status == 'diterima')
                                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Diterima
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full inline-flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                            
                            @if($report->status == 'diterima')
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Insentif Diterima</p>
                                    <p class="text-xl font-bold text-green-600">Rp {{ number_format($report->report_fee, 0, ',', '.') }}</p>
                                </div>
                                @if($report->verified_by)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500">Diverifikasi oleh</p>
                                        <p>{{ $report->verifier->name }}</p>
                                    </div>
                                @endif
                            @elseif($report->status == 'ditolak')
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Alasan Penolakan</p>
                                    <p class="text-red-600">{{ $report->rejection_reason }}</p>
                                </div>
                                @if($report->verified_by)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500">Ditolak oleh</p>
                                        <p>{{ $report->verifier->name }}</p>
                                    </div>
                                @endif
                            @endif
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Pelanggaran</h3>
                            
                            @if($report->photo_url)
                                <img src="{{ Storage::url($report->photo_url) }}" alt="Foto Pelanggaran" class="w-full rounded-lg shadow-lg">
                            @else
                                <div class="bg-gray-100 p-4 rounded text-center">
                                    <p class="text-gray-500">Tidak ada foto yang tersedia</p>
                                </div>
                            @endif
                            
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-900 mb-2">Rincian Denda</h4>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-600">Pasal {{ $report->violationRule->code }}</span>
                                        <span class="font-medium">Rp {{ number_format($report->violationRule->fine_amount, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="border-t border-gray-200 my-2"></div>
                                    <div class="flex justify-between py-2">
                                        <span class="text-gray-600 font-semibold">Total Denda</span>
                                        <span class="font-bold">Rp {{ number_format($report->violationRule->fine_amount, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
