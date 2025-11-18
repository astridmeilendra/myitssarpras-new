@extends('template')

@section('content')
@php
    $statusbarTheme = 'light';
@endphp

<div class="flex flex-col h-full bg-white">
    {{-- AREA SCROLLABLE --}}
    <div class="flex-1 overflow-y-auto">

        {{-- AVATAR + NAME --}}
        <div class="pt-8 pb-4 text-center">
            {{-- Avatar gradient + icon orang --}}
            <div
                class="w-[82px] h-[82px] rounded-full bg-gradient-to-br from-[#2b78e4] via-[#5a6dfb] to-[#6f58ff]
                       mx-auto flex items-center justify-center shadow-md">
                <svg class="w-9 h-9" viewBox="0 0 24 24" fill="none">
                    {{-- kepala --}}
                    <circle cx="12" cy="8.5" r="3" fill="white"/>
                    {{-- badan --}}
                    <path d="M6.2 18.4C7.3 16.2 9.3 15 12 15s4.7 1.2 5.8 3.4"
                          fill="white"/>
                </svg>
            </div>

            {{-- Email + Nama --}}
            <div class="text-[12px] text-[#9aa8b6] italic mt-2">
                5026221191@student.its.ac.id
            </div>
            <div class="text-[18px] font-extrabold text-[#0b3a7e] mt-1">
                Ezra Bimantara
            </div>
        </div>

        {{-- MENU LIST --}}
        <div class="px-4 space-y-1 mt-4">

            {{-- Akun --}}
            <div class="flex items-center justify-between py-3 border-b border-[#eef2f6]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#f7f9fc] flex items-center justify-center text-[#1b2a49]">
                        {{-- icon orang outline --}}
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle cx="12" cy="8" r="3" stroke-width="1.7"/>
                            <path d="M6 19c1.3-2.5 3.3-3.7 6-3.7s4.7 1.2 6 3.7"
                                  stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[15px] font-semibold text-[#122b4a]">Akun</div>
                        <div class="text-[12px] text-[#97a4b5]">Ganti Password, Edit Data Akun</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-[#9aa8b6]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 6l6 6-6 6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            {{-- Riwayat Peminjaman --}}
            <div class="flex items-center justify-between py-3 border-b border-[#eef2f6]">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#f7f9fc] flex items-center justify-center text-[#1b2a49]">
                        {{-- icon history --}}
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M5 11a7 7 0 1 1 2 5" stroke-width="1.7" stroke-linecap="round"/>
                            <path d="M5 8v3h3" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 9v3l2 2" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[15px] font-semibold text-[#122b4a]">Riwayat Peminjaman</div>
                        <div class="text-[12px] text-[#97a4b5]">Lihat peminjaman yang sudah selesai</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-[#9aa8b6]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 6l6 6-6 6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            {{-- Keluar --}}
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#f7f9fc] flex items-center justify-center text-[#1b2a49]">
                        {{-- icon logout --}}
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M10 5H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3"
                                  stroke-width="1.7" stroke-linecap="round"/>
                            <path d="M14 9l3 3-3 3" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M17 12H10" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[15px] font-semibold text-[#122b4a]">Keluar</div>
                        <div class="text-[12px] text-[#97a4b5]">Keluar dari akun</div>
                    </div>
                </div>
                <svg class="w-4 h-4 text-[#9aa8b6]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M9 6l6 6-6 6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

        </div>
    </div>

    {{-- BOTTOM NAV DARI TEMPLATE --}}
    <x-navbar active="profile" />
</div>
@endsection
