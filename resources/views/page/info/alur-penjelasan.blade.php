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
            <a href="{{ url('/faq') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                FAQ
            </a>

            {{-- Tab: Kirim Pertanyaan --}}
            <a href="{{ url('/kirim-pertanyaan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Kirim Pertanyaan
            </a>

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

    <!-- Bottom Navigation -->
    <x-navbar active="info" />
</div>
@endsection