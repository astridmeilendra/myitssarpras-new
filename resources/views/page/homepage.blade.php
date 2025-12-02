@extends('template-full')

@section('content')
@php
    $statusbarTheme = 'light';
@endphp

<div class="flex flex-col h-full">
    <!-- Header Section -->
    <div class="bg-white px-6 pt-3 pb-2">
        <!-- User Greeting -->
        <div class="flex items-center justify-between mt-4 mb-2">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center overflow-hidden">
                    @if(Auth::user()->foto_profile)
                        @php
                            // Handle both old path format and new full URL format
                            if (str_starts_with(Auth::user()->foto_profile, 'http')) {
                                $photoUrl = Auth::user()->foto_profile;
                            } else {
                                // Old format: construct from Supabase base URL
                                $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
                                $encodedPath = str_replace(' ', '%20', Auth::user()->foto_profile);
                                $photoUrl = "{$supabaseUrl}/storage/v1/object/public/{$encodedPath}";
                            }
                        @endphp
                        <img src="{{ $photoUrl }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                        </svg>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500">Selamat Datang,</p>
                    <h1 class="text-lg font-bold text-gray-900">
                        {{ Auth::user()->nama ?? 'Pengguna' }}
                    </h1>
                </div>
            </div>

            <!-- Notification Bell -->
            <div class="relative">
                <button class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <!-- Notification Badge -->
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex-1 overflow-y-auto px-6 pb-4 scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
        <!-- Riwayat Peminjaman Section -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4 mt-5">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-base font-bold text-gray-900">Riwayat Peminjaman</h2>
                </div>
                <a href="{{ route('riwayat') }}" class="text-xs text-gray-400 hover:text-gray-600">Lihat Semua ›</a>
            </div>

            @if($riwayat->isEmpty())
                <p class="text-xs text-gray-500">Belum ada riwayat peminjaman.</p>
            @else
                @foreach($riwayat as $item)
                    @php
                        // Mapping warna badge status
                        $status = $item->nama_status;
                        $badgeClass = 'bg-gray-100 text-gray-700';
                        if ($status === 'Menunggu') {
                            $badgeClass = 'bg-yellow-100 text-yellow-700';
                        } elseif ($status === 'Disetujui') {
                            $badgeClass = 'bg-green-100 text-green-700';
                        } elseif ($status === 'Ditolak') {
                            $badgeClass = 'bg-red-100 text-red-700';
                        } elseif ($status === 'Selesai') {
                            $badgeClass = 'bg-blue-100 text-blue-700';
                        }
                    @endphp

                    <!-- Booking Card -->
                    <a href="{{ route('peminjaman.detail', $item->peminjamanid) }}" class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Room</p>
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $item->nama_ruangan }}
                                </h3>
                            </div>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                                {{ $status }}
                            </span>
                        </div>

                        <div class="space-y-2 mb-4">
                            {{-- Tanggal --}}
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                </span>
                            </div>

                            {{-- Waktu / Shift --}}
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $item->nama_shift }}</span>
                            </div>

                            {{-- Kapasitas --}}
                            <div class="flex items-center gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>{{ $item->kapasitas ?? '-' }} Orang</span>
                            </div>

                            {{-- Keterangan singkat (opsional) --}}
                            @if($item->keterangan)
                                <div class="flex items-start gap-2 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M5 6h14M5 6a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2M5 6l2-2h10l2 2"></path>
                                    </svg>
                                    <span class="line-clamp-2">{{ $item->keterangan }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="inline-block w-full px-4 py-2 bg-[#013880] text-white text-sm font-semibold rounded-lg hover:bg-blue-900 transition-colors text-center">
                            Lihat Detail
                        </div>
                    </a>
                @endforeach
            @endif
        </div>

        <!-- Pencarian Cepat Section -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <h2 class="text-base font-bold text-gray-900">Pencarian Cepat</h2>
            </div>

            <!-- Search Form -->
            <form id="searchForm" method="GET" action="{{ route('search') }}" class="space-y-4">
                <!-- Search Input -->
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        id="searchInput"
                        placeholder="Masukkan nama ruangan..."
                        class="w-full pl-4 pr-4 py-3 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013880] focus:border-transparent transition-all"
                    >
                </div>

                <button type="submit" class="w-full px-4 py-3 bg-[#013880] text-white text-sm font-semibold rounded-lg hover:bg-blue-900 transition-colors">
                    Cari Ruangan
                </button>
            </form>
        </div>

        <!-- Informasi Lainnya Section -->
        <div class="mb-6">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-base font-bold text-gray-900">Informasi Lainnya</h2>
            </div>

            <!-- Info Cards Grid -->
            <div class="grid grid-cols-3 gap-3">
                <!-- Alur Penjelasan -->
                <a href="/alur-penjelasan" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 text-center">Alur Penjelasan</span>
                </a>

                <!-- FAQ -->
                <a href="/faq" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 text-center">FAQ</span>
                </a>

                <!-- Kirim Pertanyaan -->
                <a href="/kirimpertanyaan" class="flex flex-col items-center justify-center p-4 bg-white rounded-xl border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 text-center">Kirim Pertanyaan</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="home" />
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

@endsection
