<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Laporan Tiket') }}
            </h2>
            <a href="{{ route('laporan.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Input Pelanggaran
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('success')" />
                    
                    <!-- Header with Stats -->
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Total Laporan</p>
                                        <p class="text-2xl font-bold">{{ $reports->total() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Menunggu Review</p>
                                        <p class="text-2xl font-bold">{{ $reports->where('status', 'menunggu_verifikasi')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Diterima</p>
                                        <p class="text-2xl font-bold">{{ $reports->where('status', 'diterima')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium">Ditolak</p>
                                        <p class="text-2xl font-bold">{{ $reports->where('status', 'ditolak')->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters and Controls -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <form method="GET" action="{{ route('laporan.riwayat') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                                <select id="status" name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <!-- Per Page -->
                            <div>
                                <label for="per_page" class="block text-sm font-medium text-gray-700 mb-1">Tampilkan</label>
                                <select id="per_page" name="per_page" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 per halaman</option>
                                    <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 per halaman</option>
                                    <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per halaman</option>
                                    <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per halaman</option>
                                </select>
                            </div>

                            <!-- Apply Filters Button -->
                            <div class="flex items-end">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                                    Terapkan Filter
                                </button>
                            </div>

                            <!-- Reset Filters -->
                            <div class="flex items-end">
                                <a href="{{ route('laporan.riwayat') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md text-center transition duration-150 ease-in-out">
                                    Reset Filter
                                </a>
                            </div>
                        </form>
                    </div>
                    
                    @if($reports->count() == 0)
                        <div class="text-center py-12">
                            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada laporan ditemukan</h3>
                            <p class="mt-2 text-gray-500">
                                @if(request()->hasAny(['status', 'per_page']))
                                    Coba ubah filter atau buat laporan baru.
                                @else
                                    Anda belum memiliki laporan pelanggaran.
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('laporan.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Buat Laporan Baru
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Table -->
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gradient-to-r from-blue-600 to-blue-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Nomor Tiket
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Tanggal Input
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Plat Nomor
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Pelanggaran
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Insentif
                                            </th>
                                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($reports as $report)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                                <span class="text-sm font-medium text-blue-800">{{ substr($report->id, -2) }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900">TCK-{{ str_pad($report->id, 3, '0', STR_PAD_LEFT) }}</div>
                                                            <div class="text-sm text-gray-500">ID: {{ $report->id }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $report->created_at->format('d M Y') }}</div>
                                                    <div class="text-sm text-gray-500">{{ $report->created_at->format('H:i') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-mono font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded">
                                                        {{ $report->license_plate }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900 font-medium">{{ $report->violationRule->code }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($report->violationRule->description, 50) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
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
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($report->status == 'diterima' && $report->report_fee)
                                                        <div class="text-sm font-bold text-green-600">Rp {{ number_format($report->report_fee, 0, ',', '.') }}</div>
                                                    @elseif($report->status == 'ditolak')
                                                        <div class="text-sm font-medium text-gray-500">Rp 0</div>
                                                    @else
                                                        <div class="text-sm text-gray-400">Pending</div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('laporan.show', $report->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors duration-150">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                            </svg>
                                                        </a>
                                                        @if($report->photo_url)
                                                            <a href="{{ Storage::url($report->photo_url) }}" target="_blank" class="text-green-600 hover:text-green-900 transition-colors duration-150">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 flex justify-between sm:hidden">
                                    @if ($reports->onFirstPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $reports->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                            Previous
                                        </a>
                                    @endif

                                    @if ($reports->hasMorePages())
                                        <a href="{{ $reports->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                            Next
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                            Next
                                        </span>
                                    @endif
                                </div>

                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Menampilkan
                                            <span class="font-medium">{{ $reports->firstItem() }}</span>
                                            sampai
                                            <span class="font-medium">{{ $reports->lastItem() }}</span>
                                            dari
                                            <span class="font-medium">{{ $reports->total() }}</span>
                                            hasil
                                        </p>
                                    </div>

                                    <div>
                                        {{ $reports->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
