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
    <div class="flex flex-col h-full overflow-y-auto scrollbar-hide pb-32">

        <!-- Header with Back Button - Sticky -->
        <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center px-6 pt-6 pb-4">
            <a href="{{ route('admin.pertanyaan.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div class="flex flex-col justify-center text-center m-auto">
                <h1 class="text-md font-bold text-[#003D82]">Detail Pertanyaan</h1>
            </div>
            <div class="w-6 h-6"></div>
        </div>


        <div class="flex flex-col px-6 py-4">
            <!-- Success Message -->
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

            <!-- Pertanyaan Detail Card -->
            <div class="bg-white border border-gray-200 rounded-lg px-4 py-4 mb-6">

                <!-- User Info -->
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-1">Dari Pengguna:</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $pertanyaan->user->nama ?? 'Unknown' }}</p>
                </div>

                <!-- Sifat Badge -->
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-xs text-gray-500">Sifat:</span>
                    @php
                        $badgeColors = [
                            'rendah' => 'bg-green-100 text-green-700 border-green-300',
                            'sedang' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                            'tinggi' => 'bg-red-100 text-red-700 border-red-300',
                            'menengah' => 'bg-red-100 text-red-700 border-red-300',
                        ];
                        $badgeClass = $badgeColors[$pertanyaan->sifat] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                    @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border {{ $badgeClass }}">
                        {{ ucfirst($pertanyaan->sifat) }}
                    </span>
                </div>

                <!-- Pertanyaan Text -->
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <p class="text-xs text-gray-500 mb-1">Pertanyaan:</p>
                    <p class="text-sm text-gray-800 leading-relaxed">{{ $pertanyaan->isi_pertanyaan }}</p>
                </div>

                <!-- Lampiran -->
                @if($pertanyaan->lampiran)
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-1">Lampiran:</p>
                        <a href="{{ $pertanyaan->lampiran }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                            </svg>
                            Lihat Lampiran
                        </a>
                    </div>
                @endif

            </div>

            <!-- Jawaban Form -->
            <div class="bg-gradient-to-br from-blue-50 to-white border border-[#DBEAFE] rounded-lg px-4 py-4 mb-6">

                <h3 class="text-base font-semibold text-[#003D82] mb-4">
                    {{ $pertanyaan->jawaban ? 'Perbarui Jawaban' : 'Berikan Jawaban' }}
                </h3>

                <form action="{{ $pertanyaan->jawaban ? route('admin.pertanyaan.update', $pertanyaan->pertanyaanid) : route('admin.pertanyaan.store', $pertanyaan->pertanyaanid) }}" method="POST">
                    @csrf
                    @if($pertanyaan->jawaban)
                        @method('PUT')
                    @endif

                    <!-- Textarea Jawaban -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-800 mb-2">
                            Jawaban (max. 2000 Kata)
                        </label>
                        <textarea
                            name="isi_jawaban"
                            id="jawaban"
                            class="w-full min-h-[150px] px-3 py-3 border border-gray-300 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent transition"
                            maxlength="2000"
                            placeholder="Tulis jawaban Anda di sini..."
                            required
                        >{{ old('isi_jawaban', $pertanyaan->jawaban->isi_jawaban ?? '') }}</textarea>
                        <div class="text-right text-xs text-gray-500 mt-1">
                            <span id="charCount">{{ strlen(old('isi_jawaban', $pertanyaan->jawaban->isi_jawaban ?? '')) }}</span>/2000
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col gap-2">
                        <x-button type="submit" variant="solid" size="md" :full="true">
                            {{ $pertanyaan->jawaban ? 'Perbarui Jawaban' : 'Kirim Jawaban' }}
                        </x-button>

                        @if($pertanyaan->jawaban)
                            <form action="{{ route('admin.pertanyaan.destroy', $pertanyaan->pertanyaanid) }}" method="POST" :full="true" onsubmit="return confirm('Hapus jawaban ini?');">
                                @csrf
                                @method('DELETE')
                                <x-button type="submit" variant="danger" size="md" :full="true">
                                    Hapus Jawaban
                                </x-button>
                            </form>
                        @endif
                    </div>
                </form>

            </div>
        </div>
    </div>
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
    // Character counter untuk jawaban
    const textarea = document.getElementById('jawaban');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
</script>

@endsection
