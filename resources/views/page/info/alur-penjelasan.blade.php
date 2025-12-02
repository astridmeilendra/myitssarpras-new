@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-white">

    {{-- HEADER --}}
    <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center mb-6 px-6 pt-6 pb-4">
        <div class="flex flex-col justify-center text-center m-auto">
            <h1 class="text-md font-bold text-[#003D82]">Informasi</h1>
        </div>
    </div>

    {{-- TAB 3 KOLOM --}}
    <div class="px-6">
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
            <a href="{{ url('/kirimpertanyaan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Kirim Pertanyaan
            </a>

            {{-- GARIS BIRU 1/3 --}}
            <div class="absolute bottom-0 left-0 h-[3px] bg-[#013880] w-1/3 rounded-t-sm"></div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto px-6 py-6 pb-28">
        {{-- Title Section --}}
        <p class="text-[14px] font-bold text-[#013880] mb-3">Alur Peminjaman</p>

        {{-- Card Alur --}}
        <div class="bg-white border border-[#E5E7EB] rounded-[18px] px-4 py-4 mb-6">
            <p class="text-[13px] text-[#1F2937]">
                Alur Peminjaman di MyITS Sarpras adalah sebagai berikut:
            </p>

            {{-- Revisi menjadi penomoran --}}
            <ol class="mt-2 space-y-1 text-[13px] text-[#1F2937] list-decimal list-outside pl-4">
                <li>Cari ruangan dan waktu yang sesuai</li>
                <li>Cek terlebih dahulu ketersediaan ruangan</li>
                <li>Apabila ruang tidak tersedia, silakan untuk mencari ruangan yang tersedia</li>
                <li>Apabila ruang tersedia, silakan untuk mengajukan peminjaman dengan prosedur yang ada</li>
            </ol>
        </div>

        {{-- Template Dokumen --}}
        <p class="text-[14px] font-bold text-[#013880] mb-3">Template Dokumen Peminjaman</p>

        {{-- Tombol Unduh --}}
        <a href="https://docs.google.com/document/d/1VUNiUJWLJphq_VvgR31ts-Momf-xsjenpGorXY8h5Yw/edit?usp=sharing"
            target="_blank"
            rel="noopener noreferrer"
            class="w-full bg-[#003B84] text-white rounded-[16px] h-11 flex items-center justify-center gap-2 text-[14px] font-semibold">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3v12m0 0 4-4m-4 4-4-4"/>
                <path d="M5 15v4h14v-4"/>
            </svg>

            Unduh Dokumen
        </a>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="info" />
</div>
@endsection
