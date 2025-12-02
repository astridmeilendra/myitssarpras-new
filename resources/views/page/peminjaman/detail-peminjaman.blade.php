@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-gray-50">
    <!-- Header with Back Button - Sticky -->
    <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center px-6 pt-6 pb-4">
        <a href="{{ route('riwayat') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="flex flex-col justify-center text-center m-auto">
            <h1 class="text-md font-bold text-[#003D82]">Detail Peminjaman</h1>
        </div>
        <div class="w-6 h-6"></div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-6 bg-gray-50">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
            <!-- Confirmation Modal -->
            <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-xl p-6 w-80 shadow-lg">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Peminjaman?</h3>
                    <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin membatalkan peminjaman {{ $peminjaman->nama_ruangan }}?</p>
                    <div class="flex gap-3">
                        <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <form id="cancelForm" method="POST" action="{{ route('peminjaman.cancel', $peminjaman->peminjamanid) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">
                                Batalkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Info Room -->
            <div class="flex items-start justify-between mb-4 gap-4">
                <div class="flex-1">
                    <span class="block text-xs font-medium text-gray-500 mb-0.5">Room</span>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">{{ $peminjaman->nama_ruangan }}</h2>

                    <div class="mt-3 space-y-1.5 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $peminjaman->nama_shift }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>{{ $peminjaman->kapasitas }} Orang</span>
                        </div>
                    </div>
                </div>

                <div class="flex-shrink-0 pt-1">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                        @if($statusTerakhir === 'Menunggu')
                            bg-yellow-100 text-yellow-700
                        @elseif($statusTerakhir === 'Disetujui')
                            bg-green-100 text-green-700
                        @elseif($statusTerakhir === 'Ditolak' || $statusTerakhir === 'Dibatalkan')
                            bg-red-100 text-red-700
                        @else
                            bg-gray-100 text-gray-700
                        @endif
                    ">
                        {{ $statusTerakhir ?? 'Menunggu' }}
                    </span>
                </div>
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

            <!-- Keterangan -->
            @if($peminjaman->keterangan)
                <div class="mt-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold text-gray-700 mb-1">Keterangan</p>
                    <p class="text-xs text-gray-600">{{ $peminjaman->keterangan }}</p>
                </div>
            @endif

            <!-- Dokumen -->
            @if($peminjaman->dokumen && $dokumenUrl)
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold text-gray-700 mb-2">Dokumen Pendukung</p>
                    <a href="{{ $dokumenUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-xs font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Lihat Dokumen
                    </a>
                </div>
            @endif

            <!-- Buttons - Dynamic based on status -->
            <div class="mt-6 space-y-1">
                <a href="{{ route('ruangan.detail', $peminjaman->ruanganid) }}" class="block">
                    <x-button variant="solid" size="md" :full="true">
                        Lihat Detail Ruangan
                    </x-button>
                </a>

                <!-- Only show cancel button if status is Menunggu -->
                @if($statusTerakhir === 'Menunggu')
                    <button type="button" onclick="openConfirmModal()" class="block w-full">
                        <x-button variant="danger" size="md" :full="true">
                            Batalkan Peminjaman
                        </x-button>
                    </button>
                @endif

                <!-- Show info message if status is not Menunggu -->
                @if($statusTerakhir !== 'Menunggu')
                    <div class="p-3 border rounded-lg mt-2
                        @if($statusTerakhir === 'Ditolak' || $statusTerakhir === 'Dibatalkan')
                            bg-red-50 border-red-200
                        @elseif($statusTerakhir === 'Disetujui')
                            bg-green-50 border-green-200
                        @elseif($statusTerakhir === 'Selesai')
                            bg-gray-50 border-gray-200
                        @else
                            bg-blue-50 border-blue-200
                        @endif
                    ">
                        @if($statusTerakhir === 'Ditolak' || $statusTerakhir === 'Dibatalkan')
                            <p class="text-xs text-red-700">Peminjaman ini telah {{ strtolower($statusTerakhir) }}. Hubungi Sarpras untuk informasi lebih lanjut.</p>
                        @elseif($statusTerakhir === 'Disetujui')
                            <p class="text-xs text-green-700">Peminjaman Anda telah disetujui. Silakan ambil kunci ruangan di Sarpras.</p>
                        @elseif($statusTerakhir === 'Selesai')
                            <p class="text-xs text-gray-700">Peminjaman ini telah selesai. Terima kasih telah menggunakan layanan kami.</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="riwayat" />
</div>

<script>
    function openConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeConfirmModal();
        }
    });
</script>
@endsection
