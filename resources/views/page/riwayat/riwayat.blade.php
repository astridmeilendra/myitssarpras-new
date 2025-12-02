@extends('template-full')

@section('content')
<div class="flex flex-col h-full relative">
    <!-- Header -->
    <div class="bg-white px-6 py-4 border-b border-gray-100">
        <h1 class="text-2xl font-bold text-center" style="color: #013880;">Riwayat Peminjaman</h1>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-4">
        @if($peminjamans->isEmpty())
            <div class="flex flex-col items-center justify-center h-full">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500 text-lg font-medium">Belum ada riwayat peminjaman</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($peminjamans as $peminjaman)
                    @php
                        $status = $peminjaman->statusTerakhir?->nama_status ?? 'Menunggu';

                        // Tentukan styling berdasarkan status
                        $statusStyles = [
                            'Menunggu' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Akan Datang'],
                            'Disetujui' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Dalam Peminjaman'],
                            'Ditolak' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Ditolak'],
                            'Dibatalkan' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'Dibatalkan'],
                            'Selesai' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Selesai'],
                        ];

                        $currentStyle = $statusStyles[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $status];
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-medium text-gray-500">Room</span>
                                        <span class="px-2 py-0.5 {{ $currentStyle['bg'] }} {{ $currentStyle['text'] }} text-xs font-semibold rounded">
                                            {{ $currentStyle['label'] }}
                                        </span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">
                                        {{ $peminjaman->ruangan?->nama_ruangan ?? 'N/A' }}
                                    </h3>
                                </div>
                                <a href="{{ route('peminjaman.detail', $peminjaman->peminjamanid) }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" style="color: #013880;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="space-y-2 mb-3">
                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d/m/y') }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $peminjaman->nama_shift }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-600">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>{{ $peminjaman->ruangan?->kapasitas ?? 0 }} Orang</span>
                                </div>
                                @if($peminjaman->keterangan)
                                    <div class="flex items-start gap-2 text-xs text-gray-600 mt-2">
                                        <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ $peminjaman->keterangan }}</span>
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('peminjaman.detail', $peminjaman->peminjamanid) }}" class="block w-full bg-blue-600 text-white font-semibold py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm text-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="riwayat" />
</div>
@endsection
