@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-white">

    {{-- HEADER --}}
    <div class="pt-6 pb-3 px-5">
        <h1 class="text-center text-[20px] font-bold text-[#013880] tracking-tight">Informasi</h1>
    </div>

    {{-- TAB 3 KOLOM --}}
    <div class="px-5">
        <div class="w-full max-w-[360px] mx-auto grid grid-cols-3 relative">
            {{-- TAB ACTIVE INDICATOR (GARIS ABU) --}}
            <div class="absolute bottom-0 left-0 w-full h-[1.6px] bg-[#D1D5DB]"></div>

            {{-- Tab: Alur Penjelasan (aktif) --}}
            <button class="h-10 flex items-center justify-center text-[14px] font-bold text-[#013880] relative">
                Alur Penjelasan
            </button>

            {{-- Tab: FAQ --}}
            <button class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                FAQ
            </button>

            {{-- Tab: Kirim Pertanyaan --}}
            <button class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Kirim Pertanyaan
            </button>

            {{-- GARIS BIRU 1/3 --}}
            <div class="absolute bottom-0 left-0 h-[3px] bg-[#013880] w-1/3 rounded-t-sm"></div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto px-5 pt-5 pb-28">
        {{-- Title Section --}}
        <p class="text-[14px] font-bold text-[#013880] mb-3">Alur Peminjaman</p>

        {{-- Card Alur --}}
        <div class="bg-white border border-[#E5E7EB] rounded-[18px] px-4 py-4 mb-6">
            <p class="text-[13px] text-[#1F2937]">
                Alur Peminjaman di MyITS Sarpras adalah sebagai berikut:
            </p>
            <ul class="mt-2 space-y-1 text-[13px] text-[#1F2937] list-disc list-inside">
                <li>Cari Ruangan dan Waktu yang Sesuai</li>
                <li>Cek Terlebih Dahulu apabila …</li>
            </ul>
        </div>

        {{-- Template Dokumen --}}
        <p class="text-[14px] font-bold text-[#013880] mb-3">Template Dokumen Peminjaman</p>

        {{-- Tombol Unduh --}}
        <button
            class="w-full bg-[#003B84] text-white rounded-[16px] h-11 flex items-center justify-center gap-2 text-[14px] font-semibold">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v12m0 0 4-4m-4 4-4-4"/>
                <path d="M5 15v4h14v-4"/>
            </svg>
            Unduh Dokumen
        </button>
    </div>

    {{-- BOTTOM NAV --}}
    <div class="h-16 w-full bg-white border-t border-[#E5E7EB] flex items-center justify-around">
        <a href="#" class="flex flex-col items-center gap-1 text-[11px] text-[#8E8E93]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6"
                 viewBox="0 0 24 24">
                <path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-4.5v-5h-5v5H5a1 1 0 0 1-1-1v-9.5Z"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Home
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-[11px] text-[#8E8E93]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6"
                 viewBox="0 0 24 24">
                <path d="M7 4h10M7 9h6M7 14h10M7 19h6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Riwayat
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-[11px] text-[#8E8E93]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6"
                 viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="4.5"/>
                <path d="m16 16 2.5 2.5" stroke-linecap="round"/>
            </svg>
            Search
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-[11px] text-[#003B84]">
            <div class="w-6 h-6 rounded-full border border-[#003B84] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor"
                     stroke-width="1.6" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 8.5v.01M11.3 11h1.1v4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            Info
        </a>
        <a href="#" class="flex flex-col items-center gap-1 text-[11px] text-[#8E8E93]">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6"
                 viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="3.5"/>
                <path d="M5.5 19.5c.5-3 3.2-5 6.5-5s6 2 6.5 5" stroke-linecap="round"/>
            </svg>
            Profile
        </a>
    </div>
</div>
@endsection