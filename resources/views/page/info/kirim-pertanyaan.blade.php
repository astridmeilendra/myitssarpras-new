@extends('template-full')

@section('content')

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="flex flex-col h-full bg-white" x-data="{ openHistory: [] }">

    {{-- HEADER --}}
    <div class="pt-6 pb-3 px-5">
        <h1 class="text-center text-[20px] font-bold text-[#013880] tracking-tight">
            Informasi
        </h1>
    </div>

    {{-- SUCCESS --}}
    @if (Session::has('success'))
        <div class="mx-5 mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
            {{ Session::get('success') }}
        </div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="mx-5 mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TAB --}}
    <div class="px-5">
        <div class="w-full max-w-[360px] mx-auto grid grid-cols-3 relative">
            <div class="absolute bottom-0 left-0 w-full h-[1.6px] bg-[#D1D5DB]"></div>

            <a href="{{ url('/alur-penjelasan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Alur Penjelasan
            </a>

            <a href="{{ url('/faq') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                FAQ
            </a>

            <button class="h-10 flex items-center justify-center text-[14px] font-bold text-[#013880]">
                Kirim Pertanyaan
            </button>

            <div class="absolute bottom-0 left-2/3 w-1/3 h-[3px] bg-[#013880] rounded-t-sm"></div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto no-scrollbar px-5 pt-5 pb-28 space-y-4">

        {{-- LIST PERTANYAAN --}}
        <div>
            <p class="text-[14px] font-bold text-[#013880] mb-2">Pertanyaan Saya</p>

            <div class="space-y-2">

                @forelse ($histories as $h)
                    <div class="bg-white rounded-[14px] border border-[#E5E7EB] px-3 py-2">

                        {{-- HEADER CARD --}}
                        <button
                            class="w-full flex items-center justify-between px-4 py-2 gap-2"
                            @click="
                                openHistory.includes({{ $h->pertanyaanid }})
                                    ? openHistory = openHistory.filter(x => x !== {{ $h->pertanyaanid }})
                                    : openHistory.push({{ $h->pertanyaanid }})
                            "
                        >
                            <span
                                class="flex-1 text-[14px] text-[#111827] text-left"
                                :class="openHistory.includes({{ $h->pertanyaanid }})
                                         ? 'whitespace-normal'
                                         : 'truncate'">
                                {{ $h->isi_pertanyaan }}
                            </span>

                            {{-- ICON --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 transition-transform duration-300"
                                 :class="openHistory.includes({{ $h->pertanyaanid }})
                                         ? 'rotate-90 text-[#013880]'
                                         : 'text-[#C4C4C4]'"
                                 viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" fill="none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- DETAIL --}}
                        <div
                            x-show="openHistory.includes({{ $h->pertanyaanid }})"
                            x-collapse
                            class="pl-4 pr-6 pt-1 pb-2 space-y-2"
                        >
                            {{-- SIFAT --}}
                            <div class="flex items-center gap-2">
                                <span class="text-[12px] font-semibold text-[#6B7280]">Sifat:</span>

                                @php
                                    $badgeColor = [
                                        'rendah'   => 'bg-green-100 text-green-700',
                                        'sedang'   => 'bg-orange-100 text-orange-700',
                                        'menengah' => 'bg-red-100 text-red-700',
                                    ];
                                    $kelasSifat = $badgeColor[$h->sifat] ?? 'bg-gray-100 text-gray-700';
                                @endphp

                                <span class="text-[12px] px-2 py-1 rounded {{ $kelasSifat }}">
                                    {{ ucfirst($h->sifat ?? 'tidak diketahui') }}
                                </span>
                            </div>

                            {{-- JAWABAN --}}
                            @if ($h->jawaban)
                                <div>
                                    <p class="text-[12px] font-semibold text-[#6B7280] mb-1">Jawaban:</p>
                                    <p class="text-[13px] text-[#4B5563] leading-relaxed">
                                        {{ $h->jawaban->isi_jawaban }}
                                    </p>
                                </div>
                            @else
                                <p class="text-[13px] text-[#6B7280] italic">
                                    Belum ada jawaban dari admin.
                                </p>
                            @endif

                            {{-- LAMPIRAN --}}
                            @if ($h->lampiran)
                                @php
                                    $fileUrl = env('SUPABASE_URL') .
                                               '/storage/v1/object/public/dokumen-pertanyaan/' .
                                               ltrim($h->lampiran, '/');
                                @endphp

                                <div>
                                    <p class="text-[12px] font-semibold text-[#6B7280] mb-1">Lampiran:</p>
                                    <a href="{{ $fileUrl }}" target="_blank"
                                       class="text-[13px] text-blue-600 hover:underline">
                                        Lihat File
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                @empty
                    <p class="text-sm text-gray-500 italic">
                        Belum ada pertanyaan yang kamu buat.
                    </p>
                @endforelse

            </div>
        </div>

        <hr class="border-[#E5E7EB]">

        {{-- FORM --}}
        <div class="bg-white rounded-[18px] shadow-sm px-4 py-4">

            <p class="text-center text-[14px] font-bold text-[#013880] mb-4">
                Buat Pertanyaan
            </p>

            <form action="{{ route('pertanyaan.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- TEXTAREA --}}
                <label class="block text-[13px] text-[#111827] mb-1">
                    Pertanyaan (max. 500 kata)
                </label>
                <textarea
                    name="isi_pertanyaan"
                    required
                    maxlength="500"
                    class="w-full h-28 rounded-[10px] border border-[#E5E7EB]
                           focus:outline-none focus:ring-1 focus:ring-[#013880]
                           px-3 py-2 text-[13px] mb-3"
                    placeholder="Tulis pertanyaan kamu di sini..."></textarea>

                {{-- FILE --}}
                <label class="block text-[13px] text-[#111827] mb-1">
                    Dokumen (Opsional)
                </label>

                <label class="w-full flex items-center gap-2 border border-[#E5E7EB]
                               rounded-[10px] px-3 py-2 text-[13px] text-[#6B7280]
                               mb-3 cursor-pointer bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4 text-[#013880]" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                        <path d="M4 14.5 12 5l8 9.5"/>
                        <path d="M14 12 9.5 16.5 7 14"/>
                    </svg>
                    Unggah File
                    <input type="file" name="lampiran" class="hidden">
                </label>

                {{-- SIFAT --}}
                <p class="text-[13px] text-[#111827] mb-2">Sifat Pertanyaan</p>

                <div class="flex items-center gap-4 mb-4">
                    <label class="flex items-center gap-1 text-[13px]">
                        <input type="radio" name="sifat" value="rendah" checked class="accent-[#16A34A]">
                        <span class="text-[#16A34A]">Rendah</span>
                    </label>
                    <label class="flex items-center gap-1 text-[13px]">
                        <input type="radio" name="sifat" value="sedang" class="accent-[#F97316]">
                        <span class="text-[#F97316]">Sedang</span>
                    </label>
                    <label class="flex items-center gap-1 text-[13px]">
                        <input type="radio" name="sifat" value="menengah" class="accent-[#DC2626]">
                        <span class="text-[#DC2626]">Menengah</span>
                    </label>
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                        class="w-full bg-[#003B84] text-white rounded-[14px] h-10 text-[14px] font-semibold">
                    Kirim
                </button>
            </form>

        </div>
    </div>

    {{-- NAVBAR --}}
    <x-navbar active="info" />
</div>

@endsection