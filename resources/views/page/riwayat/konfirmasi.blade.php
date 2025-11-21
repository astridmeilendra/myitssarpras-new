@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-gray-50">
    <!-- Header -->
    <div class="px-6 pt-4 pb-3 bg-white border-b border-gray-100 relative">
        <button onclick="window.history.back()" class="flex items-center text-xs text-gray-400 gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali</span>
        </button>

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
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">Teater A</h2>

                    <div class="mt-3 space-y-1.5 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>20/01/25 – 22/01/25</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>13.00 – 18.00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>150 Orang</span>
                        </div>
                    </div>
                </div>

                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold h-fit">
                    Dalam Peminjaman
                </span>
            </div>

            <!-- Timeline -->
            <div class="mt-4 pt-3 border-t border-gray-100">
                <div class="relative pl-10">
                    <!-- Vertical line -->
                    <div class="absolute left-4 top-0 bottom-0 w-[2px] bg-gray-200"></div>

                    <div class="space-y-6">
                        <!-- Step 1 -->
                        <div class="relative">
                            <div class="absolute left-[0.625rem] top-1 w-3 h-3 rounded-full bg-blue-700"></div>
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Permintaan Dikirim</p>
                                    <p class="text-[11px] text-gray-600">
                                        Formulir peminjaman telah dikirim oleh pengguna.
                                    </p>
                                </div>
                                <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                    02-08-2025 / 13.50
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative">
                            <div class="absolute left-[0.625rem] top-1 w-3 h-3 rounded-full bg-blue-700"></div>
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Diterima oleh Admin Sarpras</p>
                                    <p class="text-[11px] text-gray-600">
                                        Permintaan berhasil masuk dan dicatat oleh admin sarpras.
                                    </p>
                                </div>
                                <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                    03-08-2025 / 09.50
                                </p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative">
                            <div class="absolute left-[0.625rem] top-1 w-3 h-3 rounded-full bg-blue-700"></div>
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Permintaan Disetujui</p>
                                    <p class="text-[11px] text-gray-600">
                                        Admin telah menyetujui permintaan peminjaman berdasarkan
                                        ketersediaan ruangan dan dokumen.
                                    </p>
                                </div>
                                <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                    03-08-2025 / 14.30
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="relative">
                            <div class="absolute left-[0.625rem] top-1 w-3 h-3 rounded-full bg-blue-700"></div>
                            <div class="flex justify-between items-start gap-3">
                                <div>
                                    <p class="text-xs font-semibold text-gray-900">Peminjaman Berlangsung</p>
                                    <p class="text-[11px] text-gray-600">
                                        Ruangan digunakan sesuai jadwal peminjaman.
                                        Pengguna dapat menghubungi admin atau mengakhiri
                                        peminjaman lebih awal jika perlu.
                                    </p>
                                </div>
                                <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                    03-08-2025 / 15.30
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="mt-6 flex gap-3">
                <button
                    class="flex-1 py-3 rounded-xl bg-gray-100 text-xs font-semibold text-gray-400 text-center">
                    Batalkan Peminjaman
                </button>
                <button
                    class="flex-1 py-3 rounded-xl bg-[#013880] text-xs font-semibold text-white text-center">
                    Hubungi Sarpras
                </button>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="riwayat" />

    <!-- MODAL KONFIRMASI PEMBATALAN (STATE: TERBUKA) -->
    <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-40">
        <div class="bg-white rounded-2xl shadow-lg w-11/12 max-w-sm px-5 py-6">
            <!-- Logo -->
            <div class="flex justify-center mb-3">
                {{-- Ganti src dengan path logo aslimu --}}
                <img src="/img/myits-sarpras-blue.png" alt="myITS Sarana Pra-Sarana"
                     class="h-10 object-contain">
            </div>

            <!-- Title -->
            <p class="text-center text-sm font-semibold text-gray-900 mb-5">
                Konfirmasi Pembatalan
            </p>

            <!-- Buttons -->
            <div class="grid grid-cols-2 gap-3">
                <button
                    class="w-full py-2.5 rounded-full bg-red-600 text-white text-xs font-semibold">
                    Tidak
                </button>
                <button
                    class="w-full py-2.5 rounded-full bg-[#013880] text-white text-xs font-semibold">
                    Ya
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
