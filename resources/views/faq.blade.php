@extends('template-full')

@section('content')
{{-- Alpine untuk accordion --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="flex flex-col h-full bg-white" x-data="{ openFaq: 1 }">
    {{-- HEADER --}}
    <div class="pt-6 pb-3 px-5">
        <h1 class="text-center text-[20px] font-bold text-[#013880] tracking-tight">Informasi</h1>
    </div>

    {{-- TAB 3 KOLOM --}}
    <div class="px-5">
        <div class="w-full max-w-[360px] mx-auto grid grid-cols-3 relative">
            {{-- garis abu --}}
            <div class="absolute bottom-0 left-0 w-full h-[1.6px] bg-[#D1D5DB]"></div>

            {{-- tab: Alur Penjelasan --}}
            <a href="{{ url('/alur-penjelasan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Alur Penjelasan
            </a>

            {{-- tab: FAQ (aktif) --}}
            <button
                class="h-10 flex items-center justify-center text-[14px] font-bold text-[#013880]">
                FAQ
            </button>

            {{-- tab: Kirim Pertanyaan --}}
            <a href="{{ url('/kirim-pertanyaan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Kirim Pertanyaan
            </a>

            {{-- garis biru di kolom ke-2 --}}
            <div class="absolute bottom-0 left-1/3 h-[3px] bg-[#013880] w-1/3 rounded-t-sm"></div>
        </div>
    </div>

    {{-- CONTENT FAQ --}}
    <div class="flex-1 overflow-y-auto px-5 pt-5 pb-28 space-y-3">
        @php
            $faqs = [
                1 => 'Bagaimana cara filter pencarian?',
                2 => 'Dimana letak ruangan Sarpras?',
                3 => 'Berapa maksimal waktu peminjaman?',
                4 => 'Apa sistem penalti saat peminjaman?',
                5 => 'Apakah peminjaman bisa dilakukan saat libur?',
            ];
        @endphp

        @foreach ($faqs as $id => $question)
            <div class="bg-white rounded-[14px]">
                <button
                    class="w-full flex items-center justify-between py-3"
                    @click="openFaq = (openFaq === {{ $id }}) ? null : {{ $id }}"
                >
                    <span class="text-[14px] text-[#1F2937] text-left pr-3">
                        {{ $question }}
                    </span>
                    {{-- icon chevron --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         :class="openFaq === {{ $id }} ? 'rotate-90 text-[#013880]' : 'text-[#C4C4C4]'"
                         class="w-4 h-4 transition-transform duration-200"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 5 7 7-7 7"/>
                    </svg>
                </button>

                {{-- jawaban --}}
                <div
                    x-show="openFaq === {{ $id }}"
                    x-collapse
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="pb-3 pr-6"
                >
                    <p class="text-[13px] text-[#4B5563] leading-relaxed">
                        Lorem ipsum dolor sit amet...
                    </p>
                </div>

            </div>
        @endforeach
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