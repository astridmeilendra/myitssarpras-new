@extends('template-full')

@section('content')

<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
/* Hilangkan scroll bar */
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

/* Line clamp 2 baris */
.clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
</style>

<div class="flex flex-col h-full bg-white"
     x-data="{ openFaq: [] }">

    {{-- HEADER --}}
    <div class="pt-6 pb-3 px-5">
        <h1 class="text-center text-[20px] font-bold text-[#013880] tracking-tight">Informasi</h1>
    </div>

    {{-- TAB --}}
    <div class="px-5">
        <div class="w-full max-w-[360px] mx-auto grid grid-cols-3 relative">

            <div class="absolute bottom-0 left-0 w-full h-[1.6px] bg-[#D1D5DB]"></div>

            <a href="{{ url('/alur-penjelasan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Alur Penjelasan
            </a>

            <button class="h-10 flex items-center justify-center text-[14px] font-bold text-[#013880]">
                FAQ
            </button>

            <a href="{{ url('/kirimpertanyaan') }}"
               class="h-10 flex items-center justify-center text-[14px] font-medium text-[#3C3C3C]">
                Kirim Pertanyaan
            </a>

            <div class="absolute bottom-0 left-1/3 h-[3px] bg-[#013880] w-1/3 rounded-t-sm"></div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="flex-1 overflow-y-auto no-scrollbar px-5 pt-5 pb-4 space-y-3">

        @php
            $faqs = [
                1 => 'Bagaimana cara menggunakan filter pencarian ruangan untuk menemukan jadwal yang paling sesuai dengan kebutuhan saya?',
                2 => 'Apa saja syarat umum untuk mengajukan peminjaman ruangan melalui sistem MyITS Sarpras?',
                3 => 'Bagaimana cara membatalkan peminjaman ruangan yang sudah diajukan melalui sistem?',
                4 => 'Berapa lama maksimal durasi peminjaman ruangan dalam satu hari atau beberapa hari?',
                5 => 'Apakah saya boleh meminjam ruangan untuk beberapa hari berturut-turut dan apakah ada batasan tertentu?',
                6 => 'Apakah diperbolehkan membawa peralatan sendiri ke dalam ruangan yang dipinjam?',
                7 => 'Apa yang harus dilakukan jika terjadi kerusakan fasilitas selama masa peminjaman?',
                8 => 'Apakah ada biaya tertentu saat meminjam ruangan melalui MyITS Sarpras?',
                9 => 'Bagaimana cara mengecek status pengajuan peminjaman yang sudah saya kirimkan sebelumnya?',
                10 => 'Apakah ruangan bisa digunakan di luar jam kerja kampus, misalnya pada malam hari atau akhir pekan?',
                11 => 'Dokumen apa saja yang perlu diunggah saat mengajukan peminjaman ruangan untuk kegiatan tertentu?',
                12 => 'Kapan waktu ideal untuk mengajukan peminjaman ruangan agar peluang disetujui lebih besar?',
                13 => 'Apa konsekuensi jika saya terlambat meninggalkan ruangan pada waktu yang telah ditentukan?',
                14 => 'Apakah ruangan bisa dipinjam untuk kegiatan non-akademik seperti komunitas mahasiswa?',
                15 => 'Apa yang harus dilakukan jika ruangan yang saya inginkan selalu penuh setiap saya cek di sistem?',
            ];

            $answers = [
                1 => 'Anda dapat menggunakan filter yang tersedia untuk menemukan ruangan yang paling sesuai dengan jadwal dan kebutuhan Anda.',
                2 => 'Syarat umum: mahasiswa aktif ITS, mengisi formulir dengan benar, serta melampirkan dokumen pendukung bila diperlukan.',
                3 => 'Peminjaman dapat dibatalkan di menu Riwayat sebelum disetujui oleh admin.',
                4 => 'Durasi mengikuti shift yang berlaku, namun beberapa kegiatan dapat meminta tambahan waktu.',
                5 => 'Peminjaman beberapa hari boleh dilakukan selama ruangan tetap tersedia.',
                6 => 'Peralatan tambahan boleh dibawa selama aman dan tidak merusak fasilitas ruangan.',
                7 => 'Segera laporkan kerusakan kepada admin Sarpras untuk menghindari sanksi.',
                8 => 'Tidak ada biaya untuk peminjaman reguler.',
                9 => 'Cek status di menu Riwayat: Menunggu, Disetujui, atau Ditolak.',
                10 => 'Beberapa ruangan dapat digunakan di luar jam kerja dengan izin khusus.',
                11 => 'Umumnya diperlukan surat permohonan, proposal kegiatan, atau dokumen pendukung lainnya.',
                12 => 'Usahakan ajukan minimal 3–7 hari sebelum kegiatan.',
                13 => 'Keterlambatan dapat dikenai teguran dan pembatasan peminjaman.',
                14 => 'Ruangan dapat dipinjam untuk kegiatan non-akademik selama sesuai aturan kampus.',
                15 => 'Coba pilih tanggal/shift lain atau cari ruangan alternatif dengan kapasitas serupa.',
            ];
        @endphp

        @foreach ($faqs as $id => $question)
            <div class="bg-white rounded-[14px] border border-[#E5E7EB]">

                {{-- BUTTON --}}
                <button
                    class="w-full flex items-center justify-between py-3 px-3"
                    @click="
                        openFaq.includes({{ $id }})
                            ? openFaq = openFaq.filter(x => x !== {{ $id }})
                            : openFaq.push({{ $id }})
                    "
                >
                    {{-- QUESTION TEXT --}}
                    <span
                        class="text-[14px] text-[#1F2937] text-left pr-3"
                        :class="openFaq.includes({{ $id }}) ? '' : 'clamp-2'"
                    >
                        {{ $question }}
                    </span>

                    {{-- ICON WRAPPER --}}
                    <div class="w-6 h-6 flex items-center justify-center">

                        {{-- CLOSED → V --}}
                        <svg x-show="!openFaq.includes({{ $id }})"
                             xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 text-[#6B7280]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="2"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7" />
                        </svg>

                        {{-- OPEN → > --}}
                        <svg x-show="openFaq.includes({{ $id }})"
                             xmlns="http://www.w3.org/2000/svg"
                             class="w-6 h-6 text-[#013880]"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="2"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 5l7 7-7 7" />
                        </svg>

                    </div>
                </button>

                {{-- ANSWER --}}
                <div
                    x-show="openFaq.includes({{ $id }})"
                    x-collapse
                    class="pb-3 px-3 text-[13px] text-[#4B5563] leading-relaxed"
                >
                    {{ $answers[$id] }}
                </div>

            </div>
        @endforeach

    </div>

    <x-navbar active="info" />
</div>

@endsection