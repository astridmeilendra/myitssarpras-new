@extends('template-full')

@section('content')

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
</style>

<div class="flex flex-col h-full">

    <!-- Main Scrollable Content -->
    <div class="flex flex-col h-full overflow-y-auto scrollbar-hide pb-8">

        <!-- Header with Back Button - Sticky -->
        <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center px-6 pt-6 pb-4">
            <div class="flex flex-col justify-center text-center m-auto">
                <h1 class="text-md font-bold text-[#003D82]">Jawab Pertanyaan</h1>
            </div>
        </div>

        <div class="flex flex-col px-6 py-4">

        <!-- Filter Chips Section - Collapsible -->
        <div class="bg-white rounded-lg border border-gray-200 p-4 mb-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-700">Filter Pertanyaan</p>
                <button type="button" id="filterToggle" onclick="toggleFilter()" class="text-gray-500 hover:text-gray-700 transition">
                    <svg id="filterIcon" class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div id="filterContent" class="overflow-hidden transition-all duration-300 ease-in-out max-h-96" style="max-height: 0;">
                <div class="space-y-3 pt-3">
                    <!-- Sifat Filter -->
                    <div>
                        <p class="text-xs text-gray-600 font-medium mb-2">Sifat:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.pertanyaan.index') }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ !request('sifat') ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            @foreach(['rendah', 'sedang', 'tinggi', 'menengah'] as $sifat)
                                <a href="{{ route('admin.pertanyaan.index', ['sifat' => $sifat]) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('sifat') == $sifat ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                    {{ ucfirst($sifat) }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <p class="text-xs text-gray-600 font-medium mb-2">Status Jawaban:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.pertanyaan.index') }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ !request('status') ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            <a href="{{ route('admin.pertanyaan.index', ['status' => 'terjawab']) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('status') == 'terjawab' ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Terjawab
                            </a>
                            <a href="{{ route('admin.pertanyaan.index', ['status' => 'menunggu']) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('status') == 'menunggu' ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Menunggu Jawaban
                            </a>
                        </div>
                    </div>

                    <!-- Lampiran Filter -->
                    <div>
                        <p class="text-xs text-gray-600 font-medium mb-2">Lampiran:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.pertanyaan.index') }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ !request('lampiran') ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            <a href="{{ route('admin.pertanyaan.index', ['lampiran' => 'yes']) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('lampiran') == 'yes' ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Ada Lampiran
                            </a>
                            <a href="{{ route('admin.pertanyaan.index', ['lampiran' => 'no']) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('lampiran') == 'no' ? 'bg-[#003D82] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Tanpa Lampiran
                            </a>
                        </div>
                    </div>

                    <!-- Reset Button -->
                    @if(request('sifat') || request('status') || request('lampiran'))
                        <div class="pt-2 border-t border-gray-200">
                            <a href="{{ route('admin.pertanyaan.index') }}" class="inline-flex items-center px-3 py-2 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Reset Filter
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @if(session('success'))
        <div class="bg-green-50 border-2 border-green-500 text-green-800 rounded-lg px-4 py-3 mb-5 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="bg-red-50 border-2 border-red-500 text-red-800 rounded-lg px-4 py-3 mb-5 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <!-- Pertanyaan List -->
        <div class="space-y-3">
            @forelse($pertanyaan as $p)
                <a href="{{ route('admin.pertanyaan.show', $p->pertanyaanid) }}"
                   class="block bg-white border border-gray-200 rounded-lg px-4 py-4 hover:shadow-md transition">

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1">
                            <!-- User Info -->
                            <p class="text-xs text-gray-500 mb-2">Dari: <span class="font-medium text-gray-700">{{ $p->user->nama ?? 'Unknown' }}</span></p>

                            <!-- Pertanyaan -->
                            <p class="text-sm text-gray-800 mb-2 line-clamp-2">{{ $p->isi_pertanyaan }}</p>

                            <!-- Badges -->
                            <div class="flex items-center gap-2 flex-wrap">
                                <!-- Sifat Badge -->
                                @php
                                    $badgeColors = [
                                        'rendah' => 'bg-green-100 text-green-700 border-green-300',
                                        'sedang' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                        'tinggi' => 'bg-red-100 text-red-700 border-red-300',
                                        'menengah' => 'bg-red-100 text-red-700 border-red-300',
                                    ];
                                    $badgeClass = $badgeColors[$p->sifat] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border {{ $badgeClass }}">
                                    {{ ucfirst($p->sifat) }}
                                </span>

                                <!-- Status Jawaban -->
                                @if($p->jawaban)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700 border border-blue-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Terjawab
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-700 border border-orange-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                        </svg>
                                        Menunggu Jawaban
                                    </span>
                                @endif

                                <!-- File Badge -->
                                @if($p->lampiran)
                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-700 border border-purple-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                                        </svg>
                                        Ada Lampiran
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Chevron Icon -->
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
            @empty
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-gray-500 italic">Belum ada pertanyaan yang masuk</p>
                </div>
            @endforelse
        </div>

        </div>
    </div>

    <!-- Navbar Admin -->
    <x-navbar-admin active="pertanyaan" />
</div>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    function toggleFilter() {
        const filterContent = document.getElementById('filterContent');
        const filterIcon = document.getElementById('filterIcon');
        const isHidden = filterContent.style.maxHeight === '0px' || filterContent.style.maxHeight === '';

        if (isHidden) {
            // Open
            filterContent.style.maxHeight = filterContent.scrollHeight + 'px';
            filterIcon.classList.add('rotate-180');
        } else {
            // Close
            filterContent.style.maxHeight = '0px';
            filterIcon.classList.remove('rotate-180');
        }
    }

    // Show filter by default if there are active filters
    @if(request('sifat') || request('status') || request('lampiran'))
        const filterContent = document.getElementById('filterContent');
        const filterIcon = document.getElementById('filterIcon');
        filterContent.style.maxHeight = filterContent.scrollHeight + 'px';
        filterIcon.classList.add('rotate-180');
    @endif
</script>
@endsection
