@extends('template')

@section('content')
<div class="h-full flex flex-col bg-white">

    {{-- Bar atas + tombol kembali --}}
    <div class="px-6 pt-4">
        <a href="{{ url('/profile') }}" class="inline-flex items-center text-[12px] text-[#c3c9d4]">
            <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M15 6l-6 6 6 6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Avatar --}}
    <div class="flex flex-col items-center mt-5 mb-6">
        <div class="w-[88px] h-[88px] rounded-full bg-gradient-to-br from-[#5fa8ff] to-[#6f58ff]
                    flex items-center justify-center text-white shadow-md">
            <svg class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="9" r="3" stroke-width="1.8" />
                <path d="M6 19c1.2-2.4 3.3-3.7 6-3.7s4.8 1.3 6 3.7" stroke-width="1.8" stroke-linecap="round" />
            </svg>
        </div>

        <button
            class="mt-3 px-4 py-1.5 text-[11px] font-semibold text-[#1853c4] border border-[#d7e4ff]
                   rounded-full bg-white hover:bg-[#f4f7ff] leading-none">
            Ganti Foto
        </button>
    </div>

    {{-- FORM --}}
    <div class="px-6 space-y-5">

        {{-- Nama Lengkap --}}
        <div>
            <div class="text-[12px] font-semibold text-[#7b8ba0] mb-1.5">Nama Lengkap</div>
            <div class="h-12 rounded-[14px] border border-[#e6edf5] px-4 flex items-center gap-3
                        focus-within:border-[#2b78e4] focus-within:ring-2 focus-within:ring-[#2b78e4]/15">

                <svg class="w-4 h-4 text-[#9aa8b6]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Z" stroke-width="1.6" />
                    <path d="M5 19.4C6.3 17.3 8.7 16 12 16s5.7 1.3 7 3.4" stroke-width="1.6" stroke-linecap="round" />
                </svg>

                <input type="text"
                       class="flex-1 border-0 outline-none text-[13px] font-semibold text-[#1f2933]
                              placeholder:text-[#9aa6b2]"
                       value="Ezra Bimantara Emanateko Putra">
            </div>
        </div>

        {{-- NRP --}}
        <div>
            <div class="text-[12px] font-semibold text-[#7b8ba0] mb-1.5">NRP</div>
            <div class="h-12 rounded-[14px] bg-gradient-to-r from-[#2b78e4] via-[#5a6dfb] to-[#6f58ff] shadow-sm">
                <div class="h-full flex items-center gap-3 px-4 text-white">
                    <div class="w-9 h-9 rounded-[12px] bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="5" y="4" width="14" height="16" rx="2" stroke-width="1.6" />
                            <path d="M9 8h6M9 12h2" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </div>
                    <div class="flex-1 text-[13px] font-semibold">5026221191</div>
                    <div class="w-8 h-8 rounded-[10px] bg-white/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="6" y="11" width="12" height="8" rx="2" stroke-width="1.6" />
                            <path d="M9 11V9a3 3 0 0 1 6 0v2" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Email ITS --}}
        <div>
            <div class="text-[12px] font-semibold text-[#7b8ba0] mb-1.5">Email ITS</div>
            <div class="h-12 rounded-[14px] bg-gradient-to-r from-[#2b78e4] via-[#5a6dfb] to-[#6f58ff] shadow-sm">
                <div class="h-full flex items-center gap-3 px-4 text-white">
                    <div class="w-9 h-9 rounded-[12px] bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="4" y="5" width="16" height="14" rx="2" stroke-width="1.6" />
                            <path d="M5 7.5 12 12l7-4.5" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </div>

                    <div class="flex-1 text-[13px] font-semibold truncate">
                        5026221191@student.its.ac.id
                    </div>

                    <div class="w-8 h-8 rounded-[10px] bg-white/20 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <rect x="6" y="11" width="12" height="8" rx="2" stroke-width="1.6" />
                            <path d="M9 11V9a3 3 0 0 1 6 0v2" stroke-width="1.6" stroke-linecap="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <div class="text-[12px] font-semibold text-[#7b8ba0] mb-1.5">Nomor Telepon</div>
            <div class="h-12 rounded-[14px] bg-gradient-to-r from-[#6f58ff] via-[#5a6dfb] to-[#2b78e4] shadow-sm">
                <div class="h-full flex items-center gap-3 px-4 text-white">
                    <div class="w-9 h-9 rounded-[12px] bg-white/15 flex items-center justify-center">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M7 4h3l2 4-2 1.5a9 9 0 0 0 4.5 4.5L16 12l4 2v3a2 2 0 0 1-2 2 13 13 0 0 1-11-11 2 2 0 0 1 2-2Z"
                                  stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>

                    <input type="tel"
                           class="flex-1 bg-transparent border-0 outline-none text-[13px] font-semibold text-white placeholder:text-white/70"
                           value="08123456789">
                </div>
            </div>
        </div>

    </div>

    {{-- Tombol Bawah --}}
    <div class="mt-auto px-6 pb-6 space-y-3">
        <button
            class="w-full h-12 rounded-[14px] bg-[#0b3a7e] text-white font-bold text-[14px] hover:brightness-105">
            Simpan Perubahan
        </button>

        <button
            class="w-full h-12 rounded-[14px] bg-[#eef1f5] text-[#a5b1bd] font-semibold text-[14px]" disabled>
            Hapus Akun
        </button>
    </div>

</div>
@endsection
