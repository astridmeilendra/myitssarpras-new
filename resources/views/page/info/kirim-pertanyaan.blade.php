@extends('template-full')

@section('content')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    /* hilangkan tampilan scrollbar tapi tetap bisa discroll */
    .no-scrollbar {
        -ms-overflow-style: none;      /* IE dan Edge */
        scrollbar-width: none;         /* Firefox */
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;                 /* Chrome, Safari, Opera */
    }
</style>

<div class="flex flex-col h-full bg-white" x-data="{ openHistory: null }">
    {{-- HEADER --}}
    <div class="pt-6 pb-3 px-5">
        <h1 class="text-center text-[20px] font-bold text-[#013880] tracking-tight">Informasi</h1>
    </div>

    {{-- TAB 3 KOLOM --}}
    <div class="px-5">
        <div class="w-full max-w-[360px] mx-auto grid grid-cols-3 relative">
            {{-- garis abu --}}
            <div class="absolute bottom-0 left-0 w-full h-[1.6px] bg-[#D1D5DB]"></div>

            <a href="{{ url('/alur-penjelasan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Alur Penjelasan
            </a>

            <a href="{{ url('/faq') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                FAQ
            </a>

            {{-- aktif --}}
            <button class="h-10 flex items-center justify-center text-[14px] font-bold text-[#013880]">
                Kirim Pertanyaan
            </button>

            {{-- garis biru kolom ke-3 --}}
            <div class="absolute bottom-0 left-2/3 h-[3px] bg-[#013880] w-1/3 rounded-t-sm"></div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto no-scrollbar px-5 pt-5 pb-28 space-y-4">
        {{-- PERTANYAAN SAYA --}}
        <div>
            <p class="text-[14px] font-bold text-[#013880] mb-2">Pertanyaan Saya</p>

            @php
                $histories = [
                    1 => 'Bagaimana cara menyelesaikan',
                    2 => 'Apakah bisa extend jam peminjaman?',
                    3 => 'Apakah boleh membawa alat sendiri?',
                ];
            @endphp

            <div class="space-y-2">
                @foreach ($histories as $id => $q)
                    <div class="bg-white rounded-[14px] border border-[#E5E7EB] px-3 py-2">
                        <button
                            class="w-full flex items-center justify-between px-4 py-2 gap-2"
                            @click="openHistory = (openHistory === {{ $id }}) ? null : {{ $id }}"
                        >
                            <span
                                class="flex-1 text-[14px] text-[#111827] text-left"
                                :class="openHistory === {{ $id }} ? 'whitespace-normal' : 'truncate'"
                            >
                                {{ $q }}
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                :class="openHistory === {{ $id }} ? 'rotate-90 text-[#013880]' : 'text-[#C4C4C4]'"
                                class="w-4 h-4 transition-transform duration-200"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 5 7 7-7 7"/>
                            </svg>
                        </button>

                        {{-- jawaban history --}}
                        <div
                            x-show="openHistory === {{ $id }}"
                            x-collapse
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                    span        x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1"
                            class="pl-4 pr-6 pt-1 pb-2"
                        >
                            <p class="text-[13px] text-[#4B5563] leading-relaxed">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus eu dui at velit
                                ullamcorper luctus. (isi jawaban dari admin / sistem)
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="border-[#E5E7EB]">

        {{-- FORM BUAT PERTANYAAN --}}
        <div class="bg-white rounded-[18px] shadow-sm px-4 py-4">
            <p class="text-center text-[14px] font-bold text-[#013880] mb-4">Buat Pertanyaan</p>

            {{-- textarea --}}
            <label class="block text-[13px] text-[#111827] mb-1">
                Pertanyaan (max. 500 Kata)
            </label>
            <textarea
                class="w-full h-28 rounded-[10px] border border-[#E5E7EB] focus:outline-none focus:ring-1 focus:ring-[#013880] px-3 py-2 text-[13px] mb-3"
                placeholder="Tulis pertanyaan kamu di sini..."></textarea>

            {{-- upload --}}
            <label class="block text-[13px] text-[#111827] mb-1">
                Dokumen (Opsional)
            </label>
            <label
                class="w-full flex items-center gap-2 border border-[#E5E7EB] rounded-[10px] px-3 py-2 text-[13px] text-[#6B7280] mb-3 cursor-pointer bg-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#013880]" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 14.5 12 5l8 9.5"/>
                    <path d="M14 12 9.5 16.5 7 14"/>
                </svg>
                Unggah File
                <input type="file" class="hidden">
            </label>

            {{-- sifat pertanyaan --}}
            <p class="text-[13px] text-[#111827] mb-2">Sifat Pertanyaan</p>
            <div class="flex items-center gap-4 mb-4">
                <label class="flex items-center gap-1 text-[13px]">
                    <input type="radio" name="priority" value="rendah" class="accent-[#16A34A]" checked>
                    <span class="text-[#16A34A]">Rendah</span>
                </label>
                <label class="flex items-center gap-1 text-[13px]">
                    <input type="radio" name="priority" value="sedang" class="accent-[#F97316]">
                    <span class="text-[#F97316]">Sedang</span>
                </label>
                <label class="flex items-center gap-1 text-[13px]">
                    <input type="radio" name="priority" value="menengah" class="accent-[#DC2626]">
                    <span class="text-[#DC2626]">Menengah</span>
                </label>
            </div>

            {{-- button --}}
            <button
                class="w-full bg-[#003B84] text-white rounded-[14px] h-10 text-[14px] font-semibold">
                Kirim
            </button>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="info" />
</div>
@endsection