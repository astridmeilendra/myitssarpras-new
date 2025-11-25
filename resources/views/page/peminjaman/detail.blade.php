@extends('template-full')

@section('content')
<div class="relative h-full">
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
    </style>

    <!-- Main Scrollable Content -->
    <div class="flex flex-col h-full overflow-y-auto scrollbar-hide">
        <!-- Header with Back Button - Sticky -->
        <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center mb-6 px-6 pt-6 pb-4">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>

            <div class="flex flex-col justify-center text-center m-auto">
                <h1 class="text-md font-bold text-[#003D82]">Detail Peminjaman</h1>
            </div>
            <div class="w-6 h-6"></div>
        </div>

        <!-- Ruangan Card -->
        <div class="px-6 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Foto Ruangan -->
                <div class="h-48 bg-gray-200 overflow-hidden">
                    @if($fotoUrl)
                        <img src="{{ $fotoUrl }}" alt="{{ $peminjaman->nama_ruangan }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-300">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Info Ruangan -->
                <div class="p-4">
                    <h2 class="text-lg font-bold text-gray-900 mb-2">{{ $peminjaman->nama_ruangan }}</h2>

                    <div class="space-y-3">
                        {{-- Lokasi --}}
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-3 h-3 text-[#013880] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-xs">{{ $peminjaman->lokasi_ruangan ?? '-' }}</span>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="flex items-center gap-3 text-gray-600">
                            <svg class="w-3 h-3 text-[#013880] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span class="text-xs">{{ $peminjaman->kapasitas }} Orang</span>
                        </div>

                        {{-- Fasilitas --}}
                        @if($peminjaman->fasilitas)
                            <div class="flex items-start gap-3 text-gray-600">
                                <svg class="w-3 h-3 text-[#013880] mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-xs">{{ $peminjaman->fasilitas }}</span>
                            </div>
                        @endif

                        {{-- Deskripsi --}}
                        @if($peminjaman->deskripsi)
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                <p class="text-xs text-gray-700">{{ $peminjaman->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Peminjaman -->
        <div class="px-6 mb-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Tanggal & Shift</h3>

                <div class="space-y-4">
                    {{-- Tanggal --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tanggal Peminjaman</p>
                            <p class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($peminjaman->tanggal)->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Shift --}}
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Shift</p>
                            <p class="text-base font-semibold text-gray-900">{{ $peminjaman->nama_shift ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterangan & Dokumen -->
        @if($peminjaman->keterangan || $peminjaman->dokumen)
            <div class="px-6 mb-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                    <h3 class="text-sm font-bold text-gray-900 mb-4">Informasi Tambahan</h3>

                    <div class="space-y-4">
                        {{-- Keterangan --}}
                        @if($peminjaman->keterangan)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Keterangan</p>
                                    <p class="text-sm text-gray-900">{{ $peminjaman->keterangan }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- Dokumen --}}
                        @if($peminjaman->dokumen && $dokumenUrl)
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Dokumen Pendukung</p>
                                    <a href="{{ $dokumenUrl }}" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:text-blue-700 underline text-sm font-medium">
                                        Lihat Dokumen
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Status & Informasi Peminjam Card -->
        <div class="px-6 mb-10">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                <!-- Sticky Header -->
                <div class="sticky top-0 bg-white border-b border-gray-100 px-4 py-4 z-10">
                    <h3 class="text-sm font-bold text-gray-900">Status & Peminjam</h3>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Timeline Riwayat Status -->
                    <div class="mb-3">
                        <h4 class="text-xs font-semibold text-gray-600 mb-4">Riwayat Status</h4>

                        <div class="space-y-0">
                            @forelse($riwayatStatus as $status)
                                <div class="flex gap-4">
                                    {{-- Timeline Dot --}}
                                    <div class="flex flex-col items-center flex-shrink-0">
                                        <div class="w-3 h-3 bg-[#013880] rounded-full mt-1"></div>
                                    </div>

                                    {{-- Status Info --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="inline-block px-2 py-0.5 text-xs font-semibold rounded-full
                                                @if($status->nama_status === 'Menunggu')
                                                    bg-yellow-100 text-yellow-700
                                                @elseif($status->nama_status === 'Disetujui')
                                                    bg-green-100 text-green-700
                                                @elseif($status->nama_status === 'Ditolak')
                                                    bg-red-100 text-red-700
                                                @elseif($status->nama_status === 'Selesai')
                                                    bg-blue-100 text-blue-700
                                                @else
                                                    bg-gray-100 text-gray-700
                                                @endif
                                            ">
                                                {{ $status->nama_status }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($status->waktu_update)->translatedFormat('d F Y H:i') }}</p>
                                        @if($status->keterangan)
                                            <p class="text-xs text-gray-700 mt-1">{{ $status->keterangan }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 text-center py-4">Belum ada riwayat status</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-3"></div>

                    <!-- Informasi Peminjam Section -->
                    <div>
                        <h4 class="text-xs font-semibold text-gray-600 mb-4">Informasi Peminjam</h4>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-gray-500">Nama</p>
                                <p class="text-sm font-medium text-gray-900">{{ $peminjaman->nama }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-sm font-medium text-gray-900 break-all">{{ $peminjaman->email_its }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">No. Telepon</p>
                                <p class="text-sm font-medium text-gray-900">{{ $peminjaman->no_telepon ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
</style>
@endsection
