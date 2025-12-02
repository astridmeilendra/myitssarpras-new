@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-gray-50">
    <!-- Header -->
    <div class="px-6 pt-4 pb-3 bg-white border-b border-gray-100 relative">
        <a href="{{ route('riwayat') }}" class="flex items-center text-xs text-gray-400 gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </a>

        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <h1 class="text-lg font-extrabold text-center leading-tight">
                <span class="block text-[#013880]">Detail</span>
                <span class="block text-[#013880]">Peminjaman</span>
            </h1>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-4">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">

            <!-- Info Room -->
            <div class="flex items-start justify-between mb-4">
                <div>
                    <span class="block text-xs font-medium text-gray-500 mb-0.5">Room</span>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">{{ $peminjaman->nama_ruangan }}</h2>

                    <div class="mt-3 space-y-1.5 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $peminjaman->nama_shift }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>{{ $peminjaman->kapasitas }} Orang</span>
                        </div>
                    </div>
                </div>

                <span class="px-3 py-1 rounded-full text-xs font-semibold h-fit
                    @if($statusTerakhir === 'Selesai')
                        bg-gray-100 text-gray-700
                    @elseif($statusTerakhir === 'Disetujui')
                        bg-green-100 text-green-700
                    @else
                        bg-gray-100 text-gray-700
                    @endif
                ">
                    {{ $statusTerakhir ?? 'Selesai' }}
                </span>
            </div>

            <!-- Timeline -->
            <div class="mt-4 pt-3 border-t border-gray-100">
                <div class="space-y-6">
                    @forelse($riwayatStatus as $status)
                        @php
                            $dotColor = 'bg-blue-600';
                            if ($status->nama_status === 'Ditolak') {
                                $dotColor = 'bg-red-600';
                            } elseif ($status->nama_status === 'Dibatalkan') {
                                $dotColor = 'bg-red-600';
                            } elseif ($status->nama_status === 'Menunggu') {
                                $dotColor = 'bg-yellow-400';
                            } elseif ($status->nama_status === 'Disetujui') {
                                $dotColor = 'bg-green-600';
                            } elseif ($status->nama_status === 'Selesai') {
                                $dotColor = 'bg-gray-600';
                            }
                        @endphp
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 pt-1">
                                <div class="w-3 h-3 rounded-full {{ $dotColor }}"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800">{{ $status->nama_status }}</p>
                                <p class="text-[11px] text-gray-600 mt-0.5">{{ $status->keterangan ?? 'Pengajuan peminjaman ruangan baru' }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($status->waktu_update)->format('d-m-Y / H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 text-center py-4">Belum ada riwayat status</p>
                    @endforelse
                </div>
            </div>

            <!-- Button Lihat Detail Ruangan -->
            <div class="mt-6">
                <a href="{{ route('ruangan.detail', $peminjaman->ruanganid) }}" class="w-full py-3 rounded-xl bg-blue-600 text-white text-xs font-semibold text-center hover:bg-blue-700 transition-colors">
                    Lihat Detail Ruangan
                </a>
            </div>

        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="riwayat" />
</div>
@endsection
