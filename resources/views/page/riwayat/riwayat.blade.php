@extends('template-full')

@section('content')
<div class="flex flex-col h-full relative">
    <!-- Header -->
    <div class="bg-white px-6 py-4 border-b border-gray-100">
        <h1 class="text-2xl font-bold text-center" style="color: #013880;">Riwayat Peminjaman</h1>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-4">
        <div class="space-y-4">
            <!-- History Card 1 - Dalam Peminjaman (Green) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-medium text-gray-500">Room</span>
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-semibold rounded">Dalam Peminjaman</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Teater A</h3>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" style="color: #013880;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-2 mb-3">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>20/10/25 - 21/10/25</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>07.00 - 10.00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>150 Orang</span>
                        </div>
                    </div>

                    <x-button class="w-full">
                        Lihat Detail
                    </x-button>
                </div>
            </div>

            <!-- History Card 2 - Dibatalkan (Red) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-medium text-gray-500">Room</span>
                                <span class="px-2 py-0.5 bg-red-100 text-red-700 text-xs font-semibold rounded">Dibatalkan</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Tower I</h3>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-2 mb-3">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>20/10/25 - 21/10/25</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>10.15 - 12.45 WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>90 Orang</span>
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 text-white font-semibold py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- History Card 3 - Selesai -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-medium text-gray-500">Room</span>
                                <span class="px-2 py-0.5 bg-gray-100 text-gray-700 text-xs font-semibold rounded">Selesai</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Teater A</h3>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-2 mb-3">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>14/07/2025</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>16.00 - 17.00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>140 Orang</span>
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 text-white font-semibold py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Lihat Detail
                    </button>
                </div>
            </div>

            <!-- History Card 4 - Akan Datang (Yellow) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-medium text-gray-500">Room</span>
                                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-semibold rounded">Akan Datang</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Teater A</h3>
                        </div>
                        <button class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-2 mb-3">
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>20/10/25 - 21/10/25</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>13.30 - 16.00 WIB</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>190 Orang</span>
                        </div>
                    </div>

                    <button class="w-full bg-blue-600 text-white font-semibold py-2.5 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Lihat Detail
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="riwayat" />
</div>
@endsection
