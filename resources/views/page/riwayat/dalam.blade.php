@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-gray-50">

    <!-- HEADER -->
    <div class="px-6 pt-4 pb-3 bg-white border-b border-gray-100 relative">
        <button onclick="window.history.back()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <h1 class="text-lg font-extrabold text-center leading-tight text-[#013880]">
                Detail Peminjaman
            </h1>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="flex-1 overflow-y-auto px-6 py-4 space-y-4">

        {{-- CARD DETAIL PEMINJAMAN --}}
        <div class="bg-white rounded-2xl shadow-sm p-4 space-y-3">
            <div class="flex justify-between items-start gap-3">
                <div>
                    <p class="text-xs text-gray-500">ID Peminjaman</p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $peminjaman->peminjamanid ?? '-' }}
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full text-[11px] font-semibold
                             bg-[#013880]/10 text-[#013880]">
                    {{ $peminjaman->status_terkini ?? 'Dalam Proses' }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-[11px]">
                <div>
                    <p class="text-gray-500">Nama Peminjam</p>
                    <p class="font-medium text-gray-800">
                        {{ $peminjaman->nama ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Unit / Organisasi</p>
                    <p class="font-medium text-gray-800">
                        {{ $peminjaman->unit ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tanggal Peminjaman</p>
                    <p class="font-medium text-gray-800">
                        {{ $peminjaman->tanggal_mulai ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-gray-500">Tanggal Pengembalian</p>
                    <p class="font-medium text-gray-800">
                        {{ $peminjaman->tanggal_selesai ?? '-' }}
                    </p>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-100 text-[11px]">
                <p class="text-gray-500 mb-1">Keterangan</p>
                <p class="text-gray-800">
                    {{ $peminjaman->keterangan ?? '-' }}
                </p>
            </div>
        </div>

        {{-- TIMELINE STATUS --}}
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <p class="text-xs font-semibold text-gray-800 mb-2">
                Riwayat Status
            </p>

            <div class="mt-2 pt-2 border-t border-gray-100">
                <div class="space-y-6">
                    @forelse($riwayatStatus as $status)
                        @php
                            $dotColor = 'bg-[#013880]'; // Default brand color

                            if ($status->nama_status === 'Ditolak' || $status->nama_status === 'Dibatalkan') {
                                $dotColor = 'bg-red-600';
                            } elseif ($status->nama_status === 'Revisi') {
                                $dotColor = 'bg-yellow-400';
                            } elseif ($status->nama_status === 'Disetujui') {
                                $dotColor = 'bg-green-600';
                            }
                        @endphp

                        <div class="flex items-start gap-3">

                            {{-- BULLET TANPA GARIS --}}
                            <div class="flex-shrink-0 mt-[2px]">
                                <div class="w-3 h-3 rounded-full {{ $dotColor }}"></div>
                            </div>

                            {{-- TEKS STATUS --}}
                            <div class="flex justify-between items-start gap-3 w-full">
                                <div>
                                    <p class="text-xs font-semibold text-gray-800">
                                        {{ $status->nama_status }}
                                    </p>
                                    <p class="text-[11px] text-gray-600">
                                        {{ $status->keterangan ?? '-' }}
                                    </p>
                                </div>

                                <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($status->waktu_update)->format('d-m-Y / H:i') }}
                                </p>
                            </div>
                        </div>

                    @empty
                        <p class="text-xs text-gray-500 text-center">
                            Belum ada riwayat status
                        </p>
                    @endforelse
                </div>
            </div>
        </div>

                {{-- BUTTON AKSI (PURE UI, TANPA ROUTE/FORM) --}}
            <div class="mt-2 flex gap-3">
            {{-- Tombol Batalkan Peminjaman --}}
            <button type="button"
                class="w-full py-2.5 rounded-md text-sm font-semibold
                       bg-gray-100 text-gray-600 border border-gray-200">
                Batalkan Peminjaman
            </button>

            {{-- Tombol Hubungi Sarpras --}}
            <button type="button"
                class="w-full py-2.5 rounded-md text-sm font-semibold
                       bg-[#013880] text-white shadow-sm">
                Hubungi Sarpras
            </button>
        </div>
    </div>
</div>
@endsection
