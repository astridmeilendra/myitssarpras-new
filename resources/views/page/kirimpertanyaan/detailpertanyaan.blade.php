@extends('template-full')

@section('content')
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .hide-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>

<div class="flex flex-col h-full">
    <!-- Header with Back Button - Sticky -->
    <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center px-6 pt-6 pb-4">
        <a href="{{ route('kirimpertanyaan.create') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="flex flex-col justify-center text-center m-auto">
            <h1 class="text-md font-bold text-[#003D82]">Detail Pertanyaan</h1>
        </div>
        <div class="w-6 h-6"></div>
    </div>

    <!-- Content Area -->
    <div class="flex-1 overflow-y-auto px-6 py-6 hide-scrollbar">

        <!-- Badge Sifat & Status -->
        <div class="flex items-center gap-2 flex-wrap mb-5">
            @php
                $badgeColors = [
                    'rendah' => 'bg-green-100 text-green-700 border-green-300',
                    'sedang' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                    'tinggi' => 'bg-red-100 text-red-700 border-red-300',
                ];
                $badgeClass = $badgeColors[$pertanyaan->sifat] ?? 'bg-gray-100 text-gray-700 border-gray-300';
            @endphp

            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium border {{ $badgeClass }}">
                Sifat: {{ ucfirst($pertanyaan->sifat) }}
            </span>

            @if($pertanyaan->jawaban)
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-100 text-blue-700 border border-blue-300">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    Terjawab
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-orange-100 text-orange-700 border border-orange-300">
                    <svg class="w-4 h-4 mr-1.5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Menunggu Jawaban
                </span>
            @endif
        </div>

        <!-- Pertanyaan Card -->
        <div class="bg-white border border-gray-200 rounded-lg p-5 mb-5 shadow-sm">
            <div class="flex items-start gap-2 mb-3">
                <svg class="w-5 h-5 text-[#003d82] mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Pertanyaan Anda</h3>
                    <p class="text-base text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $pertanyaan->isi_pertanyaan }}</p>
                </div>
            </div>

            <!-- Lampiran -->
            @if($pertanyaan->lampiran)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-600">Lampiran</span>
                </div>

                @php
                    // Database sekarang menyimpan URL lengkap Supabase
                    $fileUrl = $pertanyaan->lampiran;

                    // Parse URL untuk ambil extension dan filename
                    $parsedUrl = parse_url($fileUrl, PHP_URL_PATH);
                    $extension = pathinfo($parsedUrl, PATHINFO_EXTENSION);
                    $filename = basename($parsedUrl);
                @endphp

                <a href="{{ $fileUrl }}"
                   target="_blank"
                   class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 hover:bg-gray-100 transition group">
                    <div class="flex-shrink-0">
                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png']))
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @elseif(strtolower($extension) === 'pdf')
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $filename }}</p>
                        <p class="text-xs text-gray-500 uppercase">{{ $extension }}</p>
                    </div>

                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#003d82] transition flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
            @endif
        </div>

        <!-- Jawaban Card -->
        @if($pertanyaan->jawaban)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 shadow-sm">
            <div class="flex items-start gap-2">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-sm font-semibold text-blue-700 mb-2">Jawaban Admin</h3>
                    <p class="text-base text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $pertanyaan->jawaban->isi_jawaban }}</p>

                    @if($pertanyaan->jawaban->created_at)
                    <p class="text-xs text-gray-500 mt-3">
                        Dijawab pada {{ \Carbon\Carbon::parse($pertanyaan->jawaban->created_at)->format('d M Y, H:i') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="bg-orange-50 border border-orange-200 rounded-lg p-5 text-center">
            <svg class="w-12 h-12 mx-auto text-orange-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-sm font-semibold text-orange-700 mb-1">Menunggu Jawaban</h3>
            <p class="text-sm text-gray-600">Pertanyaan Anda sedang dalam antrian untuk dijawab oleh admin.</p>
        </div>
        @endif

        <!-- Timestamp -->
        @if($pertanyaan->created_at)
        <div class="mt-6 pt-4 border-t border-gray-200 text-center">
            <p class="text-xs text-gray-500">
                Pertanyaan dikirim pada {{ \Carbon\Carbon::parse($pertanyaan->created_at)->format('d F Y, H:i') }} WIB
            </p>
        </div>
        @endif
    </div>
</div>
@endsection
