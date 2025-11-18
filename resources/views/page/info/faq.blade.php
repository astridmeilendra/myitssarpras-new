@extends('template-full')

@section('content')
{{-- Alpine untuk accordion --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<div class="flex flex-col h-full bg-white" x-data="{ openFaq: null }">
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

    <!-- Bottom Navigation -->
    <x-navbar active="info" />
</div>
@endsection